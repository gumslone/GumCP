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
// These are the Pi's own account — the same credentials as SSH_USER/SSH_PASS
// above, so there is one password to keep current. Change the password on the
// Pi and you must update SSH_PASS anyway (or commands stop working); update
// LOGIN_PASS to match, or delete these two lines and they inherit from SSH_*.
//
// A fresh install signs in straight away with the defaults — no setup step.
// They are published in the README, so CHANGE THE PASSWORD once you are in:
// until you do, anyone who can reach this panel can sign in and run commands
// here. A warning banner and System Check flag it while the default is in use.
define('LOGIN_REQUIRED', true);
define('LOGIN_USER', 'pi');
define('LOGIN_PASS', 'raspberry'); // CHANGE THIS (and SSH_PASS above)

// ── Check the login against the Pi's system account ───────────────────────────
// false (default): the login form is checked against LOGIN_USER / LOGIN_PASS
//   above — an ordinary config credential, which may be anything you like.
// true: the submitted username and password are verified against the REAL
//   system account by authenticating over SSH, exactly as GumCP does to run
//   commands. LOGIN_USER above still decides WHO may sign in — the username
//   must match it — but LOGIN_PASS is no longer used and may be left empty,
//   since the password is checked by the OS instead of against a stored value.
//   LOGIN_USER defaults to SSH_USER. Naming a different system account works,
//   but whoever signs in can have GumCP run commands as SSH_USER, so do not
//   name an account less trusted than that one.
//   Only SSH_USER may sign in — allowing any system account would let a
//   low-privileged user in and then have GumCP run commands as SSH_USER.
//   Requires the php-ssh2 extension.
define('LOGIN_CHECK_SYSTEM_USER', false);

// ── Session lifetime ──────────────────────────────────────────────────────────
// A signed-in session is shell access, and the cookie otherwise lasts until the
// browser is closed. Sessions end after SESSION_IDLE_TIMEOUT seconds without
// activity, and after SESSION_ABSOLUTE_TIMEOUT seconds regardless. The dashboard
// auto-refresh does not count as activity. Set either to 0 to disable it.
define('SESSION_IDLE_TIMEOUT', 3600);        // 1 hour idle
define('SESSION_ABSOLUTE_TIMEOUT', 43200);   // 12 hours total

// ── Login throttling ──────────────────────────────────────────────────────────
// A successful login grants shell access, so password guessing is rate limited.
// After LOGIN_MAX_FAILURES failures within LOGIN_FAILURE_WINDOW seconds, that
// client address is refused for LOGIN_LOCKOUT_TIME seconds. Counting is per
// address, so someone hammering the login cannot lock you out from elsewhere.
define('LOGIN_MAX_FAILURES', 5);
define('LOGIN_FAILURE_WINDOW', 900);   // 15 minutes
define('LOGIN_LOCKOUT_TIME', 900);     // 15 minutes

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

// ── Button API IP allow-list ──────────────────────────────────────────────────
// Restrict which addresses may call api.php. Leave empty for no IP restriction
// (the per-button hash is then the only credential). Plain IPs and IPv4 CIDR
// ranges are supported; matching uses the real peer address, not X-Forwarded-For.
// Example: only Home Assistant and the local subnet may trigger buttons.
//   $gumcp_api_allow_ips = ['192.168.1.50', '192.168.1.0/24'];
$gumcp_api_allow_ips = [];

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
    // Button API — no navbar link. Off by default: it is the one endpoint that
    // executes commands WITHOUT a login, authenticated only by a per-button
    // secret hash. Set module_active => 1 to enable it, and treat the resulting
    // URLs/keys like passwords.
    'button_api' => [
        'module_title'  => 'Button API',
        'module_active' => 0, // 1 = allow buttons to be triggered via api.php
        'module_no_nav' => 1,
    ],
    // Order from https://www.tindie.com/stores/gumslone/
    'tehybug' => [
        'module_title'                    => 'TeHyBug',
        'module_index_file_relative_path' => './modules/tehybug/index.php',
        'module_active'                   => 0,
        'module_show_in_iframe'           => 1,
    ],
    // ── Third-party modules (separate licenses) ───────────────────────────────
    // NOT bundled with GumCP. Install the version you want first:
    //     ./scripts/install-module.sh adminer
    //     ./scripts/install-module.sh tinyfilemanager
    // then set module_active => 1 below. They are reached through a generated
    // entry file that enforces your GumCP login before the third-party code runs.
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

// ── Login processing ────────────────────────────────────────────────────────
// Handled by include/auth.php (loaded via include/init.php), so it can be
// fixed by an upgrade — config.php is yours and is never overwritten.

// ── Auth gate ─────────────────────────────────────────────────────────────────
// Access control now lives in include/auth.php (loaded by include/init.php).
// It is kept in shipped code so security fixes reach existing installs on
// upgrade — config.php is yours and is never overwritten.

