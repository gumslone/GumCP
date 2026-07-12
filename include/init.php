<?php
declare(strict_types=1);

// Central bootstrap for every GumCP page.
// 1. Load user config (include/config.php — git-ignored, never overwritten on upgrade).
// 2. Fill in defaults for any settings not present in an older config.php.
// 3. Set up i18n and a per-session CSRF token.

require_once(__DIR__ . '/config.php');
require_once(__DIR__ . '/config.defaults.php');
require_once(__DIR__ . '/i18n.php');

// Handle a ?lang=xx switch before any page output (sets session + cookie).
gumcp_init_lang();

// Ensure a CSRF token exists for the session — used by every POST form and AJAX
// call. config.php has already started the session by this point.
if (session_status() === PHP_SESSION_ACTIVE && !isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
