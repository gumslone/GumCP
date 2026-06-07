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

defined('BUTTON_API_ENABLED')   || define('BUTTON_API_ENABLED',   false);
