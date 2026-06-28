<?php
declare(strict_types=1);

$active_page = 'cron';

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
    <meta name="description" content="GumCP Cron Jobs">
    <link rel="shortcut icon" href="./static/images/raspberry.png" type="image/png">
    <link rel="icon"          href="./static/images/raspberry.png" type="image/png">
    <title>GumCP Cron Jobs</title>
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
        <h1><i class="fa fa-clock-o"></i> Cron Jobs
            <small>scheduled tasks for the SSH user</small>
        </h1>
    </div>

    <!-- Add new job -->
    <div class="panel panel-success">
        <div class="panel-heading"><i class="fa fa-plus"></i> Add Cron Job</div>
        <div class="panel-body">
            <form class="form-inline" onsubmit="return false">
                <div class="form-group">
                    <label for="cron-schedule">Schedule</label>
                    <input type="text" class="form-control" id="cron-schedule"
                           placeholder="e.g. 0 4 * * *  or  @reboot" size="20">
                </div>
                <div class="form-group">
                    <label for="cron-command">Command</label>
                    <input type="text" class="form-control" id="cron-command"
                           placeholder="e.g. /usr/bin/backup.sh" size="40">
                </div>
                <button class="btn btn-success" id="cron-add-btn" onclick="cronAdd()">
                    <i class="fa fa-plus"></i> Add
                </button>
            </form>
            <small class="help-block">
                Format: <code>minute hour day month weekday command</code>, or an
                <code>@reboot</code>/<code>@daily</code> keyword. See
                <a href="https://crontab.guru/" target="_blank" rel="noopener">crontab.guru</a>.
            </small>
        </div>
    </div>

    <!-- User crontab -->
    <div class="panel panel-default">
        <div class="panel-heading"><i class="fa fa-user"></i> User Crontab</div>
        <table class="table table-condensed" style="margin-bottom:0">
            <tbody id="cron-user-tbody">
                <tr><td class="text-muted" style="padding-left:15px">Loading…</td></tr>
            </tbody>
        </table>
    </div>

    <!-- System crontab (read-only) -->
    <div class="panel panel-default">
        <div class="panel-heading"><i class="fa fa-cogs"></i> /etc/crontab <small>(read-only)</small></div>
        <div class="panel-body">
            <pre id="cron-system" style="margin:0; max-height:300px; overflow:auto">Loading…</pre>
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

<script>
function esc(s) { return $('<div>').text(s == null ? '' : s).html(); }

function cronLoad() {
    $.ajax({
        type: 'POST', url: 'ajax.php', dataType: 'json',
        data: { action: 'cron_list', csrf_token: CSRF_TOKEN },
        success: function(d) {
            var user = (d && d.user) || '';
            var lines = user.split('\n');
            var html = '';
            lines.forEach(function(line, idx) {
                if (line.trim() === '') return;
                var isComment = line.trim().charAt(0) === '#';
                html += '<tr><td style="padding-left:15px; font-family:monospace; font-size:12px"'
                     + (isComment ? ' class="text-muted"' : '') + '>' + esc(line) + '</td>'
                     + '<td style="width:60px; text-align:right; padding-right:15px">'
                     + (isComment ? '' :
                        '<button class="btn btn-xs btn-danger" onclick="cronDelete(' + idx + ')">'
                        + '<i class="fa fa-trash"></i></button>')
                     + '</td></tr>';
            });
            if (html === '') {
                html = '<tr><td class="text-muted" style="padding-left:15px">No cron jobs for this user.</td></tr>';
            }
            $('#cron-user-tbody').html(html);
            $('#cron-system').text(((d && d.system) || '').trim() || '(empty or not readable)');
        },
        error: function() {
            $('#cron-user-tbody').html('<tr><td class="text-danger" style="padding-left:15px">Failed to load crontab.</td></tr>');
        }
    });
}

function cronAdd() {
    var schedule = $('#cron-schedule').val().trim();
    var command  = $('#cron-command').val().trim();
    if (schedule === '' || command === '') { alert('Enter a schedule and a command.'); return; }
    var $b = $('#cron-add-btn');
    $b.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i>');
    $.ajax({
        type: 'POST', url: 'ajax.php', dataType: 'json',
        data: { action: 'cron_add', schedule: schedule, command: command, csrf_token: CSRF_TOKEN },
        success: function(d) {
            if (d && d.type === 'success') {
                $('#cron-schedule').val(''); $('#cron-command').val('');
                cronLoad();
            } else { alert((d && d.message) || 'Failed to add'); }
        },
        error: function() { alert('Request failed — check SSH settings.'); },
        complete: function() { $b.prop('disabled', false).html('<i class="fa fa-plus"></i> Add'); }
    });
}

function cronDelete(idx) {
    if (!confirm('Remove this cron job?')) return;
    $.ajax({
        type: 'POST', url: 'ajax.php', dataType: 'json',
        data: { action: 'cron_delete', index: idx, csrf_token: CSRF_TOKEN },
        success: function(d) {
            if (d && d.type === 'success') { cronLoad(); }
            else { alert((d && d.message) || 'Failed to remove'); }
        },
        error: function() { alert('Request failed — check SSH settings.'); }
    });
}

$(cronLoad);
</script>

</body>
</html>
