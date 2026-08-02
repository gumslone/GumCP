<?php
declare(strict_types=1);

require_once(__DIR__ . '/include/session.php');
gumcp_start_session();

// Redirect to dashboard if already authenticated.
if (isset($_SESSION['LOGIN_USER'], $_SESSION['LOGIN_PASS'])) {
    header('Location: ./index.php');
    exit;
}

// Ensure a CSRF token exists for the login form.
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$message      = '';
$message_type = 'danger';

$action = (string)($_GET['action'] ?? '');
switch ($action) {
    case 'incorrect_login':
        $message      = 'Incorrect username or password. Please try again.';
        $message_type = 'danger';
        break;
    case 'locked':
        $wait_min = max(1, (int)ceil(((int)($_GET['wait'] ?? 0)) / 60));
        $message      = 'Too many failed attempts. Try again in about '
                      . $wait_min . ' minute' . ($wait_min === 1 ? '' : 's') . '.';
        $message_type = 'warning';
        break;
    case 'logout':
        $message      = 'You have been successfully logged out.';
        $message_type = 'success';
        break;
    case 'session_expired':
        $message      = 'Your session has expired. Please log in again.';
        $message_type = 'warning';
        break;
    case 'access_denied':
        $message      = 'Access denied. Please log in to continue.';
        $message_type = 'warning';
        break;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="GumCP &mdash; Raspberry Pi Control Panel Login">
    <meta name="robots" content="noindex, nofollow">
    <link rel="shortcut icon" href="./static/images/raspberry.png" type="image/png">
    <link rel="icon"          href="./static/images/raspberry.png" type="image/png">
    <title>Sign In &mdash; GumCP</title>
    <link href="./static/css.php" rel="stylesheet" type="text/css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .container { flex:1; display:flex; flex-direction:column; justify-content:center;
                     padding-top:40px; padding-bottom:40px; }
        .navbar    { background-color:rgba(255,255,255,.95); border:none;
                     box-shadow:0 2px 4px rgba(0,0,0,.1); }
        .login-container { max-width:450px; margin:0 auto; width:100%; }
        .login-panel { background:#fff; border-radius:8px;
                       box-shadow:0 4px 6px rgba(0,0,0,.1); border:none; overflow:hidden; }
        .login-panel .panel-heading {
            background:linear-gradient(135deg,#667eea 0%,#764ba2 100%);
            color:#fff; padding:20px; border:none;
        }
        .login-panel .panel-heading h3 { margin:0; font-size:24px; font-weight:600; }
        .login-panel .panel-body { padding:30px; }
        .form-control { height:45px; border-radius:4px; border:1px solid #ddd; font-size:14px; }
        .form-control:focus { border-color:#667eea; box-shadow:0 0 0 .2rem rgba(102,126,234,.25); }
        .btn-login { width:100%; height:45px;
                     background:linear-gradient(135deg,#667eea 0%,#764ba2 100%);
                     border:none; border-radius:4px; color:#fff;
                     font-size:16px; font-weight:600; transition:all .3s ease; }
        .btn-login:hover  { transform:translateY(-2px); box-shadow:0 4px 8px rgba(0,0,0,.2); }
        .btn-login:active { transform:translateY(0); }
        .alert { border-radius:4px; border:none; }
        .form-group { margin-bottom:20px; }
        .form-group label { font-weight:600; color:#333; margin-bottom:8px; }
        .input-group-addon { background-color:#f8f9fa; border:1px solid #ddd; border-right:none; }
        .footer { background-color:rgba(255,255,255,.95); padding:20px 0; margin-top:auto; }
        .footer p { margin:0; color:#666; }
        .footer a { color:#667eea; text-decoration:none; }
        .footer a:hover { text-decoration:underline; }
        .logo-text { display:flex; align-items:center; gap:10px; }
        .logo-text img { width:32px; height:32px; }
    </style>
</head>

<body>
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand logo-text" href="./login.php">
                    <img src="./static/images/raspberry.png" alt="GumCP Logo">
                    <span>GumCP</span>
                </a>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="login-container">
            <div class="panel panel-default login-panel">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <i class="fa fa-sign-in"></i> Sign In
                    </h3>
                </div>
                <div class="panel-body">

                    <?php if ($message !== ''): ?>
                        <div class="alert alert-<?php echo htmlspecialchars($message_type, ENT_QUOTES, 'UTF-8'); ?>" role="alert">
                            <?php
                            $icon = $message_type === 'success' ? 'check-circle'
                                  : ($message_type === 'warning' ? 'info-circle' : 'exclamation-circle');
                            ?>
                            <i class="fa fa-<?php echo $icon; ?>"></i>
                            <?php echo htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?>
                        </div>
                    <?php endif; ?>

                    <form method="post" action="./index.php" id="login-form">
                        <input type="hidden" name="csrf_token"
                               value="<?php echo htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8'); ?>">

                        <div class="form-group">
                            <label for="login_user">
                                <i class="fa fa-user"></i> Username
                            </label>
                            <input type="text" class="form-control"
                                   name="gumcp_login_user" id="login_user"
                                   placeholder="Enter your username"
                                   required autofocus autocomplete="username" maxlength="50">
                        </div>

                        <div class="form-group">
                            <label for="login_pass">
                                <i class="fa fa-lock"></i> Password
                            </label>
                            <input type="password" class="form-control"
                                   name="gumcp_login_pass" id="login_pass"
                                   placeholder="Enter your password"
                                   required autocomplete="current-password" maxlength="100">
                        </div>

                        <button type="submit" class="btn btn-primary btn-login">
                            <i class="fa fa-sign-in"></i> Sign In
                        </button>
                    </form>

                    <div class="text-center" style="margin-top:20px">
                        <small class="text-muted">
                            Default credentials: <code>pi</code> / <code>raspberry</code> &mdash;
                            change in <code>include/config.php</code>
                        </small>
                    </div>

                </div>
            </div>

            <div class="text-center" style="margin-top:20px; color:#fff">
                <p>
                    <i class="fa fa-info-circle"></i>
                    Need help? Visit the
                    <a href="https://github.com/gumslone/GumCP" target="_blank" rel="noopener"
                       style="color:#fff; text-decoration:underline">GitHub page</a>
                </p>
            </div>
        </div>
    </div>

    <footer class="footer">
        <div class="container text-center">
            <p class="text-muted">
                GumCP &copy; <?php echo date('Y'); ?> |
                <a href="https://github.com/gumslone/GumCP" target="_blank" rel="noopener">
                    <i class="fa fa-github"></i> GitHub
                </a> |
                <a href="https://www.paypal.com/donate/?hosted_button_id=VCWHQPACTXV5N"
                   target="_blank" rel="noopener">
                    <img src="./static/images/Donate-PayPal-green.svg" alt="Donate"
                         style="height:20px; vertical-align:middle">
                </a>
            </p>
        </div>
    </footer>

    <script src="./static/js.php" type="text/javascript"></script>
    <script>
    document.getElementById('login-form').addEventListener('submit', function(e) {
        var user = document.getElementById('login_user').value.trim();
        var pass = document.getElementById('login_pass').value;
        if (!user || !pass) {
            e.preventDefault();
            alert(!user ? 'Please enter your username.' : 'Please enter your password.');
            return;
        }
        var btn = this.querySelector('button[type="submit"]');
        btn.disabled = true;
        btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Signing in…';
    });

    // Clear password field when page is restored from bfcache.
    window.addEventListener('pageshow', function(e) {
        if (e.persisted) document.getElementById('login_pass').value = '';
    });
    </script>
</body>
</html>
