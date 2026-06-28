<?php
declare(strict_types=1);

$active_page = 'packages';

require_once('./include/init.php');

if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="GumCP Package Updates">
    <link rel="shortcut icon" href="./static/images/raspberry.png" type="image/png">
    <link rel="icon"          href="./static/images/raspberry.png" type="image/png">
    <title>GumCP Package Updates</title>
    <link href="./static/css.php" rel="stylesheet" type="text/css">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <script src="./static/js.php" type="text/javascript"></script>
    <script>var CSRF_TOKEN = <?php echo json_encode($_SESSION['csrf_token']); ?>;</script>
</head>

<body>
<div class="container">

    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>
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
        <h1><i class="fa fa-cubes"></i> Package Updates
            <small id="pkg-count-label">checking…</small>
        </h1>
    </div>

    <p>
        <button class="btn btn-default" id="pkg-check-btn" onclick="pkgCheck()">
            <i class="fa fa-refresh"></i> Check for updates
        </button>
        <button class="btn btn-warning" id="pkg-upgrade-btn" onclick="pkgUpgrade()">
            <i class="fa fa-arrow-circle-up"></i> Upgrade all
        </button>
        <span class="text-muted" style="margin-left:8px; font-size:12px">
            <code>apt-get update</code> / <code>apt-get upgrade</code> run over SSH.
        </span>
    </p>

    <div id="pkg-output-wrap" style="display:none; margin-bottom:15px">
        <pre id="pkg-output" style="max-height:300px; overflow:auto"></pre>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading"><i class="fa fa-list"></i> Upgradable Packages</div>
        <table class="table table-condensed table-striped" style="margin-bottom:0">
            <thead>
                <tr><th style="padding-left:15px">Package</th><th>Installed</th><th>Available</th></tr>
            </thead>
            <tbody id="pkg-tbody">
                <tr><td colspan="3" class="text-muted" style="padding-left:15px">Loading…</td></tr>
            </tbody>
        </table>
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

<script>
function pkgLoadList() {
    $.ajax({
        type: 'POST', url: 'ajax.php', dataType: 'json',
        data: { action: 'pkg_list', csrf_token: CSRF_TOKEN },
        success: function(d) {
            var pkgs = (d && d.packages) || [];
            var esc = function(s) { return $('<div>').text(s == null ? '' : s).html(); };
            $('#pkg-count-label').text(pkgs.length + ' update' + (pkgs.length !== 1 ? 's' : '') + ' available');
            if (!pkgs.length) {
                $('#pkg-tbody').html('<tr><td colspan="3" class="text-success" style="padding-left:15px">'
                    + '<i class="fa fa-check"></i> Everything is up to date.</td></tr>');
                return;
            }
            var html = '';
            pkgs.forEach(function(p) {
                html += '<tr><td style="padding-left:15px"><strong>' + esc(p.name) + '</strong></td>'
                     + '<td class="text-muted">' + esc(p.current) + '</td>'
                     + '<td class="text-success">' + esc(p.new) + '</td></tr>';
            });
            $('#pkg-tbody').html(html);
        },
        error: function() {
            $('#pkg-count-label').text('error');
            $('#pkg-tbody').html('<tr><td colspan="3" class="text-danger" style="padding-left:15px">Failed to load package list.</td></tr>');
        }
    });
}

function pkgShowOutput(text) {
    $('#pkg-output').text(text || '');
    $('#pkg-output-wrap').show();
}

function pkgCheck() {
    var $b = $('#pkg-check-btn');
    $b.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Checking…');
    $.ajax({
        type: 'POST', url: 'ajax.php', dataType: 'json',
        data: { action: 'pkg_check', csrf_token: CSRF_TOKEN },
        success: function(d) {
            pkgShowOutput((d && (d.output || d.message)) || '');
            pkgLoadList();
        },
        error: function() { pkgShowOutput('Request failed — check SSH settings.'); },
        complete: function() { $b.prop('disabled', false).html('<i class="fa fa-refresh"></i> Check for updates'); }
    });
}

function pkgUpgrade() {
    if (!confirm('Upgrade all packages now? This runs apt-get upgrade and may take a while.')) return;
    var $b = $('#pkg-upgrade-btn');
    $b.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Upgrading…');
    pkgShowOutput('Running apt-get upgrade… this can take several minutes.');
    $.ajax({
        type: 'POST', url: 'ajax.php', dataType: 'json',
        data: { action: 'pkg_upgrade', csrf_token: CSRF_TOKEN },
        success: function(d) {
            pkgShowOutput((d && (d.output || d.message)) || '');
            pkgLoadList();
        },
        error: function() { pkgShowOutput('Request failed or timed out — the upgrade may still be running.'); },
        complete: function() { $b.prop('disabled', false).html('<i class="fa fa-arrow-circle-up"></i> Upgrade all'); }
    });
}

$(pkgLoadList);
</script>

</body>
</html>
