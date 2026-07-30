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
    // Signed in against the system account: the password is never stored, so the
    // server-side session flag is the record. A client cannot forge session data.
    if (!empty($_SESSION['GUMCP_SYS_USER']) && gumcp_check_system_user()) {
        return true;
    }
    if (!defined('LOGIN_USER') || !defined('LOGIN_PASS')) return false;
    if (!isset($_SESSION['LOGIN_USER'], $_SESSION['LOGIN_PASS'])) return false;
    return hash_equals(md5(LOGIN_USER), (string)$_SESSION['LOGIN_USER'])
        && hash_equals(md5(LOGIN_PASS), (string)$_SESSION['LOGIN_PASS']);
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

    $user = (string)$_POST['gumcp_login_user'];
    $pass = (string)$_POST['gumcp_login_pass'];

    $valid_csrf = isset($_SESSION['csrf_token'])
               && hash_equals($_SESSION['csrf_token'], (string)($_POST['csrf_token'] ?? ''));

    if ($valid_csrf) {
        // Against the real system account, when that mode is switched on…
        if (gumcp_system_login($user, $pass)) {
            session_regenerate_id(true);          // prevent session fixation
            $_SESSION['GUMCP_SYS_USER'] = $user;
            header('Location: ./index.php');
            exit();
        }
        // …otherwise against the credentials configured in config.php.
        if (!gumcp_check_system_user()
            && defined('LOGIN_USER') && defined('LOGIN_PASS')
            && hash_equals(LOGIN_USER, $user) && hash_equals(LOGIN_PASS, $pass)) {
            session_regenerate_id(true);
            $_SESSION['LOGIN_USER'] = md5(LOGIN_USER);
            $_SESSION['LOGIN_PASS'] = md5(LOGIN_PASS);
            header('Location: ./index.php');
            exit();
        }
    }

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
    return $user !== ''
        && hash_equals(BASIC_AUTH_USER, $user)
        && hash_equals(BASIC_AUTH_PASS, $pass);
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
            header('Location: ./login.php');
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
