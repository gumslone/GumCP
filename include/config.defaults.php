<?php
declare(strict_types=1);

// Default values for every GumCP setting.
// Loaded AFTER config.php so any constant not defined there gets a safe default.
// This makes old config.php files (missing newer settings) work without changes.

defined('SSH_PORT')        || define('SSH_PORT',        '22');
defined('SSH_USER')        || define('SSH_USER',        'pi');
defined('SSH_PASS')        || define('SSH_PASS',        'raspberry');

// Secure by default: authentication is required unless the administrator has
// explicitly configured otherwise. GumCP executes shell commands as a
// privileged user, so an unauthenticated panel is a full host compromise.
defined('LOGIN_REQUIRED')  || define('LOGIN_REQUIRED',  true);
// The login credentials ARE the Pi's system account — the same ones GumCP needs
// for SSH. Falling back to SSH_USER/SSH_PASS means a config.php that only sets
// the SSH credentials gets a matching login for free, and there is one password
// to keep current instead of two that can drift apart.
defined('LOGIN_USER')      || define('LOGIN_USER',      SSH_USER);
defined('LOGIN_PASS')      || define('LOGIN_PASS',      SSH_PASS);

// Check the login form against the Pi's real system account (verified over SSH)
// instead of the LOGIN_USER/LOGIN_PASS values above. Off by default, in which
// case the login is purely a config credential.
defined('LOGIN_CHECK_SYSTEM_USER') || define('LOGIN_CHECK_SYSTEM_USER', false);

// Login throttling: lock a client address out after this many failures within
// the window, for the lockout period (all in seconds).
defined('SESSION_IDLE_TIMEOUT')     || define('SESSION_IDLE_TIMEOUT',     3600);
defined('SESSION_ABSOLUTE_TIMEOUT') || define('SESSION_ABSOLUTE_TIMEOUT', 43200);
defined('LOGIN_MAX_FAILURES')   || define('LOGIN_MAX_FAILURES',   5);
defined('LOGIN_FAILURE_WINDOW') || define('LOGIN_FAILURE_WINDOW', 900);
defined('LOGIN_LOCKOUT_TIME')   || define('LOGIN_LOCKOUT_TIME',   900);

defined('BASIC_AUTH')      || define('BASIC_AUTH',      false);
defined('BASIC_AUTH_USER') || define('BASIC_AUTH_USER', 'api');
defined('BASIC_AUTH_PASS') || define('BASIC_AUTH_PASS', 'secret');

defined('GUMCP_DEBUG')          || define('GUMCP_DEBUG',          false);

// Deliberate opt-out of all authentication. Only honoured when set to exactly
// true in config.php; anyone who can reach an open panel gets root on this host.
defined('GUMCP_ALLOW_UNAUTHENTICATED') || define('GUMCP_ALLOW_UNAUTHENTICATED', false);

defined('GUMCP_LANG')           || define('GUMCP_LANG',           'en'); // en|de|uk|es|fr

// Optional emergency key for update.php (empty = disabled). When set, update.php
// can be reached with ?key=<this value> even if the login page/basic auth is
// unavailable — a recovery escape hatch. Keep it long and secret.
defined('GUMCP_UPDATE_KEY')     || define('GUMCP_UPDATE_KEY',     '');

// Logs in command_logs/ that are NOT background command output: the audit trail
// and the API call log. They must not appear in the Actions log list, where a
// "Delete" button would quietly discard the record of who signed in.
if (!function_exists('gumcp_reserved_logs')) {
    function gumcp_reserved_logs(): array {
        return ['auth.log', 'api_calls.log'];
    }
}

// Ensure button_api module entry exists for configs created before this feature.
// Deliberately left ENABLED here, unlike config.example.php where new installs
// get it off: flipping this to 0 would silently break existing api.php
// automations on upgrade. Pin it in your config.php to choose explicitly.
if (!isset($gumcp_modules['button_api'])) {
    $gumcp_modules['button_api'] = ['module_title' => 'Button API', 'module_active' => 1, 'module_no_nav' => 1];
}

// Backfill modules added after a user's config.php was created, so they appear
// in the navbar after a git pull without manual edits.
$_gumcp_new_modules = [
    'rpi'      => ['module_title' => 'Raspberry Pi', 'module_index_file_relative_path' => './rpi.php',      'module_active' => 1],
    'docker'   => ['module_title' => 'Docker',       'module_index_file_relative_path' => './docker.php',   'module_active' => 0],
    'packages' => ['module_title' => 'Packages',     'module_index_file_relative_path' => './packages.php', 'module_active' => 1, 'module_group' => 'System'],
    'logs'     => ['module_title' => 'Logs',         'module_index_file_relative_path' => './logs.php',     'module_active' => 1, 'module_group' => 'System'],
    'cron'     => ['module_title' => 'Cron',         'module_index_file_relative_path' => './cron.php',     'module_active' => 1, 'module_group' => 'System'],
    'users'    => ['module_title' => 'Users',        'module_index_file_relative_path' => './users.php',    'module_active' => 1, 'module_group' => 'System'],
    'scripts'  => ['module_title' => 'Scripts',      'module_index_file_relative_path' => './scripts.php',  'module_active' => 1, 'module_group' => 'System'],
];
foreach ($_gumcp_new_modules as $_k => $_m) {
    if (!isset($gumcp_modules[$_k])) {
        $gumcp_modules[$_k] = $_m;
    } elseif (!empty($_m['module_group']) && empty($gumcp_modules[$_k]['module_group'])) {
        // Upgrade existing entries (from an earlier pull) into the System group.
        $gumcp_modules[$_k]['module_group'] = $_m['module_group'];
    }
}
unset($_gumcp_new_modules, $_k, $_m);

// Services shown as status badges on the dashboard (systemctl is-active).
if (!isset($gumcp_dashboard_services) || !is_array($gumcp_dashboard_services)) {
    $gumcp_dashboard_services = ['ssh', 'apache2', 'cron'];
}

// Addresses allowed to call the Button API (api.php). Empty = no IP restriction
// (the hash alone authenticates). Accepts plain IPs and IPv4 CIDR ranges.
if (!isset($gumcp_api_allow_ips) || !is_array($gumcp_api_allow_ips)) {
    $gumcp_api_allow_ips = [];
}
