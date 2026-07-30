<?php
declare(strict_types=1);

// ── First-run setup ───────────────────────────────────────────────────────────
// Configures the login credentials from the browser, then deletes itself.
//
// This exists because GumCP fails closed: an install with no authentication
// configured refuses to serve, and the only other way out is editing
// include/config.php by hand — which is painful if all you have is HTTP.
//
// Security model (this file can write credentials, so the guards matter):
//   1. It runs ONLY while no authentication is configured. Once a login exists
//      it refuses outright, so it can never be used to reset a password.
//   2. It only answers requests from loopback/private addresses, so a
//      port-forwarded box cannot be claimed by someone on the internet.
//   3. It deletes itself after a successful save (and says so if it can't).
//
// Deliberately standalone: it must work while the rest of the app is refusing
// to serve, so it never loads include/init.php.

// Suppress the legacy inline auth gate inside a user's older config.php.
if (!defined('GUMCP_API_REQUEST')) {
    define('GUMCP_API_REQUEST', true);
}

// Cookie parameters must be set before anything starts a session, and
// config.php starts one — so this comes first.
require_once(__DIR__ . '/include/session.php');
gumcp_start_session();

$root        = __DIR__;
$config_file = $root . '/include/config.php';
$example_file = $root . '/include/config.example.php';

if (is_readable($config_file)) {
    require_once($config_file);
}
require_once($root . '/include/config.defaults.php');
require_once($root . '/include/auth.php');

if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// ── Guard 1: only reachable from a local/private network ──────────────────────
$client_ip = gumcp_client_ip();
$is_local  = $client_ip === ''
          || filter_var($client_ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) === false;

// ── Guard 2: refuse once authentication is configured ─────────────────────────
$already_configured = gumcp_auth_configured();

$errors  = [];
$done    = false;
$self_deleted = false;
$delete_error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !$already_configured && $is_local) {
    $token = (string)($_POST['csrf_token'] ?? '');
    if (!isset($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $token)) {
        $errors[] = 'Session expired — reload the page and try again.';
    }

    $user  = trim((string)($_POST['login_user'] ?? ''));
    $pass  = (string)($_POST['login_pass'] ?? '');
    $pass2 = (string)($_POST['login_pass2'] ?? '');

    if ($user === '' || !preg_match('/^[A-Za-z0-9._@-]{1,50}$/', $user)) {
        $errors[] = 'Username must be 1–50 characters (letters, digits, and . _ @ - only).';
    }
    if (strlen($pass) < 8) {
        $errors[] = 'Password must be at least 8 characters.';
    }
    if (in_array(strtolower($pass), ['raspberry', 'password', 'secret', 'gumcp', 'admin'], true)) {
        $errors[] = 'That password is one of the well-known defaults — choose another.';
    }
    if ($pass !== $pass2) {
        $errors[] = 'The two passwords do not match.';
    }

    if (empty($errors)) {
        // Start from the existing config, or the shipped template on a fresh install.
        if (is_readable($config_file)) {
            $src = (string)file_get_contents($config_file);
        } elseif (is_readable($example_file)) {
            $src = (string)file_get_contents($example_file);
        } else {
            $src = "<?php\ndeclare(strict_types=1);\n";
        }

        $src = gumcp_set_define($src, 'LOGIN_REQUIRED', 'true');
        $src = gumcp_set_define($src, 'LOGIN_USER', var_export($user, true));
        $src = gumcp_set_define($src, 'LOGIN_PASS', var_export($pass, true));
        // Never leave an explicit open-access opt-out behind.
        $src = gumcp_set_define($src, 'GUMCP_ALLOW_UNAUTHENTICATED', 'false');

        if (is_readable($config_file)) {
            @copy($config_file, $config_file . '.setup.bak');
        }

        if (@file_put_contents($config_file, $src, LOCK_EX) === false) {
            $errors[] = 'Could not write include/config.php. Fix its permissions '
                      . '(sudo chown www-data:www-data include/config.php && sudo chmod 664 include/config.php) '
                      . 'and try again, or edit the file by hand.';
        } else {
            $done = true;
            // Guard 3: remove this file so it can never be used again.
            if (@unlink(__FILE__)) {
                $self_deleted = true;
            } else {
                $delete_error = 'Could not delete setup.php automatically — remove it yourself now.';
            }
        }
    }
}

/**
 * Replace define('NAME', ...); in PHP source, or append it when absent.
 * $value_php must already be valid PHP (use var_export for strings).
 */
function gumcp_set_define(string $src, string $name, string $value_php): string {
    $pattern = "/define\s*\(\s*'" . preg_quote($name, '/') . "'\s*,.*?\)\s*;/s";
    $replacement = "define('" . $name . "', " . $value_php . ");";

    if (preg_match($pattern, $src)) {
        return (string)preg_replace_callback($pattern, function ($m) use ($replacement) {
            return $replacement;
        }, $src, 1);
    }
    // Not present — append near the end, before any closing tag.
    $src = preg_replace('/\?>\s*$/', '', $src);
    return rtrim($src) . "\n\n" . $replacement . "\n";
}

