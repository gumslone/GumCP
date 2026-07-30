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
            // PHP 7.0–7.2: positional form, no 'samesite' key. The attribute is
            // still reachable by appending it to the path — PHP writes the path
            // verbatim into the Set-Cookie header. Raspberry Pi OS (stretch)
            // ships PHP 7.0, so this is the version most installs actually run.
            session_set_cookie_params(0, '/; SameSite=Lax', '', $https, true);
        }

        session_start();
        gumcp_send_security_headers();
    }

    /**
     * Response headers sent on every GumCP page.
     *
     * A GumCP session can run shell commands, so the risk is not just data
     * theft: an attacker who can frame the panel can trick a logged-in admin
     * into clicking a button that executes something.
     */
    function gumcp_send_security_headers() {
        if (headers_sent()) {
            return;
        }

        // Clickjacking. iframe.php frames modules from this same origin, so
        // SAMEORIGIN rather than DENY.
        header('X-Frame-Options: SAMEORIGIN');
        // Never let the browser guess a type — a stored file that sniffs as
        // HTML would otherwise run as HTML.
        header('X-Content-Type-Options: nosniff');
        // Panel URLs name the host and the page being administered; don't hand
        // them to third-party sites.
        header('Referrer-Policy: same-origin');

        // Third-party modules (Adminer, Tiny File Manager) are not ours to
        // audit and some builds pull assets from a CDN, so they get only the
        // framing restriction — a resource policy would silently break them.
        if (defined('GUMCP_MODULE_KEY')) {
            header("Content-Security-Policy: frame-ancestors 'self'");
            return;
        }

        // GumCP is entirely self-hosted (jQuery, Bootstrap and FontAwesome are
        // bundled), so 'self' is enough for every real resource. 'unsafe-inline'
        // is required because pages carry inline <script>/<style>; the policy is
        // still worth having for what it does block — external script sources,
        // exfiltration to another origin, plugins, and framing by other sites.
        header(
            "Content-Security-Policy: default-src 'self'; "
            . "img-src 'self' data:; "
            . "style-src 'self' 'unsafe-inline'; "
            . "script-src 'self' 'unsafe-inline'; "
            . "font-src 'self' data:; "
            . "connect-src 'self'; "
            . "form-action 'self'; "
            . "frame-ancestors 'self'; "
            . "base-uri 'self'; "
            . "object-src 'none'"
        );
    }
}
