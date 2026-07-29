<?php
declare(strict_types=1);

// ── SSH ───────────────────────────────────────────────────────────────────────
// Used by Actions, Buttons, GPIO and the System Check fix feature.
// The SSH user must exist on the Pi and be permitted to run the commands you need.
define('SSH_PORT', '22');        // SSH port (default: 22)
define('SSH_USER', 'pi');        // SSH username
define('SSH_PASS', 'raspberry'); // SSH password — CHANGE THIS

// ── Login page ────────────────────────────────────────────────────────────────
// GumCP runs shell commands as a privileged user, so it requires authentication.
// When LOGIN_REQUIRED is true, every page redirects to login.php until the user
// authenticates. CHANGE THE PASSWORD BELOW before first use.
//
// Turning this off does NOT open the panel: GumCP refuses to serve when no
// authentication is configured. To deliberately run an open panel (for example
// on an isolated network), you must also set GUMCP_ALLOW_UNAUTHENTICATED below —
// be aware that anyone who can reach an open panel gets root on this host.
define('LOGIN_REQUIRED', true);
define('LOGIN_USER', 'pi');
define('LOGIN_PASS', 'raspberry'); // CHANGE THIS

// ── HTTP Basic Auth ───────────────────────────────────────────────────────────
// When BASIC_AUTH is true the browser shows a native credentials dialog.
// Useful for curl / API clients. Can be active alongside LOGIN_REQUIRED —
// both methods use independent credentials and either one grants access.
define('BASIC_AUTH', false);
define('BASIC_AUTH_USER', 'api');    // separate username for Basic Auth
define('BASIC_AUTH_PASS', 'secret'); // separate password for Basic Auth — CHANGE THIS

// ── Language ──────────────────────────────────────────────────────────────────
// Default UI language: en, de, uk, es or fr. Users can switch from the navbar
// (their choice is remembered in the session).
define('GUMCP_LANG', 'en');

// ── Update recovery key ───────────────────────────────────────────────────────
// Optional. When set to a long random string, update.php can be reached with
// ?key=<value> even if the login page or Basic Auth is broken — an emergency way
// to recover a wedged install from the browser. Leave empty to disable.
// Example: define('GUMCP_UPDATE_KEY', 'a1b2c3d4e5f6...');
define('GUMCP_UPDATE_KEY', '');

// ── Unauthenticated access (DANGEROUS) ────────────────────────────────────────
// Leave false. Setting this to true disables ALL authentication and lets anyone
// who can reach this panel execute commands as the SSH user — i.e. take over the
// host. Only consider it on a fully isolated network you control.
define('GUMCP_ALLOW_UNAUTHENTICATED', false);

// ── Debug ─────────────────────────────────────────────────────────────────────
// Set true to display PHP errors in the browser. Keep false in production.
define('GUMCP_DEBUG', false);

error_reporting(GUMCP_DEBUG ? E_ALL : 0);

// ── Dashboard service badges ────────────────────────────────────────────────────
// Services shown as green/red status badges on the dashboard. Each is checked
// with `systemctl is-active <name>`. Use the unit names from `systemctl list-units`.
$gumcp_dashboard_services = ['ssh', 'apache2', 'cron'];

