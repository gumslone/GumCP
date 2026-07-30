<?php
declare(strict_types=1);

// ── Session hardening ─────────────────────────────────────────────────────────
// A GumCP session grants shell access as a sudo-capable user, so the session
// cookie is the most valuable thing in the app. PHP's defaults leave it exposed:
// readable by JavaScript, sent on cross-site requests, and with client-supplied
// session IDs accepted.
//
// Must run BEFORE any session_start(), which is why include/init.php loads this
// ahead of config.php (config.php starts the session). The standalone pages —
// login.php, setup.php, update.php — load it directly for the same reason.

if (!function_exists('gumcp_start_session')) {

    function gumcp_start_session() {
        if (session_status() !== PHP_SESSION_NONE) {
            return;   // already running: cookie params can no longer be changed
        }

        // Reject session IDs the client made up, so an attacker cannot fixate a
        // known ID on a victim before they log in.
        @ini_set('session.use_strict_mode', '1');
        // The ID belongs in the cookie, never in URLs where it would leak via
        // Referer headers, logs and shared links.
        @ini_set('session.use_only_cookies', '1');

        $https = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
              || (int)($_SERVER['SERVER_PORT'] ?? 0) === 443;

        if (PHP_VERSION_ID >= 70300) {
            // SameSite needs the array form, added in 7.3. Lax still allows the
            // cookie on ordinary top-level navigation to the panel.
            session_set_cookie_params([
                'lifetime' => 0,
                'path'     => '/',
                'httponly' => true,
                'secure'   => $https,
                'samesite' => 'Lax',
            ]);
        } else {
            // PHP 7.0–7.2: positional form, no SameSite support. HttpOnly and
            // Secure are the parts that matter most and are available here.
            session_set_cookie_params(0, '/', '', $https, true);
        }

        session_start();
    }
}
