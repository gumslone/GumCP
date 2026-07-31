<?php
declare(strict_types=1);

// ── Standalone updater / recovery endpoint ────────────────────────────────────
// Deliberately depends on ONLY include/config.php (never init.php / i18n.php),
// so it keeps working even when a bad deploy breaks the normal bootstrap and
// every other page returns HTTP 500. Runs git directly via shell (no SSH), so
// it also works when SSH is disabled. Protected by the config.php auth gate
// when LOGIN_REQUIRED or BASIC_AUTH is enabled.

// Suppress config.php's built-in auth gate — this page enforces its own access
// check below so it can also honour the emergency GUMCP_UPDATE_KEY bypass.
if (!defined('GUMCP_API_REQUEST')) {
    define('GUMCP_API_REQUEST', true);
}
// Cookie parameters must be set before anything starts a session, and
// config.php starts one — so this comes first.
require_once(__DIR__ . '/include/session.php');
gumcp_start_session();

include_once(__DIR__ . '/include/config.php');
// Defaults + the shared auth helpers (throttle, timeouts, audit log). auth.php
// only defines functions, so pulling it in keeps this page standalone — it
// still works when init.php or i18n is broken.
require_once(__DIR__ . '/include/config.defaults.php');
require_once(__DIR__ . '/include/auth.php');

// ── Access control ────────────────────────────────────────────────────────────
// Allowed if: a valid emergency key is supplied, OR the normal login/Basic Auth
// succeeds, OR no authentication is configured (open install).
$update_key = defined('GUMCP_UPDATE_KEY') ? (string)GUMCP_UPDATE_KEY : '';
$req_key    = (string)($_REQUEST['key'] ?? ''); // GET query or POST body

// The emergency key is a bearer credential for an endpoint that can run
// git reset --hard, so guessing it must cost something. Same throttle as the
// login, under its own key so recovery attempts cannot lock the web login and
// vice versa.
$throttle_key = 'update:' . gumcp_client_ip();
if ($req_key !== '' && gumcp_login_locked_for($throttle_key) > 0) {
    gumcp_auth_log('locked', 'update.php key attempt while locked out');
    http_response_code(429);
    header('Retry-After: ' . gumcp_login_locked_for($throttle_key));
    echo 'Too many failed attempts.';
    exit();
}

$has_key = $update_key !== '' && hash_equals($update_key, $req_key);
if ($req_key !== '') {
    if ($has_key) {
        gumcp_login_clear($throttle_key);
        gumcp_auth_log('login_ok', 'update.php emergency key');
    } else {
        gumcp_login_record_failure($throttle_key);
        gumcp_auth_log('login_failed', 'update.php: wrong emergency key');
    }
}

$login_on = defined('LOGIN_REQUIRED') && LOGIN_REQUIRED === true;
$basic_on = defined('BASIC_AUTH') && BASIC_AUTH === true;

$allowed = $has_key || (!$login_on && !$basic_on);

// Reuse the shared session check rather than comparing the stamps by hand:
// it also enforces the idle/absolute timeouts, which a raw comparison would
// silently bypass — this page must not be the one place a dead session works.
if (!$allowed && $login_on && gumcp_session_authenticated()) {
    $allowed = true;
}

if (!$allowed && $basic_on) {
    $bu = (string)($_SERVER['PHP_AUTH_USER'] ?? '');
    $bp = (string)($_SERVER['PHP_AUTH_PW'] ?? '');
    if ($bu === '' && isset($_SERVER['HTTP_AUTHORIZATION'])) {
        $decoded = base64_decode(ltrim(substr($_SERVER['HTTP_AUTHORIZATION'], 6)));
        if ($decoded !== false && strpos($decoded, ':') !== false) {
            list($bu, $bp) = explode(':', $decoded, 2);
        }
    }
    if ($bu !== '') {
        if (gumcp_login_locked_for($throttle_key) > 0) {
            http_response_code(429);
            header('Retry-After: ' . gumcp_login_locked_for($throttle_key));
            echo 'Too many failed attempts.';
            exit();
        }
        if (hash_equals(BASIC_AUTH_USER, $bu) && hash_equals(BASIC_AUTH_PASS, $bp)) {
            gumcp_login_clear($throttle_key);
            $allowed = true;
        } else {
            gumcp_login_record_failure($throttle_key);
            gumcp_auth_log('login_failed', 'update.php: wrong Basic Auth');
        }
    }
}

if (!$allowed) {
    if ($basic_on) {
        header('WWW-Authenticate: Basic realm="GumCP Updater"');
        http_response_code(401);
        echo '401 Unauthorized';
        exit();
    }
    header('Location: ./login.php');
    exit();
}

if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$dir     = __DIR__;
$output  = '';
$ok      = null; // null = not run yet
$did_run = false;

