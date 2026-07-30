<?php
declare(strict_types=1);

// GumCP Button API
// Execute a button by its hash. Preferred (keeps the key out of logs):
//     curl -H 'X-GumCP-Key: <32-char-hex>' http://host/GumCP/api.php
// Also supported for existing automations:
//     GET /api.php?hash=<32-char-hex>
// Returns JSON: {"success":true,"output":"..."} or {"success":false,"error":"..."}
//
// No login required — the hash IS the credential, so treat these keys like
// passwords. Accessible even when LOGIN_REQUIRED or BASIC_AUTH is enabled, and
// disabled entirely unless $gumcp_modules['button_api']['module_active'] is 1.

header('Content-Type: application/json; charset=UTF-8');

// Tell config.php to skip the auth gate for this request.
define('GUMCP_API_REQUEST', true);

require_once(__DIR__ . '/include/init.php');
require_once(__DIR__ . '/include/ssh.php');

if (empty($gumcp_modules['button_api']['module_active'])) {
    http_response_code(403);
    echo json_encode(['success' => false, 'error' => 'Button API is disabled']);
    exit();
}

define('BUTTONS_FILE', __DIR__ . '/buttons/buttons.json');
define('API_LOG_FILE', __DIR__ . '/command_logs/api_calls.log');

// ── Optional IP allow-list ────────────────────────────────────────────────────
// When $gumcp_api_allow_ips is non-empty, only those addresses/CIDR ranges may
// call the API. Checked before the hash so a wrong-network caller cannot probe
// keys at all. Uses REMOTE_ADDR only — X-Forwarded-For is caller-supplied.
$api_allow_ips = isset($gumcp_api_allow_ips) && is_array($gumcp_api_allow_ips)
    ? $gumcp_api_allow_ips
    : [];
$client_ip = gumcp_client_ip();

// ── Throttle key guessing ─────────────────────────────────────────────────────
// The hash is a 128-bit random bearer token, so guessing it is hopeless — but
// this endpoint runs shell commands without a login, and an unbounded oracle
// deserves a limit anyway. Counted under a separate key so hammering the API
// can never lock the same address out of the web login.
$throttle_key = 'api:' . $client_ip;

if (!gumcp_ip_allowed($client_ip, $api_allow_ips)) {
    api_log('', null, 'denied', '', 'IP not allowed: ' . $client_ip);
    http_response_code(403);
    echo json_encode(['success' => false, 'error' => 'Forbidden']);
    exit();
}

$api_wait = gumcp_login_locked_for($throttle_key);
if ($api_wait > 0) {
    api_log('', null, 'locked', '', 'too many unknown keys from ' . $client_ip);
    http_response_code(429);
    header('Retry-After: ' . $api_wait);
    echo json_encode(['success' => false, 'error' => 'Too many failed attempts']);
    exit();
}

// ── Validate hash ─────────────────────────────────────────────────────────────
// Prefer the X-GumCP-Key header: query strings are recorded in web-server access
// logs, browser history and Referer headers, so ?hash= writes the key to disk in
// cleartext. The query parameter stays supported for existing automations.
$hash = trim((string)($_SERVER['HTTP_X_GUMCP_KEY'] ?? ''));
if ($hash === '') {
    $hash = trim((string)($_REQUEST['hash'] ?? ''));
}

if ($hash === '' || !preg_match('/^[a-f0-9]{32}$/', $hash)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Missing or invalid hash']);
    exit();
}

// ── Load buttons ──────────────────────────────────────────────────────────────
if (!file_exists(BUTTONS_FILE)) {
    http_response_code(404);
    echo json_encode(['success' => false, 'error' => 'No buttons configured']);
    exit();
}

$buttons = json_decode((string)file_get_contents(BUTTONS_FILE), true);
if (!is_array($buttons)) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Failed to load buttons']);
    exit();
}

// ── Find button by hash ───────────────────────────────────────────────────────
$button = null;
foreach ($buttons as $b) {
    if (isset($b['button_hash']) && hash_equals($b['button_hash'], $hash)) {
        $button = $b;
        break;
    }
}

if ($button === null) {
    gumcp_login_record_failure($throttle_key);
    http_response_code(404);
    api_log($hash, null, 'not_found', '', '');
    echo json_encode(['success' => false, 'error' => 'Button not found']);
    exit();
}

gumcp_login_clear($throttle_key);

$cmd = trim($button['button_command'] ?? '');
if ($cmd === '') {
    http_response_code(422);
    api_log($hash, $button, 'no_command', '', '');
    echo json_encode(['success' => false, 'error' => 'Button has no command configured']);
    exit();
}

// ── Execute ───────────────────────────────────────────────────────────────────
$result = ssh_run($cmd);

api_log($hash, $button, $result['success'] ? 'success' : 'error',
        $result['output'] ?? '', $result['error'] ?? '');

if ($result['success']) {
    echo json_encode([
        'success' => true,
        'button'  => $button['button_title'] ?? '',
        'output'  => $result['output'],
    ]);
} else {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'button'  => $button['button_title'] ?? '',
        'error'   => $result['error'],
    ]);
}

// ── Logging ───────────────────────────────────────────────────────────────────
function api_log(string $hash, $button, string $status, string $output, string $error) {
    $log_dir = dirname(API_LOG_FILE);
    if (!is_dir($log_dir)) {
        @mkdir($log_dir, 0755, true);
    }

    $entry = json_encode([
        'time'         => date('Y-m-d H:i:s'),
        'ts'           => time(),
        // Only a prefix: the full hash executes commands with no login, so
        // writing it here would turn the log into a working credential.
        'hash'         => $hash === '' ? '' : substr($hash, 0, 8) . '…',
        'button_title' => $button['button_title'] ?? null,
        'command'      => $button['button_command'] ?? null,
        'status'       => $status,
        'output'       => $output ?: null,
        'error'        => $error  ?: null,
        'ip'           => $_SERVER['REMOTE_ADDR'] ?? null,
        'user_agent'   => $_SERVER['HTTP_USER_AGENT'] ?? null,
    ]);

    @file_put_contents(API_LOG_FILE, $entry . "\n", FILE_APPEND | LOCK_EX);
    api_log_trim();
}

/** Keep the log from filling an SD card. */
function api_log_trim(int $max_lines = 1000) {
    if (!is_file(API_LOG_FILE) || filesize(API_LOG_FILE) < 500000) return;
    $lines = @file(API_LOG_FILE, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    if (!is_array($lines) || count($lines) <= $max_lines) return;
    @file_put_contents(API_LOG_FILE, implode("\n", array_slice($lines, -$max_lines)) . "\n", LOCK_EX);
}
