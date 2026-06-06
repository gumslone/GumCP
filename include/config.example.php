<?php
declare(strict_types=1);

define('SSH_PORT', '22');        // SSH port (default: 22)
define('SSH_USER', 'pi');        // SSH username
define('SSH_PASS', 'raspberry'); // SSH password

define('LOGIN_REQUIRED', false); // true = require login, false = open access
define('LOGIN_USER', 'pi');
define('LOGIN_PASS', 'raspberry');

define('BASIC_AUTH', false);    // true = use HTTP Basic Auth instead of the login page;

define('GUMCP_DEBUG', false);    // true = show PHP errors

error_reporting(GUMCP_DEBUG ? E_ALL : 0);

$gumcp_modules = [
    'services' => [
        'module_title'                    => 'Services',
        'module_index_file_relative_path' => './services.php',
        'module_active'                   => 1,
    ],
    'processes' => [
        'module_title'                    => 'Processes',
        'module_index_file_relative_path' => './processes.php',
        'module_active'                   => 1,
    ],
    'phpinfo' => [
        'module_title'                    => 'PHP Info',
        'module_index_file_relative_path' => './phpinfo.php',
        'module_active'                   => 1,
    ],
    'actions' => [
        'module_title'                    => 'Actions',
        'module_index_file_relative_path' => './actions.php',
        'module_active'                   => 1,
    ],
    'gpio' => [
        'module_title'                    => 'GPIO',
        'module_index_file_relative_path' => './gpio.php',
        'module_active'                   => 1,
    ],
    'buttons' => [
        'module_title'                    => 'Buttons',
        'module_index_file_relative_path' => './buttons.php',
        'module_active'                   => 1,
    ],
    // Order from https://www.tindie.com/stores/gumslone/
    'tehybug' => [
        'module_title'                    => 'TeHyBug',
        'module_index_file_relative_path' => './modules/tehybug/index.php',
        'module_active'                   => 0,
        'module_show_in_iframe'           => 1,
    ],
    // Third-party modules (separate licenses)
    'tinyfilemanager' => [
        'module_title'                    => 'File Manager',
        'module_index_file_relative_path' => './modules/tinyfilemanager/tinyfilemanager.php',
        'module_active'                   => 0,
        'module_show_in_iframe'           => 1,
    ],
    'adminer' => [
        'module_title'                    => 'Database Manager',
        'module_index_file_relative_path' => './modules/adminer/adminer.php',
        'module_active'                   => 0,
        'module_show_in_iframe'           => 1,
    ],
];

// ── Session ───────────────────────────────────────────────────────────────────

if (session_status() === PHP_SESSION_NONE) {
    session_start();
    session_regenerate_id();
}

// ── Login processing ──────────────────────────────────────────────────────────
// Only triggered when the login form is submitted (POST with credentials).

if (!empty($_POST['login_user']) && !empty($_POST['login_pass'])) {
    // CSRF check: token must exist in session and match the submitted value.
    $submitted_token = (string)($_POST['csrf_token'] ?? '');
    $valid_csrf = isset($_SESSION['csrf_token'])
               && hash_equals($_SESSION['csrf_token'], $submitted_token);

    // Credential check: constant-time comparison prevents timing attacks.
    $valid_user = $valid_csrf && hash_equals(LOGIN_USER, $_POST['login_user']);
    $valid_pass = $valid_user && hash_equals(LOGIN_PASS, $_POST['login_pass']);

    if ($valid_pass) {
        $_SESSION['LOGIN_USER'] = md5(LOGIN_USER);
        $_SESSION['LOGIN_PASS'] = md5(LOGIN_PASS);
    } else {
        header('Location: ./login.php?action=incorrect_login');
        exit();
    }
}

// ── Auth gate ─────────────────────────────────────────────────────────────────

if (LOGIN_REQUIRED === true || (defined('BASIC_AUTH') && BASIC_AUTH === true)) {
    // Apache may strip the Authorization header; fall back to parsing it manually.
    $basic_user = (string)($_SERVER['PHP_AUTH_USER'] ?? '');
    $basic_pass = (string)($_SERVER['PHP_AUTH_PW']   ?? '');
    if ($basic_user === '' && isset($_SERVER['HTTP_AUTHORIZATION'])) {
        $decoded = base64_decode(ltrim(substr($_SERVER['HTTP_AUTHORIZATION'], 6)));
        if ($decoded !== false && strpos($decoded, ':') !== false) {
            [$basic_user, $basic_pass] = explode(':', $decoded, 2);
        }
    }
    $basic_ok   = $basic_user !== ''
               && hash_equals(LOGIN_USER, $basic_user)
               && hash_equals(LOGIN_PASS, $basic_pass);

    $session_ok = isset($_SESSION['LOGIN_USER'], $_SESSION['LOGIN_PASS'])
               && $_SESSION['LOGIN_USER'] === md5(LOGIN_USER)
               && $_SESSION['LOGIN_PASS'] === md5(LOGIN_PASS);

    if (!$basic_ok && !$session_ok) {
        if (defined('BASIC_AUTH') && BASIC_AUTH === true) {
            // Prompt the browser's native credentials dialog
            header('WWW-Authenticate: Basic realm="GumCP"');
            http_response_code(401);
            echo '401 Unauthorized';
            exit();
        }
        header('Location: ./login.php');
        exit();
    }
}
