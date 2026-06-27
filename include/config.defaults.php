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

// Ensure button_api module entry exists for configs created before this feature
if (!isset($gumcp_modules['button_api'])) {
    $gumcp_modules['button_api'] = ['module_title' => 'Button API', 'module_active' => 1, 'module_no_nav' => 1];
}

// Services shown as status badges on the dashboard (systemctl is-active).
if (!isset($gumcp_dashboard_services) || !is_array($gumcp_dashboard_services)) {
    $gumcp_dashboard_services = ['ssh', 'apache2', 'cron'];
}
