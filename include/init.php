<?php
declare(strict_types=1);

// Central bootstrap for every GumCP page.
// 1. Load user config (include/config.php — git-ignored, never overwritten on upgrade).
// 2. Fill in defaults for any settings not present in an older config.php.
// 3. Set up i18n and a per-session CSRF token.

// Harden the session cookie before anything starts a session — config.php does,
// and cookie parameters cannot be changed once it has.
require_once(__DIR__ . '/session.php');
gumcp_start_session();

require_once(__DIR__ . '/config.php');
require_once(__DIR__ . '/config.defaults.php');
require_once(__DIR__ . '/i18n.php');
require_once(__DIR__ . '/assets.php');

// Handle a ?lang=xx switch before any page output (sets session + cookie).
gumcp_init_lang();

// Ensure a CSRF token exists for the session — used by every POST form and AJAX
// call. config.php normally starts the session; start it here as a fallback so
// the bootstrap doesn't silently depend on that convention in custom configs.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (session_status() === PHP_SESSION_ACTIVE && !isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// ── Access gate ───────────────────────────────────────────────────────────────
// Must run last: config.php has already processed a submitted login form (the
// login page posts to index.php), so a just-authenticated session is visible
// here. Lives in shipped code rather than in the user-owned config.php so the
// gate can be fixed by an upgrade. Fails closed when no auth is configured.
require_once(__DIR__ . '/auth.php');
gumcp_process_login();   // handle a submitted login form first…
gumcp_enforce_access();  // …then decide whether this request may proceed

// ── Disabled modules ──────────────────────────────────────────────────────────
// module_active => 0 used to hide only the navbar link; the page still loaded
// for anyone who typed its URL. Every page sets $active_page to its module key
// before including this file, so one check here makes "disabled" mean disabled.
if (isset($active_page) && is_string($active_page)
    && isset($gumcp_modules[$active_page])
    && empty($gumcp_modules[$active_page]['module_active'])) {
    http_response_code(403);
    header('Content-Type: text/html; charset=UTF-8');
    echo '<!DOCTYPE html><meta charset="utf-8"><title>Module disabled</title>'
       . '<body style="font-family:sans-serif;max-width:560px;margin:60px auto;padding:0 16px">'
       . '<h2>This module is disabled</h2>'
       . '<p>Enable it in <code>include/config.php</code>: '
       . '<code>$gumcp_modules[\'' . htmlspecialchars($active_page, ENT_QUOTES, 'UTF-8')
       . '\'][\'module_active\'] = 1;</code></p>'
       . '<p><a href="./index.php">Back to the dashboard</a></p></body>';
    exit();
}
