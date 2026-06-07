<?php
declare(strict_types=1);

// $active_page must be set before config/menu so the nav highlights correctly.
// It will be overwritten below once the module key is validated.
$active_page = '';

require_once('./include/init.php');

// ── Module validation ─────────────────────────────────────────────────────────

$module = trim((string)($_GET['module'] ?? ''));

if ($module === '' || !isset($gumcp_modules[$module])) {
    header('Location: index.php');
    exit;
}

$module_config = $gumcp_modules[$module];

// Resolve and validate the module file path before any output.
$module_path_raw = $module_config['module_index_file_relative_path'] ?? '';
if ($module_path_raw === '' || !file_exists(__DIR__ . '/' . $module_path_raw)) {
    header('Location: index.php');
    exit;
}

$active_page  = $module;
$module_title = htmlspecialchars($module_config['module_title'] ?? 'Module', ENT_QUOTES, 'UTF-8');
$module_path  = htmlspecialchars($module_path_raw, ENT_QUOTES, 'UTF-8');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="GumCP Module: <?php echo $module_title; ?>">
    <link rel="shortcut icon" href="./static/images/raspberry.png" type="image/png">
    <link rel="icon"          href="./static/images/raspberry.png" type="image/png">
    <title><?php echo $module_title; ?> &mdash; GumCP</title>
    <link href="./static/css.php" rel="stylesheet" type="text/css">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <script src="./static/js.php" type="text/javascript"></script>
    <style>
        .iframe-container { position:relative; width:100%; min-height:500px; }
        .iframe-container iframe { display:block; width:100%; min-height:500px; border:none; background:#fff; }
        .iframe-loading {
            position:absolute; top:50%; left:50%;
            transform:translate(-50%,-50%);
            text-align:center; z-index:1;
        }
        .iframe-loading i { font-size:48px; color:#5bc0de; }
    </style>
    <script>
    $(document).ready(function() {
        var $iframe   = $('#module-iframe');
        var $loading  = $('.iframe-loading');

        $iframe.on('load', function() {
            $loading.fadeOut(300);
            try {
                var doc    = $iframe[0].contentDocument || $iframe[0].contentWindow.document;
                var height = $(doc).height();
                if (height > 0) $iframe.height(height + 50);
            } catch (e) { /* cross-origin — use default height */ }
        });

        $iframe.on('error', function() {
            $loading.hide();
            $('.iframe-container').html(
                '<div class="text-center" style="padding:40px;color:#a94442">' +
                '<i class="fa fa-exclamation-triangle fa-3x"></i>' +
                '<h3>Failed to load module</h3>' +
                '<p>The module could not be loaded.</p></div>'
            );
        });

        // Fallback: hide spinner after 10 s regardless of load event.
        setTimeout(function() { $loading.fadeOut(300); }, 10000);
    });
    </script>
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
                    <?php require_once('./include/menu.php'); ?>
                </ul>
            </div>
        </div>
    </nav>

    <div class="page-header">
        <h1>
            <?php echo $module_title; ?>
            <?php if (!empty($module_config['module_description'])): ?>
                <small><?php echo htmlspecialchars($module_config['module_description'], ENT_QUOTES, 'UTF-8'); ?></small>
            <?php endif; ?>
        </h1>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-cube"></i> <?php echo $module_title; ?></h3>
        </div>
        <div class="panel-body">
            <div class="iframe-container">
                <div class="iframe-loading">
                    <i class="fa fa-spinner fa-spin"></i>
                    <p>Loading module&hellip;</p>
                </div>
                <iframe id="module-iframe"
                        src="<?php echo $module_path; ?>"
                        title="<?php echo $module_title; ?>"
                        sandbox="allow-same-origin allow-scripts allow-forms allow-popups allow-modals"
                        loading="lazy">
                    <p>Your browser does not support iframes.
                       <a href="<?php echo $module_path; ?>">Open the module directly.</a></p>
                </iframe>
            </div>
        </div>
    </div>

</div>

<footer class="footer">
    <div class="container">
        <p class="text-muted">
            GumCP <a href="https://github.com/gumslone/GumCP" target="_blank" rel="noopener">GitHub</a>.
            <a href="https://www.paypal.com/donate/?hosted_button_id=VCWHQPACTXV5N"
               target="_blank" rel="noopener">
                <img src="./static/images/Donate-PayPal-green.svg" alt="Donate">
            </a>
        </p>
    </div>
</footer>

</body>
</html>
