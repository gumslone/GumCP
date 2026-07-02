<?php
declare(strict_types=1);

// Default values for every GumCP setting.
// Loaded AFTER config.php so any constant not defined there gets a safe default.
// This makes old config.php files (missing newer settings) work without changes.

defined('SSH_PORT')        || define('SSH_PORT',        '22');
defined('SSH_USER')        || define('SSH_USER',        'pi');
defined('SSH_PASS')        || define('SSH_PASS',        'raspberry');

defined('LOGIN_REQUIRED')  || define('LOGIN_REQUIRED',  false);
defined('LOGIN_USER')      || define('LOGIN_USER',      'pi');
defined('LOGIN_PASS')      || define('LOGIN_PASS',      'raspberry');

defined('BASIC_AUTH')      || define('BASIC_AUTH',      false);
defined('BASIC_AUTH_USER') || define('BASIC_AUTH_USER', 'api');
defined('BASIC_AUTH_PASS') || define('BASIC_AUTH_PASS', 'secret');

defined('GUMCP_DEBUG')          || define('GUMCP_DEBUG',          false);

defined('GUMCP_LANG')           || define('GUMCP_LANG',           'en'); // en|de|uk|es|fr

// Optional emergency key for update.php (empty = disabled). When set, update.php
// can be reached with ?key=<this value> even if the login page/basic auth is
// unavailable — a recovery escape hatch. Keep it long and secret.
defined('GUMCP_UPDATE_KEY')     || define('GUMCP_UPDATE_KEY',     '');

// Ensure button_api module entry exists for configs created before this feature
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
