<?php
declare(strict_types=1);

$active_page = 'rpi';

require_once('./include/init.php');

if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$interfaces = [
    'i2c'     => 'I2C',
    'spi'     => 'SPI',
    'onewire' => '1-Wire',
    'ssh'     => 'SSH server',
    'vnc'     => 'VNC server',
    'camera'  => 'Camera (legacy)',
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="GumCP Raspberry Pi tools">
    <link rel="shortcut icon" href="./static/images/raspberry.png" type="image/png">
    <link rel="icon"          href="./static/images/raspberry.png" type="image/png">
    <title>GumCP Raspberry Pi</title>
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
        <h1><i class="fa fa-microchip"></i> Raspberry Pi</h1>
    </div>

    <div class="row">
        <!-- vcgencmd metrics -->
        <div class="col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <i class="fa fa-tachometer"></i> Firmware &amp; Clocks
                    <a href="#" onclick="rpiMetrics(); return false;" class="pull-right" style="color:#fff"><i class="fa fa-refresh"></i></a>
                </div>
                <table class="table table-condensed" style="margin-bottom:0" id="rpi-metrics">
                    <tbody><tr><td class="text-muted" style="padding-left:15px">Loading…</td></tr></tbody>
                </table>
            </div>
        </div>

        <!-- Temp / CPU history -->
        <div class="col-md-6">
            <div class="panel panel-info">
                <div class="panel-heading"><i class="fa fa-line-chart"></i> Temperature &amp; CPU Frequency</div>
                <div class="panel-body">
                    <canvas id="rpi-chart" height="180" style="width:100%"></canvas>
                    <p class="text-muted" style="font-size:12px; margin:6px 0 0">
                        <span style="color:#d9534f">●</span> Temp (°C)
                        &nbsp; <span style="color:#337ab7">●</span> CPU (MHz)
                        &nbsp;— sampled while this page is open.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Interface toggles -->
    <div class="panel panel-default">
        <div class="panel-heading"><i class="fa fa-plug"></i> Interfaces <small>(raspi-config)</small></div>
        <table class="table table-condensed" style="margin-bottom:0">
            <tbody>
                <?php foreach ($interfaces as $key => $label): ?>
                    <tr>
                        <td style="padding-left:15px; width:200px"><strong><?php echo $label; ?></strong></td>
                        <td><span class="label label-default" id="iface-state-<?php echo $key; ?>">…</span></td>
                        <td style="text-align:right; padding-right:15px">
                            <button class="btn btn-xs btn-success" onclick="rpiToggle('<?php echo $key; ?>', 1)">Enable</button>
                            <button class="btn btn-xs btn-default" onclick="rpiToggle('<?php echo $key; ?>', 0)">Disable</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="panel-footer text-muted" style="font-size:12px">
            Some changes require a reboot. Camera toggle applies only to the legacy stack.
        </div>
    </div>

    <!-- Boot config editor -->
    <div class="panel panel-danger">
        <div class="panel-heading"><i class="fa fa-file-code-o"></i> Boot Configuration</div>
        <div class="panel-body">
            <div class="alert alert-danger" style="margin-bottom:12px">
                <i class="fa fa-exclamation-triangle fa-lg"></i>
                <strong>Change with care.</strong>
                These files control how the Raspberry Pi boots. A wrong value in
                <code>config.txt</code> or <code>cmdline.txt</code> can make the Pi
                <strong>fail to boot</strong> or lose network/SSH access — which may
                require pulling the SD card and editing it on another computer to recover.
                A timestamped backup (<code>.gumcp.bak</code>) is written before every save,
                but only edit these if you know what each line does.
            </div>
            <form class="form-inline" onsubmit="return false" style="margin-bottom:8px">
                <div class="form-group">
                    <select class="form-control" id="boot-file">
                        <option value="config">config.txt</option>
                        <option value="cmdline">cmdline.txt</option>
                    </select>
                </div>
                <button class="btn btn-default" onclick="bootLoad()"><i class="fa fa-folder-open"></i> Load</button>
                <button class="btn btn-warning" id="boot-save-btn" onclick="bootSave()"><i class="fa fa-save"></i> Save</button>
                <span class="text-muted" id="boot-path" style="margin-left:8px; font-size:12px"></span>
            </form>
            <textarea id="boot-content" class="form-control" rows="12"
                      style="font-family:monospace; font-size:12px" spellcheck="false"></textarea>

            <div id="boot-notice" class="alert" style="display:none; margin-top:10px"></div>

            <small class="help-block">
                <i class="fa fa-shield"></i> A backup (<code>.gumcp.bak</code>) is written before each save.
                Most changes take effect after a reboot.
            </small>
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

/* ── vcgencmd metrics ── */
function rpiMetrics() {
    $.ajax({
        type: 'POST', url: 'ajax.php', dataType: 'json',
        data: { action: 'rpi_metrics', csrf_token: CSRF_TOKEN },
        success: function(d) {
            if (!d || d.type === 'error') {
                $('#rpi-metrics tbody').html('<tr><td class="text-muted" style="padding-left:15px">'
                    + ((d && d.message) || 'vcgencmd not available') + '</td></tr>');
                return;
            }
            var rows = [
                ['Firmware', d.firmware], ['ARM clock', d.arm_clock], ['Core clock', d.core_clock],
                ['V3D clock', d.v3d_clock], ['Core voltage', d.core_volt], ['SDRAM voltage', d.sdram_volt],
                ['ARM memory', d.mem_arm], ['GPU memory', d.mem_gpu]
            ];
            var html = '';
            rows.forEach(function(r) {
                html += '<tr><td style="padding-left:15px"><strong>' + esc(r[0]) + '</strong></td>'
                     + '<td style="font-family:monospace">' + esc(r[1]) + '</td></tr>';
            });
            var codecs = d.codecs || {};
            var cstr = Object.keys(codecs).map(function(k) {
                return k + ': ' + codecs[k];
            }).join(', ');
            html += '<tr><td style="padding-left:15px"><strong>Codecs</strong></td><td style="font-size:12px">' + esc(cstr) + '</td></tr>';
            $('#rpi-metrics tbody').html(html);
        },
        error: function() { $('#rpi-metrics tbody').html('<tr><td class="text-danger" style="padding-left:15px">Request failed.</td></tr>'); }
    });
}

/* ── interfaces ── */
function rpiIfaceStatus() {
    $.ajax({
        type: 'POST', url: 'ajax.php', dataType: 'json',
        data: { action: 'rpi_iface_status', csrf_token: CSRF_TOKEN },
        success: function(d) {
            var s = (d && d.states) || {};
            Object.keys(s).forEach(function(k) {
                var $el = $('#iface-state-' + k);
                if (!$el.length) return;
                var v = s[k];
                $el.text(v).removeClass('label-default label-success label-warning')
                   .addClass(v === 'enabled' ? 'label-success' : (v === 'disabled' ? 'label-default' : 'label-warning'));
            });
        }
    });
}

function rpiToggle(iface, enable) {
    if (!confirm((enable ? 'Enable ' : 'Disable ') + iface.toUpperCase() + '?')) return;
    $.ajax({
        type: 'POST', url: 'ajax.php', dataType: 'json',
        data: { action: 'rpi_interface', iface: iface, enable: enable, csrf_token: CSRF_TOKEN },
        success: function(d) {
            if (d && d.type === 'error') alert(d.message);
            rpiIfaceStatus();
        },
        error: function() { alert('Request failed — check SSH settings.'); }
    });
}

/* ── boot config ── */
function bootLoad() {
    $('#boot-content').val('Loading…');
    $.ajax({
        type: 'POST', url: 'ajax.php', dataType: 'json',
        data: { action: 'boot_config_read', file: $('#boot-file').val(), csrf_token: CSRF_TOKEN },
        success: function(d) {
            if (d && d.type === 'error') { $('#boot-content').val(''); alert(d.message); return; }
            $('#boot-content').val((d && d.content) || '');
            $('#boot-path').text((d && d.path) || '');
        },
        error: function() { $('#boot-content').val(''); alert('Request failed — check SSH settings.'); }
    });
}

function bootNotice(type, html) {
    $('#boot-notice')
        .removeClass('alert-success alert-danger alert-info')
        .addClass('alert-' + type)
        .html(html)
        .show();
}

function bootSave() {
    var file = $('#boot-file').val();
    var fname = file === 'cmdline' ? 'cmdline.txt' : 'config.txt';
    var path = $('#boot-path').text() || ('/boot/' + fname);

    if (!confirm(
        '⚠ WARNING — editing boot files can stop the Raspberry Pi from booting.\n\n'
        + 'You are about to overwrite:\n    ' + path + '\n\n'
        + 'A backup (' + fname + '.gumcp.bak) will be written first.\n'
        + 'Most changes take effect after a reboot.\n\n'
        + 'Save this file now?'
    )) return;

    var $b = $('#boot-save-btn');
    $b.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Saving…');
    bootNotice('info', '<i class="fa fa-spinner fa-spin"></i> Saving ' + esc(fname) + '…');

    $.ajax({
        type: 'POST', url: 'ajax.php', dataType: 'json',
        data: { action: 'boot_config_save', file: file,
                content: $('#boot-content').val(), csrf_token: CSRF_TOKEN },
        success: function(d) {
            if (d && d.type === 'success') {
                bootNotice('success',
                    '<i class="fa fa-check-circle"></i> <strong>' + esc(fname) + ' saved.</strong> '
                    + esc(d.message || '') + ' <strong>Reboot</strong> for changes to take effect.');
            } else {
                bootNotice('danger',
                    '<i class="fa fa-exclamation-triangle"></i> <strong>Save failed:</strong> '
                    + esc((d && d.message) || 'unknown error'));
            }
        },
        error: function() {
            bootNotice('danger', '<i class="fa fa-exclamation-triangle"></i> Request failed — check SSH settings.');
        },
        complete: function() { $b.prop('disabled', false).html('<i class="fa fa-save"></i> Save'); }
    });
}

/* ── temp/CPU history chart ── */
var chartData = [];
function drawChart() {
    var c = document.getElementById('rpi-chart');
    if (!c) return;
    var w = c.width = c.offsetWidth, h = c.height;
    var ctx = c.getContext('2d');
    ctx.clearRect(0, 0, w, h);
    if (chartData.length < 2) {
        ctx.fillStyle = '#999'; ctx.font = '12px sans-serif';
        ctx.fillText('Collecting samples…', 10, 20);
        return;
    }
    var pad = 4;
    var temps = chartData.map(function(p) { return p.temp; });
    var freqs = chartData.map(function(p) { return p.freq; });
    var tMax = Math.max(90, Math.max.apply(null, temps));
    var fMax = Math.max.apply(null, freqs) || 1;
    function line(vals, max, color) {
        ctx.beginPath();
        vals.forEach(function(v, i) {
            var x = pad + (w - 2 * pad) * (i / (vals.length - 1));
            var y = h - pad - (h - 2 * pad) * (v / max);
            if (i === 0) ctx.moveTo(x, y); else ctx.lineTo(x, y);
        });
        ctx.strokeStyle = color; ctx.lineWidth = 2; ctx.stroke();
    }
    line(temps, tMax, '#d9534f');
    line(freqs, fMax, '#337ab7');
}

function chartPoll() {
    $.ajax({
        type: 'POST', url: 'ajax.php', dataType: 'json',
        data: { action: 'metrics_history', csrf_token: CSRF_TOKEN },
        success: function(d) {
            if (d && d.history) { chartData = d.history; drawChart(); }
        }
    });
}

$(function() {
    rpiMetrics();
    rpiIfaceStatus();
    bootLoad();
    chartPoll();
    setInterval(chartPoll, 30000);
    window.addEventListener('resize', drawChart);
});
</script>

</body>
</html>
