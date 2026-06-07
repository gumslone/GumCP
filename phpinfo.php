<?php
declare(strict_types=1);

$active_page = 'phpinfo';

require_once('./include/init.php');

ob_start();
phpinfo();
$html = (string)ob_get_clean();

// Extract only the <body> contents from phpinfo() output.
$phpinfo = '';
if (preg_match('/<body[^>]*>(.*)<\/body>/isU', $html, $matches)) {
    $phpinfo = $matches[1];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="GumCP PHP Info">
    <link rel="shortcut icon" href="./static/images/raspberry.png" type="image/png">
    <link rel="icon"          href="./static/images/raspberry.png" type="image/png">
    <title>GumCP PHP Info</title>
    <link href="./static/css.php" rel="stylesheet" type="text/css">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <script src="./static/js.php" type="text/javascript"></script>
    <style>
        /* Scope phpinfo() styles to avoid polluting Bootstrap */
        #phpinfo-output pre { margin:0; font-family:monospace; }
        #phpinfo-output a:link  { color:#009; text-decoration:none; background-color:#fff; }
        #phpinfo-output a:hover { text-decoration:underline; }
        #phpinfo-output table   { border-collapse:collapse; border:0; width:100%; box-shadow:1px 2px 3px #ccc; }
        #phpinfo-output .center { text-align:center; }
        #phpinfo-output .center table { margin:1em auto; text-align:left; }
        #phpinfo-output .center th    { text-align:center !important; }
        #phpinfo-output td, #phpinfo-output th { border:1px solid #666; font-size:75%; vertical-align:baseline; padding:4px 5px; }
        #phpinfo-output h1 { font-size:150%; }
        #phpinfo-output h2 { font-size:125%; }
        #phpinfo-output .p  { text-align:left; }
        #phpinfo-output .e  { background-color:#ccf; width:300px; font-weight:bold; }
        #phpinfo-output .h  { background-color:#99c; font-weight:bold; }
        #phpinfo-output .v  { background-color:#ddd; max-width:300px; overflow-x:auto; }
        #phpinfo-output .v i { color:#999; }
        #phpinfo-output img { float:right; border:0; }
        #phpinfo-output hr  { width:934px; background-color:#ccc; border:0; height:1px; }
    </style>
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

    <div class="panel panel-default" style="margin-bottom:5px">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-info-circle"></i> PHP Info</h3>
        </div>
        <div class="panel-body">
            <?php if ($phpinfo !== ''): ?>
                <div id="phpinfo-output"><?php echo $phpinfo; ?></div>
            <?php else: ?>
                <div class="alert alert-warning" role="alert">
                    <i class="fa fa-exclamation-triangle"></i>
                    Unable to extract phpinfo() output.
                </div>
            <?php endif; ?>
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
