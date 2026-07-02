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

$page_title = 'PHP Info';
require_once('./include/header.php');
?>

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

<?php require_once('./include/footer.php'); ?>