// ── Modules ───────────────────────────────────────────────────────────────────
// Set module_active => 0 to hide a module from the navbar and disable it.
// The order here is the default navbar order; drag to reorder in the browser.
$gumcp_modules = [
    'services' => [
        'module_title'                    => 'Services',
        'module_index_file_relative_path' => './services.php',
        'module_active'                   => 1, // list and control system services
    ],
    'processes' => [
        'module_title'                    => 'Processes',
        'module_index_file_relative_path' => './processes.php',
        'module_active'                   => 1, // browse and kill running processes
    ],
    'phpinfo' => [
        'module_title'                    => 'PHP Info',
        'module_index_file_relative_path' => './phpinfo.php',
        'module_active'                   => 1, // show phpinfo() output
    ],
    'actions' => [
        'module_title'                    => 'Actions',
        'module_index_file_relative_path' => './actions.php',
        'module_active'                   => 1, // run arbitrary SSH commands
    ],
    'gpio' => [
        'module_title'                    => 'GPIO',
        'module_index_file_relative_path' => './gpio.php',
        'module_active'                   => 1, // view and control GPIO pins
    ],
    'buttons' => [
        'module_title'                    => 'Buttons',
        'module_index_file_relative_path' => './buttons.php',
        'module_active'                   => 1, // one-click command buttons
    ],
    'rpi' => [
        'module_title'                    => 'Raspberry Pi',
        'module_index_file_relative_path' => './rpi.php',
        'module_active'                   => 1, // vcgencmd, interfaces, boot config, temp/CPU history
    ],
    'docker' => [
        'module_title'                    => 'Docker',
        'module_index_file_relative_path' => './docker.php',
        'module_active'                   => 0, // containers & images (set 1 if you run Docker)
    ],
    // System group — these render under a single "System" navbar dropdown.
    'packages' => [
        'module_title'                    => 'Packages',
        'module_index_file_relative_path' => './packages.php',
        'module_active'                   => 1, // apt update / upgrade
        'module_group'                    => 'System',
    ],
    'logs' => [
        'module_title'                    => 'Logs',
        'module_index_file_relative_path' => './logs.php',
        'module_active'                   => 1, // journalctl and /var/log viewer
        'module_group'                    => 'System',
    ],
    'cron' => [
        'module_title'                    => 'Cron',
        'module_index_file_relative_path' => './cron.php',
        'module_active'                   => 1, // scheduled tasks
        'module_group'                    => 'System',
    ],
    'users' => [
        'module_title'                    => 'Users',
        'module_index_file_relative_path' => './users.php',
        'module_active'                   => 1, // users & groups (read-only)
        'module_group'                    => 'System',
    ],
    // Button API — no navbar link; set module_active => 0 to disable api.php
    'button_api' => [
        'module_title'  => 'Button API',
        'module_active' => 1, // allow buttons to be triggered via api.php?hash=
        'module_no_nav' => 1,
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
// Skipped for API requests — api.php authenticates via button hash instead.

$_gumcp_need_auth = !defined('GUMCP_API_REQUEST')
                 && ((LOGIN_REQUIRED === true) || (defined('BASIC_AUTH') && BASIC_AUTH === true));

if ($_gumcp_need_auth) {
    $authed = false;

    // ── Basic Auth check ──────────────────────────────────────────────────────
    if (defined('BASIC_AUTH') && BASIC_AUTH === true) {
        // Apache may strip the Authorization header; fall back to parsing it manually.
        $basic_user = (string)($_SERVER['PHP_AUTH_USER'] ?? '');
        $basic_pass = (string)($_SERVER['PHP_AUTH_PW']   ?? '');
        if ($basic_user === '' && isset($_SERVER['HTTP_AUTHORIZATION'])) {
            $decoded = base64_decode(ltrim(substr($_SERVER['HTTP_AUTHORIZATION'], 6)));
            if ($decoded !== false && strpos($decoded, ':') !== false) {
                list($basic_user, $basic_pass) = explode(':', $decoded, 2);
            }
        }
        if ($basic_user !== ''
            && hash_equals(BASIC_AUTH_USER, $basic_user)
            && hash_equals(BASIC_AUTH_PASS, $basic_pass)
        ) {
            $authed = true;
        }
    }

    // ── Session (login form) check ────────────────────────────────────────────
    if (!$authed && LOGIN_REQUIRED === true) {
        if (isset($_SESSION['LOGIN_USER'], $_SESSION['LOGIN_PASS'])
            && $_SESSION['LOGIN_USER'] === md5(LOGIN_USER)
            && $_SESSION['LOGIN_PASS'] === md5(LOGIN_PASS)
        ) {
            $authed = true;
        }
    }

    // ── Reject ────────────────────────────────────────────────────────────────
    if (!$authed) {
        if (defined('BASIC_AUTH') && BASIC_AUTH === true) {
            header('WWW-Authenticate: Basic realm="GumCP"');
            http_response_code(401);
            echo '401 Unauthorized';
            exit();
        }
        header('Location: ./login.php');
        exit();
    }
}
unset($_gumcp_need_auth);
