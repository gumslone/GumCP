<?php
declare(strict_types=1);

// ── Module entry guard ────────────────────────────────────────────────────────
// Third-party modules (Adminer, TinyFileManager, …) are shown inside an iframe,
// which means the BROWSER fetches their URL directly — the parent page being
// authenticated protects nothing. Every module entry point must therefore
// enforce access itself, server-side, before the third-party code runs.
//
// Usage, from a module entry file:
//     <?php
//     define('GUMCP_MODULE_KEY', 'adminer');
//     require_once __DIR__ . '/../../include/module_guard.php';
//     require __DIR__ . '/vendor/adminer-4.8.1.php';
//
// Loaded at file scope (never inside a function) so $gumcp_modules from
// config.php stays a global, as the rest of the app expects.

require_once(__DIR__ . '/init.php');   // config + defaults + i18n + access gate

// init.php has already refused the request if the caller isn't authenticated.
// All that's left is honouring the module's own on/off switch.
if (defined('GUMCP_MODULE_KEY')) {
    $_gumcp_mod = (string)GUMCP_MODULE_KEY;
    if (empty($gumcp_modules[$_gumcp_mod]['module_active'])) {
        http_response_code(403);
        header('Content-Type: text/plain; charset=UTF-8');
        echo "This module is disabled.\n\n"
           . "Enable it in include/config.php:\n"
           . "  \$gumcp_modules['" . $_gumcp_mod . "']['module_active'] = 1;\n";
        exit();
    }
    unset($_gumcp_mod);
}
