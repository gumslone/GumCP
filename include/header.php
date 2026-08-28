<?php
declare(strict_types=1);

// ── Shared page header ────────────────────────────────────────────────────────
// Renders the <head>, opens <body> + .container, and draws the navbar.
// Set before including:
//   $active_page       (string) — navbar highlight key, e.g. 'gpio'
//   $page_title        (string) — appended to "GumCP " in <title> and meta
//   $show_menu_reorder (bool)   — show the ≡ menu-reorder icon (dashboard only,
//                                 since the reorder modal lives on index.php)
// Per-page <style>/<script> blocks go in the body right after this include.
// Close with include/footer.php (pages close .container themselves so modals
// can sit between the container and the footer).

$page_title        = isset($page_title) ? (string)$page_title : 'GumCP';
$active_page       = isset($active_page) ? (string)$active_page : '';
$show_menu_reorder = !empty($show_menu_reorder);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="GumCP <?php echo htmlspecialchars($page_title, ENT_QUOTES, 'UTF-8'); ?>">
    <link rel="shortcut icon" href="./static/images/raspberry.png" type="image/png">
    <link rel="icon"          href="./static/images/raspberry.png" type="image/png">
    <title>GumCP <?php echo htmlspecialchars($page_title, ENT_QUOTES, 'UTF-8'); ?></title>
    <link href="./static/css.php?v=<?php echo gumcp_asset_version(); ?>" rel="stylesheet" type="text/css">
    <script src="./static/js.php?v=<?php echo gumcp_asset_version(); ?>" type="text/javascript"></script>
</head>

<body>
<div class="container">

    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="./index.php">
                    <img src="./static/images/raspberry.png" alt="Logo"> GumCP
                </a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav navbar-right">
                    <?php require_once(__DIR__ . '/menu.php'); ?>
                    <?php if ($show_menu_reorder): ?>
                    <li>
                        <a href="#" title="<?php echo htmlspecialchars(t('nav.reorder', 'Reorder menu'), ENT_QUOTES, 'UTF-8'); ?>"
                           onclick="openMenuReorder(); return false;"
                           style="opacity:.6">
                            <i class="fa fa-bars"></i>
                        </a>
                    </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <?php
    // ── Security posture warnings ─────────────────────────────────────────────
    // Shown on every page while the install is in a dangerous state, because
    // GumCP can execute commands as a privileged user.
    if (function_exists('gumcp_open_mode') && gumcp_open_mode()): ?>
        <div class="alert alert-danger" role="alert">
            <i class="fa fa-exclamation-triangle fa-lg"></i>
            <strong>Authentication is disabled.</strong>
            Anyone who can reach this panel can run commands as
            <code><?php echo htmlspecialchars(defined('SSH_USER') ? SSH_USER : 'the SSH user', ENT_QUOTES, 'UTF-8'); ?></code>
            on this host. Set <code>LOGIN_REQUIRED</code> to <code>true</code> and remove
            <code>GUMCP_ALLOW_UNAUTHENTICATED</code> in <code>include/config.php</code>.
        </div>
    <?php elseif (function_exists('gumcp_default_credentials') && gumcp_default_credentials()): ?>
        <div class="alert alert-warning" role="alert">
            <i class="fa fa-exclamation-triangle fa-lg"></i>
            <strong>Default password in use.</strong>
            Change <code>LOGIN_PASS</code> / <code>BASIC_AUTH_PASS</code> in
            <code>include/config.php</code> — the shipped defaults are public.
        </div>
    <?php endif; ?>
