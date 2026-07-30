<?php
declare(strict_types=1);

// ── Access control ────────────────────────────────────────────────────────────
// GumCP can execute arbitrary shell commands (Actions, Buttons,
// execute_command.php) as a user that is expected to have passwordless sudo, so
// the panel must never be reachable without authentication by accident.
//
// This file is SHIPPED and updated on every upgrade — unlike include/config.php,
// which is user-owned and never overwritten. The gate therefore lives here
// rather than in config.php, so security fixes actually reach existing installs.
//
// Fail closed: if no authentication method is configured, privileged access is
// refused. An administrator can opt into an open (unauthenticated) panel only by
// explicitly setting GUMCP_ALLOW_UNAUTHENTICATED to true in config.php.

/**
 * Is a usable credential configured? An enabled method with an empty password
 * does not count — that is the "fresh install, not set up yet" state, which
 * sends the admin to setup.php rather than handing out a blank login.
 */
function gumcp_auth_configured(): bool {
    if (defined('LOGIN_REQUIRED') && LOGIN_REQUIRED === true) {
        // With system checking on, the credential lives in the OS, so an empty
        // LOGIN_PASS is fine — it is not used.
        if (gumcp_check_system_user()) return true;
        if (defined('LOGIN_PASS') && LOGIN_PASS !== '') return true;
    }
    if (defined('BASIC_AUTH') && BASIC_AUTH === true
        && defined('BASIC_AUTH_PASS') && BASIC_AUTH_PASS !== '') {
        return true;
    }
    return false;
}

function gumcp_open_mode(): bool {
    return defined('GUMCP_ALLOW_UNAUTHENTICATED') && GUMCP_ALLOW_UNAUTHENTICATED === true;
}

function gumcp_session_authenticated(): bool {
    $signed_in = false;

    // Signed in against the system account: the password is never stored, so the
    // server-side session flag is the record. A client cannot forge session data.
    if (!empty($_SESSION['GUMCP_SYS_USER']) && gumcp_check_system_user()) {
        $signed_in = true;
    } elseif (defined('LOGIN_USER') && defined('LOGIN_PASS')
              && isset($_SESSION['LOGIN_USER'], $_SESSION['LOGIN_PASS'])
              && hash_equals(md5(LOGIN_USER), (string)$_SESSION['LOGIN_USER'])
              && hash_equals(md5(LOGIN_PASS), (string)$_SESSION['LOGIN_PASS'])) {
        $signed_in = true;
    }

    if (!$signed_in) return false;

    return !gumcp_session_expired();
}

/**
 * Has this session outlived its idle or absolute limit?
 *
 * A GumCP session is shell access, and the cookie lives until the browser is
 * closed — which on a desktop can be weeks. Both limits are in seconds; either
 * can be set to 0 in config.php to switch it off. Returns true (and clears the
 * session) once a limit is passed, so the caller simply treats it as signed out.
 */
function gumcp_session_expired(): bool {
    $idle     = defined('SESSION_IDLE_TIMEOUT')     ? (int)SESSION_IDLE_TIMEOUT     : 0;
    $absolute = defined('SESSION_ABSOLUTE_TIMEOUT') ? (int)SESSION_ABSOLUTE_TIMEOUT : 0;
    $now      = time();

    // Sessions that predate this feature (or an upgrade) have no stamps yet —
    // start the clock now rather than signing everyone out on deploy.
    if (empty($_SESSION['GUMCP_AUTH_TIME'])) $_SESSION['GUMCP_AUTH_TIME'] = $now;
    if (empty($_SESSION['GUMCP_LAST_SEEN'])) $_SESSION['GUMCP_LAST_SEEN'] = $now;

    $expired = ($idle     > 0 && $now - (int)$_SESSION['GUMCP_LAST_SEEN']  > $idle)
            || ($absolute > 0 && $now - (int)$_SESSION['GUMCP_AUTH_TIME']  > $absolute);

    if ($expired) {
        gumcp_end_session();
        gumcp_session_was_expired(true);
        gumcp_auth_log('expired', 'session timed out');
        return true;
    }

    // Automatic polling must not keep a session alive forever. The dashboard
    // refreshes itself every few seconds, so an unattended browser left open on
    // index.php would otherwise never go idle — exactly the case this guards.
    if (empty($_POST['gumcp_background'])) {
        $_SESSION['GUMCP_LAST_SEEN'] = $now;
    }
    return false;
}

