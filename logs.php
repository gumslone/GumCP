<?php
declare(strict_types=1);

$active_page = 'logs';

require_once('./include/init.php');

if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Common log sources. Files are validated again server-side in ajax.php.
$log_sources = [
    'journal'                  => 'systemd journal (journalctl)',
    'dmesg'                    => 'Kernel ring buffer (dmesg)',
    '/var/log/syslog'          => '/var/log/syslog',
    '/var/log/messages'        => '/var/log/messages',
    '/var/log/auth.log'        => '/var/log/auth.log',
    '/var/log/kern.log'        => '/var/log/kern.log',
    '/var/log/daemon.log'      => '/var/log/daemon.log',
    '/var/log/apache2/error.log'  => '/var/log/apache2/error.log',
    '/var/log/apache2/access.log' => '/var/log/apache2/access.log',
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="GumCP System Logs">
    <link rel="shortcut icon" href="./static/images/raspberry.png" type="image/png">
    <link rel="icon"          href="./static/images/raspberry.png" type="image/png">
    <title>GumCP System Logs</title>
    <link href="./static/css.php" rel="stylesheet" type="text/css">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <script src="./static/js.php" type="text/javascript"></script>
    <script>
    var CSRF_TOKEN = <?php echo json_encode($_SESSION['csrf_token']); ?>;
    var T_VIEW = <?php echo json_encode(t('log.view', 'View')); ?>;
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
        <h1><i class="fa fa-file-text-o"></i> <?php echo htmlspecialchars(t('log.title', 'System Logs'), ENT_QUOTES, 'UTF-8'); ?></h1>
    </div>

    <form class="form-inline" onsubmit="return false" style="margin-bottom:12px">
        <div class="form-group">
            <label for="log-source"><?php echo htmlspecialchars(t('log.source', 'Source'), ENT_QUOTES, 'UTF-8'); ?></label>
            <select class="form-control" id="log-source">
                <?php foreach ($log_sources as $val => $label): ?>
                    <option value="<?php echo htmlspecialchars($val, ENT_QUOTES, 'UTF-8'); ?>">
                        <?php echo htmlspecialchars($label, ENT_QUOTES, 'UTF-8'); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="log-lines"><?php echo htmlspecialchars(t('log.lines', 'Lines'), ENT_QUOTES, 'UTF-8'); ?></label>
            <select class="form-control" id="log-lines">
                <option>100</option><option selected>200</option><option>500</option>
                <option>1000</option><option>2000</option>
            </select>
        </div>
        <div class="form-group">
            <label for="log-filter"><?php echo htmlspecialchars(t('log.filter', 'Filter'), ENT_QUOTES, 'UTF-8'); ?></label>
            <input type="text" class="form-control" id="log-filter" placeholder="text contains…">
        </div>
        <button class="btn btn-primary" id="log-load-btn" onclick="logLoad()">
            <i class="fa fa-search"></i> <?php echo htmlspecialchars(t('log.view', 'View'), ENT_QUOTES, 'UTF-8'); ?>
        </button>
    </form>

    <pre id="log-output" style="max-height:560px; overflow:auto; font-size:12px"><?php echo htmlspecialchars(t('log.select', 'Select a source and click View.'), ENT_QUOTES, 'UTF-8'); ?></pre>

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
function logLoad() {
    var $b = $('#log-load-btn');
    $b.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Loading…');
    $('#log-output').text('Loading…');
    $.ajax({
        type: 'POST', url: 'ajax.php', dataType: 'json',
        data: {
            action: 'log_view',
            source: $('#log-source').val(),
            lines:  $('#log-lines').val(),
            filter: $('#log-filter').val(),
            csrf_token: CSRF_TOKEN
        },
        success: function(d) {
            if (d && d.type === 'error') { $('#log-output').text('Error: ' + d.message); return; }
            var out = (d && d.output) || '';
            $('#log-output').text(out.trim() === '' ? '(no matching lines)' : out);
            var el = document.getElementById('log-output');
            el.scrollTop = el.scrollHeight;
        },
        error: function() { $('#log-output').text('Request failed — check SSH settings.'); },
        complete: function() { $b.prop('disabled', false).html('<i class="fa fa-search"></i> ' + $('<span>').text(T_VIEW).html()); }
    });
}
$(logLoad);
</script>

</body>
</html>
