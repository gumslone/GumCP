<?php
declare(strict_types=1);

// Central bootstrap for every GumCP page.
// 1. Load user config (include/config.php — git-ignored, never overwritten on upgrade).
// 2. Fill in defaults for any settings not present in an older config.php.

require_once(__DIR__ . '/config.php');
require_once(__DIR__ . '/config.defaults.php');