/**
 * Remembers, for this request only, that the session was dropped because it
 * timed out — so the login page can say so instead of showing a blank form.
 */
function gumcp_session_was_expired($set = null): bool {
    static $expired = false;
    if ($set === true) $expired = true;
    return $expired;
}

/** Drop every trace of a signed-in session, keeping the session itself usable. */
function gumcp_end_session() {
    unset(
        $_SESSION['GUMCP_SYS_USER'],
        $_SESSION['LOGIN_USER'],
        $_SESSION['LOGIN_PASS'],
        $_SESSION['GUMCP_AUTH_TIME'],
        $_SESSION['GUMCP_LAST_SEEN']
    );
}

/** Stamp a freshly authenticated session so the timeouts have a starting point. */
function gumcp_mark_login_time() {
    $_SESSION['GUMCP_AUTH_TIME'] = time();
    $_SESSION['GUMCP_LAST_SEEN'] = time();
}

/**
 * Should the login form be checked against the Pi's real system account rather
 * than the LOGIN_USER / LOGIN_PASS values in config.php? Off by default, in
 * which case the login is purely a config credential.
 */
function gumcp_check_system_user(): bool {
    return defined('LOGIN_CHECK_SYSTEM_USER') && LOGIN_CHECK_SYSTEM_USER === true;
}

/**
 * Verify a login against the real system account.
 *
 * LOGIN_USER still decides WHO may sign in — the submitted username must match
 * it, so this is not an open door to every account on the box. Only the PASSWORD
 * is delegated: it is checked by authenticating to localhost over SSH, the same
 * mechanism GumCP already uses to run commands, so LOGIN_PASS is never consulted
 * and cannot drift out of sync with the real one.
 *
 * LOGIN_USER defaults to SSH_USER, so out of the box this is the account GumCP
 * runs commands as. Pointing it at a different system account is allowed but
 * deliberate: whoever signs in can then have GumCP run commands as SSH_USER, so
 * do not name an account less trusted than that one.
 */
function gumcp_system_login(string $user, string $pass): bool {
    if (!gumcp_check_system_user()) return false;
    if ($user === '' || $pass === '') return false;
    if (!defined('LOGIN_USER') || !hash_equals(LOGIN_USER, $user)) return false;
    if (!function_exists('ssh2_connect')) return false;

    $conn = @ssh2_connect('localhost', defined('SSH_PORT') ? (int)SSH_PORT : 22);
    if ($conn === false) return false;

    $ok = @ssh2_auth_password($conn, $user, $pass);
    unset($conn);
    return $ok === true;
}




// ── Authentication log ────────────────────────────────────────────────────────
// Who signed in, from where, and what failed. Without it a compromise leaves no
// trace at all: GumCP runs commands as one system user, so the web server logs
// cannot tell an intruder's session apart from the owner's. Lives in
// command_logs/, which the web server is denied.

function gumcp_auth_log_file(): string {
    return dirname(__DIR__) . '/command_logs/auth.log';
}

/**
 * Append one authentication event.
 *
 * $event is a short machine-readable key (login_ok, login_failed, locked,
 * expired, logout). Never pass a password or a token — this file records that
 * something happened, not what the secret was.
 */
function gumcp_auth_log(string $event, string $detail = '') {
    $file = gumcp_auth_log_file();
    if (!is_dir(dirname($file))) return;

    $line = sprintf(
        "%s\t%s\t%s\t%s\t%s\n",
        date('Y-m-d H:i:s'),
        $event,
        gumcp_client_ip() ?: '-',
        str_replace(["\t", "\n", "\r"], ' ', $detail) ?: '-',
        substr(str_replace(["\t", "\n", "\r"], ' ', (string)($_SERVER['HTTP_USER_AGENT'] ?? '-')), 0, 120)
    );
    @file_put_contents($file, $line, FILE_APPEND | LOCK_EX);
    gumcp_auth_log_trim($file);
}

