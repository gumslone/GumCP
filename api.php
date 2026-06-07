<?php
declare(strict_types=1);

// GumCP Button API
// Execute a button by its hash:  GET /api.php?hash=<32-char-hex>
// Returns JSON: {"success":true,"output":"..."} or {"success":false,"error":"..."}
//
// No login required — the hash is the auth token.
// Accessible even when LOGIN_REQUIRED or BASIC_AUTH is enabled.

header('Content-Type: application/json; charset=UTF-8');

// Tell config.php to skip the auth gate for this request.
define('GUMCP_API_REQUEST', true);

require_once(__DIR__ . '/include/init.php');
require_once(__DIR__ . '/include/ssh.php');

define('BUTTONS_FILE', __DIR__ . '/buttons/buttons.json');
define('API_LOG_FILE', __DIR__ . '/command_logs/api_calls.log');

// ── Validate hash ─────────────────────────────────────────────────────────────
$hash = trim((string)($_REQUEST['hash'] ?? ''));

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
    http_response_code(404);
    api_log($hash, null, 'not_found', '', '');
    echo json_encode(['success' => false, 'error' => 'Button not found']);
    exit();
}

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
function api_log(string $hash, ?array $button, string $status, string $output, string $error): void {
    $log_dir = dirname(API_LOG_FILE);
    if (!is_dir($log_dir)) {
        @mkdir($log_dir, 0755, true);
    }

    $entry = json_encode([
        'time'         => date('Y-m-d H:i:s'),
        'ts'           => time(),
        'hash'         => $hash,
        'button_title' => $button['button_title'] ?? null,
        'command'      => $button['button_command'] ?? null,
        'status'       => $status,
        'output'       => $output ?: null,
        'error'        => $error  ?: null,
        'ip'           => $_SERVER['REMOTE_ADDR'] ?? null,
        'user_agent'   => $_SERVER['HTTP_USER_AGENT'] ?? null,
    ]);

    @file_put_contents(API_LOG_FILE, $entry . "\n", FILE_APPEND | LOCK_EX);
}