$csrf = htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="noindex,nofollow">
<title>GumCP — first-run setup</title>
<style>
 body{font-family:-apple-system,Segoe UI,Roboto,sans-serif;background:#f5f5f5;color:#333;
      max-width:640px;margin:44px auto;padding:0 18px;line-height:1.55}
 h1{font-size:22px;margin-bottom:4px} .sub{color:#666;margin-top:0}
 .card{background:#fff;border:1px solid #ddd;border-radius:8px;padding:22px}
 label{display:block;font-weight:600;margin:14px 0 4px}
 input[type=text],input[type=password]{width:100%;padding:10px;font-size:15px;
      border:1px solid #bbb;border-radius:4px;box-sizing:border-box}
 button{margin-top:18px;background:#2b6cb0;color:#fff;border:0;border-radius:4px;
      padding:11px 18px;font-size:15px;cursor:pointer}
 button:hover{background:#255a94}
 .err{background:#fdecea;border-left:4px solid #c0392b;padding:10px 14px;border-radius:4px;margin-bottom:14px}
 .ok{background:#e8f6ec;border-left:4px solid #2e7d32;padding:12px 14px;border-radius:4px}
 .warn{background:#fff6e5;border-left:4px solid #d68910;padding:12px 14px;border-radius:4px}
 .muted{color:#666;font-size:13px} code{font-family:ui-monospace,Menlo,monospace}
 pre{background:#232f3e;color:#e6e6e6;padding:12px;border-radius:6px;overflow:auto}
 a{color:#2b6cb0}
</style>
</head>
<body>
<div class="card">

<?php if ($already_configured): ?>
    <h1>✅ Already configured</h1>
    <p>GumCP already has authentication set up, so setup is disabled — it can never
       be used to change an existing password.</p>
    <p class="warn"><strong>Delete this file.</strong> It is no longer needed:<br>
       <code>sudo rm <?php echo htmlspecialchars(__FILE__, ENT_QUOTES, 'UTF-8'); ?></code></p>
    <p><a href="./index.php">Go to GumCP →</a></p>

<?php elseif (!$is_local): ?>
    <h1>🚫 Setup is local-only</h1>
    <p>First-run setup can only be completed from the same machine or a private
       network address, so nobody on the internet can claim this panel.</p>
    <p class="muted">Your address: <code><?php echo htmlspecialchars($client_ip, ENT_QUOTES, 'UTF-8'); ?></code>.
       Connect from your LAN (or over a VPN / SSH tunnel), or configure
       <code>include/config.php</code> by hand.</p>

<?php elseif ($done): ?>
    <h1>✅ GumCP is configured</h1>
    <p class="ok">Authentication is now enabled. Sign in with the username and
       password you just chose.</p>
    <?php if ($self_deleted): ?>
        <p class="muted">This setup page has deleted itself.</p>
    <?php else: ?>
        <p class="warn"><strong><?php echo htmlspecialchars($delete_error, ENT_QUOTES, 'UTF-8'); ?></strong><br>
           <code>sudo rm <?php echo htmlspecialchars(__FILE__, ENT_QUOTES, 'UTF-8'); ?></code></p>
    <?php endif; ?>
    <p><a href="./login.php">Continue to the login page →</a></p>

<?php else: ?>
    <h1>GumCP first-run setup</h1>
    <p class="sub">Choose the credentials you'll use to sign in.</p>

    <p class="warn">GumCP can run shell commands on this host, so it will not serve
       the panel until a login is configured.</p>

    <?php foreach ($errors as $e): ?>
        <div class="err"><?php echo htmlspecialchars($e, ENT_QUOTES, 'UTF-8'); ?></div>
    <?php endforeach; ?>

    <form method="post" autocomplete="off">
        <input type="hidden" name="csrf_token" value="<?php echo $csrf; ?>">
        <label for="login_user">Username</label>
        <input type="text" id="login_user" name="login_user" required maxlength="50"
               autocomplete="username"
               value="<?php echo htmlspecialchars((string)($_POST['login_user'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>">
        <label for="login_pass">Password <span class="muted">(at least 8 characters)</span></label>
        <input type="password" id="login_pass" name="login_pass" required autocomplete="new-password">
        <label for="login_pass2">Repeat password</label>
        <input type="password" id="login_pass2" name="login_pass2" required autocomplete="new-password">
        <button type="submit">Save and enable login</button>
    </form>

    <p class="muted" style="margin-top:18px">
       This writes <code>include/config.php</code> (a <code>.setup.bak</code> copy is
       kept) and then deletes this page. Prefer to do it by hand? Set
       <code>LOGIN_REQUIRED</code>, <code>LOGIN_USER</code> and <code>LOGIN_PASS</code>
       in <code>include/config.php</code> instead.</p>
<?php endif; ?>

</div>
</body>
</html>
