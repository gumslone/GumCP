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

function gumcp_auth_configured(): bool {
    return (defined('LOGIN_REQUIRED') && LOGIN_REQUIRED === true)
        || (defined('BASIC_AUTH')     && BASIC_AUTH     === true);
}

function gumcp_open_mode(): bool {
    return defined('GUMCP_ALLOW_UNAUTHENTICATED') && GUMCP_ALLOW_UNAUTHENTICATED === true;
}

function gumcp_session_authenticated(): bool {
    if (!defined('LOGIN_USER') || !defined('LOGIN_PASS')) return false;
    if (!isset($_SESSION['LOGIN_USER'], $_SESSION['LOGIN_PASS'])) return false;
    return hash_equals(md5(LOGIN_USER), (string)$_SESSION['LOGIN_USER'])
        && hash_equals(md5(LOGIN_PASS), (string)$_SESSION['LOGIN_PASS']);
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
    if (defined('LOGIN_REQUIRED') && LOGIN_REQUIRED === true
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
  <p>Edit <code>include/config.php</code> and set a login:</p>
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