// ── Handle update POST ────────────────────────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'update') {
    $did_run = true;

    $valid_csrf = isset($_SESSION['csrf_token'])
               && hash_equals($_SESSION['csrf_token'], (string)($_POST['csrf_token'] ?? ''));

    if (!$valid_csrf) {
        $output = 'CSRF token mismatch — reload the page and try again.';
        $ok = false;
    } else {
        $target = trim((string)($_POST['git_target'] ?? 'master'));
        $gitdir = escapeshellarg($dir);

        if ($target === 'master') {
            $cmd = 'git -C ' . $gitdir . ' pull origin master 2>&1';
        } elseif (preg_match('/^v?[0-9]+\.[0-9]+(\.[0-9]+)?$/', $target)) {
            $cmd = 'git -C ' . $gitdir . ' fetch --tags origin 2>&1'
                 . ' && git -C ' . $gitdir . ' reset --hard ' . escapeshellarg('refs/tags/' . $target) . ' 2>&1';
        } else {
            $cmd = '';
            $output = 'Invalid target.';
            $ok = false;
        }

        if ($cmd !== '') {
            $output = (string)@shell_exec($cmd);
            // git writes errors to the captured output; flag obvious failures.
            $ok = ($output !== '')
               && stripos($output, 'error:') === false
               && stripos($output, 'fatal:') === false
               && stripos($output, 'Permission denied') === false;
            if ($output === '') {
                $output = '(no output — git may not be installed or the directory is not a repo)';
                $ok = false;
            }
        }
    }
}

// ── Local tag list for the dropdown ───────────────────────────────────────────
$tags = [];
$raw  = @shell_exec('git -C ' . escapeshellarg($dir) . ' tag --sort=-v:refname 2>/dev/null');
if (is_string($raw)) {
    foreach (explode("\n", trim($raw)) as $t) {
        $t = trim($t);
        if ($t !== '') $tags[] = $t;
    }
}

$csrf = htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex,nofollow">
    <title>GumCP Updater</title>
    <style>
        /* Self-contained styles — do not depend on static/css.php */
        body { font-family: -apple-system, Segoe UI, Roboto, sans-serif; background:#f5f5f5;
               color:#333; max-width:760px; margin:40px auto; padding:0 16px; }
        h1 { font-size:22px; }
        .card { background:#fff; border:1px solid #ddd; border-radius:6px; padding:20px; margin-bottom:16px; }
        select, button { font-size:15px; padding:8px 12px; border-radius:4px; border:1px solid #bbb; }
        button { background:#f0ad4e; color:#fff; border-color:#eea236; cursor:pointer; }
        button:hover { background:#ec971f; }
        pre { background:#1e1e1e; color:#e0e0e0; padding:14px; border-radius:4px; overflow:auto;
              max-height:420px; white-space:pre-wrap; word-break:break-word; }
        .ok  { color:#3c763d; } .err { color:#a94442; }
        .muted { color:#777; font-size:13px; }
        a { color:#337ab7; }
    </style>
</head>
<body>
    <h1>🛠️ GumCP Updater</h1>
    <p class="muted">
        Standalone recovery updater. Works even when the main app is down, and runs
        <code>git</code> locally (no SSH required).
    </p>

    <?php if ($did_run): ?>
        <div class="card">
            <h3 class="<?php echo $ok ? 'ok' : 'err'; ?>">
                <?php echo $ok ? '✓ Update finished' : '✗ Update reported problems'; ?>
            </h3>
            <pre><?php echo htmlspecialchars($output, ENT_QUOTES, 'UTF-8'); ?></pre>
            <p class="muted">Now reload <a href="./index.php">the dashboard</a>.</p>
        </div>
    <?php endif; ?>

    <div class="card">
        <form method="post" onsubmit="return confirm('Update GumCP now? This runs git in ' + <?php echo json_encode($dir); ?> + '.');">
            <input type="hidden" name="action" value="update">
            <input type="hidden" name="csrf_token" value="<?php echo $csrf; ?>">
            <?php if ($has_key): ?>
                <input type="hidden" name="key" value="<?php echo htmlspecialchars($req_key, ENT_QUOTES, 'UTF-8'); ?>">
            <?php endif; ?>
            <label for="git_target"><strong>Version</strong></label><br>
            <select name="git_target" id="git_target">
                <option value="master">Latest (master branch)</option>
                <?php foreach ($tags as $t): ?>
                    <option value="<?php echo htmlspecialchars($t, ENT_QUOTES, 'UTF-8'); ?>">
                        Release <?php echo htmlspecialchars($t, ENT_QUOTES, 'UTF-8'); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button type="submit">⬇ Update</button>
            <p class="muted" style="margin-bottom:0">
                Runs <code>git pull origin master</code> (or <code>reset --hard</code> to a release tag)
                in <code><?php echo htmlspecialchars($dir, ENT_QUOTES, 'UTF-8'); ?></code>.
                Your <code>config.php</code>, buttons and logs are preserved.
            </p>
        </form>
    </div>

    <p class="muted">
        If this page ever fails too, edit <code>include/config.php</code> or the broken file
        directly via the file manager, or pull with <code>git pull</code> over SSH.
    </p>
</body>
</html>
