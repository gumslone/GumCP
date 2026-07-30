<?php
declare(strict_types=1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Record the sign-out before the session goes away (auth.php defines functions
// only, so this is safe without the rest of the bootstrap).
require_once(__DIR__ . '/include/auth.php');
gumcp_auth_log('logout');

// Clear all session data, expire the cookie, and destroy the session.
$_SESSION = [];

if (isset($_COOKIE[session_name()])) {
    $p = session_get_cookie_params();
    setcookie(session_name(), '', time() - 3600, $p['path'], $p['domain'], $p['secure'], $p['httponly']);
}

session_destroy();

header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Pragma: no-cache');
header('Location: ./login.php?action=logout');
exit;