/** Keep the log bounded — this runs on a Pi with a small SD card. */
function gumcp_auth_log_trim(string $file, int $max_lines = 500) {
    if (!is_file($file) || filesize($file) < 200000) return;
    $lines = @file($file, FILE_IGNORE_NEW_LINES);
    if (!is_array($lines) || count($lines) <= $max_lines) return;
    @file_put_contents(
        $file,
        implode("\n", array_slice($lines, -$max_lines)) . "\n",
        LOCK_EX
    );
}

/**
 * The most recent events, newest first, as
 * ['time' => ..., 'event' => ..., 'ip' => ..., 'detail' => ..., 'agent' => ...].
 */
function gumcp_auth_log_recent(int $limit = 10): array {
    $lines = @file(gumcp_auth_log_file(), FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    if (!is_array($lines)) return [];

    $out = [];
    foreach (array_reverse(array_slice($lines, -200)) as $line) {
        $f = explode("\t", $line);
        if (count($f) < 3) continue;
        $out[] = [
            'time'   => $f[0],
            'event'  => $f[1],
            'ip'     => $f[2],
            'detail' => isset($f[3]) ? $f[3] : '',
            'agent'  => isset($f[4]) ? $f[4] : '',
        ];
        if (count($out) >= $limit) break;
    }
    return $out;
}

// ── Login throttling ──────────────────────────────────────────────────────────
// A successful login grants shell access as a sudo-capable user, so unlimited
// password guessing is not acceptable — especially on a panel that ships with a
// published default password.
//
// Failures are counted per client address, so an attacker hammering the login
// cannot lock the administrator out from a different address. State lives in
// command_logs/, which is denied to the web server.

function gumcp_throttle_file(): string {
    return dirname(__DIR__) . '/command_logs/.login_attempts.json';
}

function gumcp_throttle_settings(): array {
    return [
        'max_failures' => defined('LOGIN_MAX_FAILURES') ? (int)LOGIN_MAX_FAILURES : 5,
        'window'       => defined('LOGIN_FAILURE_WINDOW') ? (int)LOGIN_FAILURE_WINDOW : 900,
        'lockout'      => defined('LOGIN_LOCKOUT_TIME') ? (int)LOGIN_LOCKOUT_TIME : 900,
    ];
}

function gumcp_throttle_load(): array {
    $raw = @file_get_contents(gumcp_throttle_file());
    if ($raw === false) return [];
    $data = json_decode($raw, true);
    return is_array($data) ? $data : [];
}

function gumcp_throttle_save(array $data) {
    $file = gumcp_throttle_file();
    if (!is_dir(dirname($file))) return;
    @file_put_contents($file, json_encode($data), LOCK_EX);
}

/**
 * Seconds the caller must wait before another attempt, or 0 when allowed.
 */
function gumcp_login_locked_for(string $ip): int {
    if ($ip === '') return 0;
    $cfg  = gumcp_throttle_settings();
    $data = gumcp_throttle_load();
    if (empty($data[$ip])) return 0;

    $entry = $data[$ip];
    $count = (int)($entry['count'] ?? 0);
    $last  = (int)($entry['last'] ?? 0);

    if ($count < $cfg['max_failures']) return 0;
    $remaining = ($last + $cfg['lockout']) - time();
    return $remaining > 0 ? $remaining : 0;
}

function gumcp_login_record_failure(string $ip) {
    if ($ip === '') return;
    $cfg  = gumcp_throttle_settings();
    $now  = time();
    $data = gumcp_throttle_load();

    // Drop entries that are no longer relevant, so the file cannot grow forever.
    foreach ($data as $key => $entry) {
        $last = (int)($entry['last'] ?? 0);
        if ($now - $last > max($cfg['window'], $cfg['lockout']) * 2) {
            unset($data[$key]);
        }
    }

    $count = (int)($data[$ip]['count'] ?? 0);
    $last  = (int)($data[$ip]['last'] ?? 0);
    // Outside the window the streak has expired: start counting again.
    if ($now - $last > $cfg['window']) $count = 0;

    $data[$ip] = ['count' => $count + 1, 'last' => $now];
    gumcp_throttle_save($data);
}

function gumcp_login_clear(string $ip) {
    if ($ip === '') return;
    $data = gumcp_throttle_load();
    if (isset($data[$ip])) {
        unset($data[$ip]);
        gumcp_throttle_save($data);
    }
}

/**
 * Handle a submitted login form. Lives here rather than in the user-owned
 * config.php so it can be fixed by an upgrade, and uses gumcp_-prefixed field
 * names so the legacy login block still present in older config.php files never
 * fires (it would exit() on a system-account password before we got here).
 *
 * Called from include/init.php before the access gate, so a just-authenticated
 * session is visible to it.
 */
function gumcp_process_login() {
    if (empty($_POST['gumcp_login_user']) || empty($_POST['gumcp_login_pass'])) return;

    // Refuse before checking anything, so a locked-out client cannot keep
    // guessing — and cannot use response timing to probe validity either.
    $ip = gumcp_client_ip();
    $wait = gumcp_login_locked_for($ip);
    if ($wait > 0) {
        gumcp_auth_log('locked', 'attempt while locked out');
        header('Location: ./login.php?action=locked&wait=' . $wait);
        exit();
    }

    $user = (string)$_POST['gumcp_login_user'];
    $pass = (string)$_POST['gumcp_login_pass'];

    $valid_csrf = isset($_SESSION['csrf_token'])
               && hash_equals($_SESSION['csrf_token'], (string)($_POST['csrf_token'] ?? ''));

    if ($valid_csrf) {
        // Against the real system account, when that mode is switched on…
        if (gumcp_system_login($user, $pass)) {
            gumcp_login_clear($ip);
            session_regenerate_id(true);          // prevent session fixation
            $_SESSION['GUMCP_SYS_USER'] = $user;
            gumcp_mark_login_time();
            gumcp_auth_log('login_ok', 'system account: ' . $user);
            header('Location: ./index.php');
            exit();
        }
        // …otherwise against the credentials configured in config.php.
        if (!gumcp_check_system_user()
            && defined('LOGIN_USER') && defined('LOGIN_PASS')
            && hash_equals(LOGIN_USER, $user) && hash_equals(LOGIN_PASS, $pass)) {
            gumcp_login_clear($ip);
            session_regenerate_id(true);
            $_SESSION['LOGIN_USER'] = md5(LOGIN_USER);
            $_SESSION['LOGIN_PASS'] = md5(LOGIN_PASS);
            gumcp_mark_login_time();
            gumcp_auth_log('login_ok', 'config account: ' . $user);
            header('Location: ./index.php');
            exit();
        }
    }

    gumcp_login_record_failure($ip);
    // The username is logged; the password never is.
    gumcp_auth_log('login_failed', $valid_csrf ? 'user: ' . $user : 'stale CSRF token');
    header('Location: ./login.php?action=incorrect_login');
    exit();
}

function gumcp_basic_authenticated(): bool {
    if (!defined('BASIC_AUTH') || BASIC_AUTH !== true) return false;

    $user = (string)($_SERVER['PHP_AUTH_USER'] ?? '');
    $pass = (string)($_SERVER['PHP_AUTH_PW']   ?? '');

    // Apache may strip the Authorization header; fall back to parsing it.
    if ($user === '' && isset($_SERVER['HTTP_AUTHORIZATION'])) {
        $decoded = base64_decode(ltrim(substr((string)$_SERVER['HTTP_AUTHORIZATION'], 6)));
        if ($decoded !== false && strpos($decoded, ':') !== false) {
            list($user, $pass) = explode(':', $decoded, 2);
        }
    }

    // No credentials offered yet — that is the normal first request, not a
    // failed guess, so it must not count towards the lockout.
    if ($user === '') return false;

    // Same throttle as the login form: Basic Auth would otherwise be an
    // unlimited password-guessing channel to the same privileges.
    $ip = gumcp_client_ip();
    if (gumcp_login_locked_for($ip) > 0) return false;

    if (hash_equals(BASIC_AUTH_USER, $user) && hash_equals(BASIC_AUTH_PASS, $pass)) {
        gumcp_login_clear($ip);
        return true;
    }
    gumcp_login_record_failure($ip);
    return false;
}

function gumcp_is_authenticated(): bool {
    return gumcp_session_authenticated() || gumcp_basic_authenticated();
}

/**
 * True when the configured login/Basic Auth credentials are still the shipped
 * defaults — surfaced as a warning in the UI and by System Check.
 */
function gumcp_default_credentials(): bool {
    // Not applicable when the login is checked against the system account:
    // LOGIN_PASS is unused there, so its value says nothing about security.
    if (defined('LOGIN_REQUIRED') && LOGIN_REQUIRED === true
        && !gumcp_check_system_user()
        && defined('LOGIN_PASS') && LOGIN_PASS === 'raspberry') {
        return true;
    }
    if (defined('BASIC_AUTH') && BASIC_AUTH === true
        && defined('BASIC_AUTH_PASS') && BASIC_AUTH_PASS === 'secret') {
        return true;
    }
    return false;
}

/**
 * Is $ip covered by $allow (a list of plain IPs and/or IPv4 CIDR ranges)?
 * An empty list means "no restriction configured" and allows everything.
 */
function gumcp_ip_allowed(string $ip, array $allow): bool {
    $entries = array_filter(array_map('trim', array_map('strval', $allow)), 'strlen');
    if (empty($entries)) return true;

    foreach ($entries as $entry) {
        if (strpos($entry, '/') !== false) {
            if (gumcp_cidr_match($ip, $entry)) return true;
        } elseif ($ip === $entry) {
            return true;
        }
    }
    return false;
}

/**
 * IPv4 CIDR membership test, e.g. gumcp_cidr_match('192.168.1.7', '192.168.1.0/24').
 */
function gumcp_cidr_match(string $ip, string $cidr): bool {
    if (strpos($cidr, '/') === false) return false;
    list($subnet, $bits) = explode('/', $cidr, 2);

    if (!filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) return false;
    if (!filter_var($subnet, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) return false;
    if (!preg_match('/^\d{1,2}$/', $bits)) return false;

    $bits = (int)$bits;
    if ($bits < 0 || $bits > 32) return false;
    if ($bits === 0) return true;

    $ip_long     = ip2long($ip)     & 0xFFFFFFFF;
    $subnet_long = ip2long($subnet) & 0xFFFFFFFF;
    $mask        = (0xFFFFFFFF << (32 - $bits)) & 0xFFFFFFFF;

    return ($ip_long & $mask) === ($subnet_long & $mask);
}

/**
 * The peer address for access decisions. Deliberately uses REMOTE_ADDR only:
 * X-Forwarded-For is caller-supplied and trivially spoofed, so trusting it here
 * would let anyone bypass an IP allow-list by setting a header.
 */
function gumcp_client_ip(): string {
    return (string)($_SERVER['REMOTE_ADDR'] ?? '');
}

/**
 * Does the current request expect JSON rather than an HTML page?
 */
function gumcp_wants_json(): bool {
    $script = basename((string)($_SERVER['SCRIPT_NAME'] ?? ''));
    if (in_array($script, ['ajax.php', 'execute_command.php', 'api.php'], true)) {
        return true;
    }
    return strtolower((string)($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '')) === 'xmlhttprequest';
}

/**
 * Refuse the request. $reason is 'unconfigured' (no auth set up) or
 * 'unauthenticated' (auth set up, caller not logged in).
 */
function gumcp_deny_access(string $reason) {
    $msg = $reason === 'unconfigured'
        ? 'GumCP is not configured for secure access. Set LOGIN_REQUIRED (or BASIC_AUTH) '
          . 'to true in include/config.php, or explicitly allow an open panel with '
          . "define('GUMCP_ALLOW_UNAUTHENTICATED', true);"
        : 'Authentication required.';

    if (gumcp_wants_json()) {
        if (!headers_sent()) {
            header('Content-Type: application/json');
            http_response_code($reason === 'unconfigured' ? 503 : 401);
        }
        echo json_encode(['type' => 'error', 'success' => false, 'message' => $msg]);
        exit();
    }

    // Locked out by the throttle: re-issuing the Basic Auth challenge would just
    // loop the browser's password prompt with no explanation.
    $locked = gumcp_login_locked_for(gumcp_client_ip());
    if ($reason === 'unauthenticated' && $locked > 0) {
        if (!headers_sent()) {
            http_response_code(429);
            header('Retry-After: ' . $locked);
            header('Content-Type: text/plain; charset=UTF-8');
        }
        echo 'Too many failed attempts. Try again in about '
           . max(1, (int)ceil($locked / 60)) . " minute(s).\n";
        exit();
    }

    // Basic Auth is on but the caller sent no/bad credentials → prompt for them.
    if ($reason === 'unauthenticated' && defined('BASIC_AUTH') && BASIC_AUTH === true
        && !(defined('LOGIN_REQUIRED') && LOGIN_REQUIRED === true)) {
        if (!headers_sent()) {
            header('WWW-Authenticate: Basic realm="GumCP"');
            http_response_code(401);
        }
        echo '401 Unauthorized';
        exit();
    }

    if ($reason === 'unauthenticated') {
        if (!headers_sent()) {
            header('Location: ./login.php'
                 . (gumcp_session_was_expired() ? '?action=session_expired' : ''));
        }
        exit();
    }

    // Unconfigured: show a self-contained setup page (no app assets needed —
    // this must render even when the rest of the panel is refusing to serve).
    if (!headers_sent()) {
        http_response_code(503);
        header('Content-Type: text/html; charset=UTF-8');
    }
    ?><!DOCTYPE html>
<html lang="en"><head><meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="noindex,nofollow">
<title>GumCP — authentication not configured</title>
<style>
 body{font-family:-apple-system,Segoe UI,Roboto,sans-serif;background:#f5f5f5;color:#333;
      max-width:720px;margin:48px auto;padding:0 18px;line-height:1.55}
 h1{font-size:22px} code,pre{font-family:ui-monospace,Menlo,monospace}
 pre{background:#232f3e;color:#e6e6e6;padding:14px;border-radius:6px;overflow:auto}
 .card{background:#fff;border:1px solid #ddd;border-radius:8px;padding:20px}
 .warn{border-left:4px solid #c0392b;background:#fdecea;padding:12px 14px;border-radius:4px}
 .muted{color:#666;font-size:14px}
</style></head><body>
<div class="card">
  <h1>🔒 GumCP is not configured for secure access</h1>
  <p class="warn"><strong>Access refused.</strong> GumCP can run shell commands as a
     privileged user, so it will not serve the panel until authentication is configured.</p>
<?php if (is_file(dirname(__DIR__) . '/setup.php')): ?>
  <p style="font-size:17px"><strong>➡ <a href="./setup.php">Run first-run setup</a></strong>
     — choose a username and password in the browser. The setup page works only from a
     local/private address and deletes itself once done.</p>
  <p class="muted">Prefer to do it by hand? Edit <code>include/config.php</code>:</p>
<?php else: ?>
  <p>Edit <code>include/config.php</code> and set a login:</p>
<?php endif; ?>
<pre>define('LOGIN_REQUIRED', true);
define('LOGIN_USER', 'your-username');
define('LOGIN_PASS', 'a-long-unique-password');</pre>
  <p>…or use HTTP Basic Auth instead:</p>
<pre>define('BASIC_AUTH', true);
define('BASIC_AUTH_USER', 'your-username');
define('BASIC_AUTH_PASS', 'a-long-unique-password');</pre>
  <p class="muted">If this panel is on an isolated network and you accept that
     <strong>anyone who can reach it gets root on this host</strong>, you may
     deliberately re-enable open access with
     <code>define('GUMCP_ALLOW_UNAUTHENTICATED', true);</code> — not recommended.</p>
</div>
</body></html><?php
    exit();
}

/**
 * Central access gate. Called from include/init.php on every page and endpoint
 * that loads the bootstrap. api.php authenticates per-button by secret hash and
 * opts out by defining GUMCP_API_REQUEST before loading the bootstrap.
 */
function gumcp_enforce_access() {
    if (defined('GUMCP_API_REQUEST')) return;   // api.php: hash-authenticated
    if (gumcp_is_authenticated())     return;   // logged in
    if (gumcp_auth_configured()) {
        gumcp_deny_access('unauthenticated');
        return;
    }
    if (gumcp_open_mode()) return;              // explicit, informed opt-out
    gumcp_deny_access('unconfigured');          // fail closed
}
