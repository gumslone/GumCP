<?php
declare(strict_types=1);

$active_page = 'index';
require_once('./include/config.php');

if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// ── Data collection ───────────────────────────────────────────────────────────

function get_system_info(): array {
    return [
        'hostname'     => gethostname() ?: 'Unknown',
        'os'           => function_exists('php_uname') ? php_uname('s') . ' ' . php_uname('r') : 'Unknown',
        'kernel'       => function_exists('php_uname') ? php_uname('v') : 'Unknown',
        'uptime'       => get_uptime(),
        'load_average' => get_load_average(),
        'cpu_usage'    => get_cpu_usage(),
        'cpu_temp'     => get_cpu_temp(),
        'cpu_info'     => get_cpu_info(),
        'processes'    => get_process_count(),
        'date'         => date('Y-m-d H:i:s'),
        'memory'       => get_memory_info(),
        'disk'         => get_disk_info(),
        'top'          => (string)(@shell_exec('ps aux | sort -rk 4,4 | head -n 11') ?: ''),
        'users'        => (string)(@shell_exec('who') ?: ''),
        'disks'        => (string)(@shell_exec('df -h') ?: ''),
    ];
}

function get_uptime(): string {
    $raw = @file_get_contents('/proc/uptime');
    if ($raw === false) return 'Unknown';
    $sec = (int)explode(' ', $raw)[0];
    $d   = (int)floor($sec / 86400);
    $h   = (int)floor(($sec % 86400) / 3600);
    $m   = (int)floor(($sec % 3600) / 60);
    return sprintf('%d day%s, %d hour%s, %d minute%s',
        $d, $d !== 1 ? 's' : '',
        $h, $h !== 1 ? 's' : '',
        $m, $m !== 1 ? 's' : '');
}

function get_load_average(): array {
    $load = function_exists('sys_getloadavg') ? (sys_getloadavg() ?: [0, 0, 0]) : [0, 0, 0];
    return [round($load[0], 2), round($load[1], 2), round($load[2], 2)];
}

function get_cpu_usage(): int {
    $s1 = @file_get_contents('/proc/stat');
    if ($s1 === false) return 0;
    usleep(100000);
    $s2 = @file_get_contents('/proc/stat');
    if ($s2 === false) return 0;
    $parse = static fn(string $r): array => explode(' ', preg_replace('/\s+/', ' ', trim(explode("\n", $r)[0])));
    $a = $parse($s1); $b = $parse($s2);
    $idle  = (int)$b[4] - (int)$a[4];
    $total = 0;
    for ($i = 1; $i <= 8; $i++) $total += ((int)($b[$i] ?? 0)) - ((int)($a[$i] ?? 0));
    return $total > 0 ? (int)round(100 - ($idle * 100 / $total)) : 0;
}

function get_cpu_temp(): float {
    $raw = @file_get_contents('/sys/class/thermal/thermal_zone0/temp');
    return $raw !== false ? round((float)$raw / 1000, 1) : 0.0;
}

function get_cpu_info(): string {
    $raw = @file_get_contents('/proc/cpuinfo');
    if ($raw === false) return 'Unknown';
    if (preg_match('/model name\s+:\s+(.+)/i', $raw, $m)) return trim($m[1]);
    if (preg_match('/Hardware\s+:\s+(.+)/i',    $raw, $m)) return trim($m[1]);
    return 'Unknown';
}

function get_process_count(): int {
    $out = @shell_exec('ps ax | wc -l');
    return $out ? max(0, (int)trim($out) - 1) : 0;
}

function get_memory_info(): array {
    $def = ['total' => 0, 'used' => 0, 'free' => 0, 'percent' => 0, 'buffers' => 0, 'cached' => 0];
    $raw = @file_get_contents('/proc/meminfo');
    if ($raw === false) return $def;
    $get = static fn(string $k): int => preg_match('/^' . $k . ':\s+(\d+)/m', $raw, $m) ? (int)$m[1] : 0;
    $total     = $get('MemTotal');
    $free      = $get('MemFree');
    $available = $get('MemAvailable') ?: $free;
    $used      = $total - $available;
    return [
        'total'   => $total,
        'used'    => $used,
        'free'    => $available,
        'percent' => $total > 0 ? (int)round($used / $total * 100) : 0,
        'buffers' => $get('Buffers'),
        'cached'  => $get('Cached'),
    ];
}

function get_disk_info(): array {
    $def  = ['total' => 0.0, 'used' => 0.0, 'free' => 0.0, 'percent' => 0];
    $tot  = @disk_total_space('/');
    $free = @disk_free_space('/');
    if ($tot === false || $free === false || $tot == 0) return $def;
    $used = $tot - $free;
    return [
        'total'   => round($tot  / (1024 ** 3), 2),
        'used'    => round($used / (1024 ** 3), 2),
        'free'    => round($free / (1024 ** 3), 2),
        'percent' => (int)round($used / $tot * 100),
    ];
}

function fmt_kb(int $kb): string {
    return fmt_bytes((float)($kb * 1024));
}

function fmt_bytes(float $bytes): string {
    $units = ['B', 'KB', 'MB', 'GB', 'TB'];
    $i = $bytes > 0 ? min((int)log($bytes, 1024), count($units) - 1) : 0;
    return sprintf('%.2f %s', $bytes / (1024 ** $i), $units[$i]);
}

function bar_color(int $pct): string {
    return $pct >= 90 ? 'danger' : ($pct >= 70 ? 'warning' : 'success');
}

// ── Render prep ───────────────────────────────────────────────────────────────

$sys  = get_system_info();
$mem  = $sys['memory'];
$disk = $sys['disk'];

$cpu_color  = bar_color($sys['cpu_usage']);
$mem_color  = bar_color($mem['percent']);
$disk_color = bar_color($disk['percent']);
$temp_color = $sys['cpu_temp'] >= 80 ? 'danger' : ($sys['cpu_temp'] >= 70 ? 'warning' : 'success');

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="GumCP System Dashboard">
    <link rel="shortcut icon" href="./static/images/raspberry.png" type="image/png">
    <link rel="icon"          href="./static/images/raspberry.png" type="image/png">
    <title>GumCP &mdash; System Dashboard</title>
    <link href="./static/css.php" rel="stylesheet" type="text/css">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <script src="./static/js.php" type="text/javascript"></script>
    <style>
        body { background-color: #f5f5f5; }
        .stat-box { text-align:center; padding:20px; background:#fff; border-radius:4px;
                    box-shadow:0 2px 4px rgba(0,0,0,.1); margin-bottom:20px; }
        .stat-box h3 { margin:10px 0 6px; font-size:36px; font-weight:bold; }
        .stat-box p  { margin:0; color:#777; }
        .progress { height:30px; margin-bottom:10px; }
        .progress-bar { line-height:30px; font-size:14px; }
        pre { background:#f8f8f8; border:1px solid #ddd; border-radius:4px;
              padding:10px; font-size:12px; max-height:400px; overflow-y:auto; }
        .info-table { margin-bottom:0; }
        .info-table td { padding:8px; border-top:1px solid #ddd; }
        .info-table td:first-child { font-weight:bold; width:30%; }
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

    <div class="row">
        <div class="col-md-12">
            <h1 class="page-header">
                <i class="fa fa-dashboard"></i> System Dashboard
                <small><?php echo htmlspecialchars($sys['hostname'], ENT_QUOTES, 'UTF-8'); ?></small>
            </h1>
        </div>
    </div>

    <!-- Quick stat boxes -->
    <div class="row">
        <div class="col-md-3 col-sm-6">
            <div class="stat-box">
                <i class="fa fa-tachometer fa-3x text-primary"></i>
                <h3 id="stat-cpu" class="text-<?php echo $cpu_color; ?>"><?php echo $sys['cpu_usage']; ?>%</h3>
                <p>CPU Usage</p>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="stat-box">
                <i class="fa fa-server fa-3x text-info"></i>
                <h3 id="stat-mem" class="text-<?php echo $mem_color; ?>"><?php echo $mem['percent']; ?>%</h3>
                <p>Memory Usage</p>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="stat-box">
                <i class="fa fa-hdd-o fa-3x text-warning"></i>
                <h3 id="stat-disk" class="text-<?php echo $disk_color; ?>"><?php echo $disk['percent']; ?>%</h3>
                <p>Disk Usage</p>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="stat-box">
                <i class="fa fa-thermometer-half fa-3x text-danger"></i>
                <h3 id="stat-temp" class="text-<?php echo $temp_color; ?>"><?php echo $sys['cpu_temp']; ?>&deg;C</h3>
                <p>CPU Temperature</p>
            </div>
        </div>
    </div>

    <!-- System info + resource bars -->
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading"><i class="fa fa-info-circle"></i> System Information</div>
                <div class="panel-body">
                    <table class="table info-table">
                        <tbody>
                            <tr><td>Hostname</td>
                                <td><?php echo htmlspecialchars($sys['hostname'],  ENT_QUOTES, 'UTF-8'); ?></td></tr>
                            <tr><td>Operating System</td>
                                <td><?php echo htmlspecialchars($sys['os'],        ENT_QUOTES, 'UTF-8'); ?></td></tr>
                            <tr><td>Kernel</td>
                                <td><?php echo htmlspecialchars($sys['kernel'],    ENT_QUOTES, 'UTF-8'); ?></td></tr>
                            <tr><td>CPU</td>
                                <td><?php echo htmlspecialchars($sys['cpu_info'],  ENT_QUOTES, 'UTF-8'); ?></td></tr>
                            <tr><td>Uptime</td>
                                <td id="info-uptime"><?php echo htmlspecialchars($sys['uptime'], ENT_QUOTES, 'UTF-8'); ?></td></tr>
                            <tr><td>Date / Time</td>
                                <td id="info-date"><?php echo htmlspecialchars($sys['date'],   ENT_QUOTES, 'UTF-8'); ?></td></tr>
                            <tr><td>Processes</td>
                                <td id="info-processes"><?php echo (int)$sys['processes']; ?></td></tr>
                            <tr><td>Load Average</td>
                                <td id="info-load"><?php echo implode(', ', $sys['load_average']); ?></td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="panel panel-success">
                <div class="panel-heading"><i class="fa fa-area-chart"></i> Resource Usage</div>
                <div class="panel-body">

                    <div class="form-group">
                        <label>CPU Usage</label>
                        <div class="progress">
                            <div id="bar-cpu" class="progress-bar progress-bar-<?php echo $cpu_color; ?>"
                                 role="progressbar"
                                 aria-valuenow="<?php echo $sys['cpu_usage']; ?>"
                                 aria-valuemin="0" aria-valuemax="100"
                                 style="width:<?php echo $sys['cpu_usage']; ?>%">
                                <?php echo $sys['cpu_usage']; ?>%
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Memory Usage</label>
                        <div class="progress">
                            <div id="bar-mem" class="progress-bar progress-bar-<?php echo $mem_color; ?>"
                                 role="progressbar"
                                 aria-valuenow="<?php echo $mem['percent']; ?>"
                                 aria-valuemin="0" aria-valuemax="100"
                                 style="width:<?php echo $mem['percent']; ?>%">
                                <?php echo $mem['percent']; ?>%
                                (<?php echo fmt_kb($mem['used']); ?> / <?php echo fmt_kb($mem['total']); ?>)
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Disk Usage</label>
                        <div class="progress">
                            <div id="bar-disk" class="progress-bar progress-bar-<?php echo $disk_color; ?>"
                                 role="progressbar"
                                 aria-valuenow="<?php echo $disk['percent']; ?>"
                                 aria-valuemin="0" aria-valuemax="100"
                                 style="width:<?php echo $disk['percent']; ?>%">
                                <?php echo $disk['percent']; ?>%
                                (<?php echo $disk['used']; ?> GB / <?php echo $disk['total']; ?> GB)
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>CPU Temperature</label>
                        <div class="progress">
                            <div id="bar-temp" class="progress-bar progress-bar-<?php echo $temp_color; ?>"
                                 role="progressbar"
                                 aria-valuenow="<?php echo $sys['cpu_temp']; ?>"
                                 aria-valuemin="0" aria-valuemax="100"
                                 style="width:<?php echo min($sys['cpu_temp'], 100); ?>%">
                                <?php echo $sys['cpu_temp']; ?>&deg;C
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Memory breakdown -->
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-info">
                <div class="panel-heading"><i class="fa fa-server"></i> Memory Details</div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-3 col-sm-6 text-center">
                            <h4>Total</h4>
                            <p class="text-muted" id="mem-total"><?php echo fmt_kb($mem['total']); ?></p>
                        </div>
                        <div class="col-md-3 col-sm-6 text-center">
                            <h4>Used</h4>
                            <p class="text-<?php echo $mem_color; ?>" id="mem-used"><?php echo fmt_kb($mem['used']); ?></p>
                        </div>
                        <div class="col-md-3 col-sm-6 text-center">
                            <h4>Buffers</h4>
                            <p class="text-muted" id="mem-buffers"><?php echo fmt_kb($mem['buffers']); ?></p>
                        </div>
                        <div class="col-md-3 col-sm-6 text-center">
                            <h4>Cached</h4>
                            <p class="text-muted" id="mem-cached"><?php echo fmt_kb($mem['cached']); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Disk list -->
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-warning">
                <div class="panel-heading"><i class="fa fa-hdd-o"></i> Disk Information</div>
                <div class="panel-body">
                    <pre id="info-disks"><?php echo htmlspecialchars($sys['disks'], ENT_QUOTES, 'UTF-8'); ?></pre>
                </div>
            </div>
        </div>
    </div>

    <!-- Top processes -->
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading"><i class="fa fa-tasks"></i> Top Processes (by Memory)</div>
                <div class="panel-body">
                    <pre id="info-top"><?php echo htmlspecialchars($sys['top'], ENT_QUOTES, 'UTF-8'); ?></pre>
                </div>
            </div>
        </div>
    </div>

    <!-- Active users -->
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading"><i class="fa fa-users"></i> Active Users</div>
                <div class="panel-body">
                    <pre id="info-users"><?php echo htmlspecialchars($sys['users'], ENT_QUOTES, 'UTF-8'); ?></pre>
                </div>
            </div>
        </div>
    </div>

</div><!-- /.container -->

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
// Live-update stat boxes and bars via server_info AJAX — no full page reload needed.
function barColor(pct) {
    return pct >= 90 ? 'danger' : (pct >= 70 ? 'warning' : 'success');
}

function setBar(id, pct, label) {
    var c = barColor(pct);
    var $b = $('#' + id);
    $b.css('width', Math.min(pct, 100) + '%')
      .attr('aria-valuenow', pct)
      .text(label)
      .removeClass('progress-bar-success progress-bar-warning progress-bar-danger')
      .addClass('progress-bar-' + c);
}

function setStat(id, text, pct) {
    var c = barColor(pct);
    $('#' + id)
      .text(text)
      .removeClass('text-success text-warning text-danger')
      .addClass('text-' + c);
}

function fmtKB(kb) {
    var units = ['KB', 'MB', 'GB', 'TB'], i = 0, v = kb;
    while (v >= 1024 && i < units.length - 1) { v /= 1024; i++; }
    return v.toFixed(2) + ' ' + units[i];
}

function refreshStats() {
    $.ajax({
        type: 'GET',
        url: 'ajax.php',
        data: { action: 'server_info' },
        dataType: 'json',
        success: function(d) {
            if (!d || d.type === 'error') return;

            // Stat boxes
            var tempColor = d.temp >= 80 ? 'danger' : (d.temp >= 70 ? 'warning' : 'success');
            setStat('stat-cpu',  d.cpuusage + '%',  d.cpuusage);
            setStat('stat-mem',  d.memory_percentage + '%', d.memory_percentage);
            setStat('stat-disk', d.disk_percentage + '%',   d.disk_percentage);
            $('#stat-temp')
                .text(d.temp + '°C')
                .removeClass('text-success text-warning text-danger')
                .addClass('text-' + tempColor);

            // Progress bars
            setBar('bar-cpu',  d.cpuusage, d.cpuusage + '%');
            var memLabel = d.memory_percentage + '% (' + fmtKB(d.memory_used) + ' / ' + fmtKB(d.memory_total) + ')';
            setBar('bar-mem',  d.memory_percentage, memLabel);
            setBar('bar-disk', d.disk_percentage,
                d.disk_percentage + '% (' + d.disk_used + ' / ' + d.disk_total + ')');
            setBar('bar-temp', Math.min(d.temp, 100), d.temp + '°C');

            // Memory details
            $('#mem-total').text(fmtKB(d.memory_total));
            $('#mem-used').text(fmtKB(d.memory_used));
            $('#mem-buffers').text(fmtKB(d.memory_buffers));
            $('#mem-cached').text(fmtKB(d.memory_cached));

            // Info table
            $('#info-uptime').text(d.uptime);
            $('#info-date').text(d.date);
            $('#info-processes').text(d.processes);
            $('#info-load').text(d.load0 + ', ' + d.load1 + ', ' + d.load2);

            // Pre blocks (escape server output before inserting)
            function esc(s) {
                return $('<div>').text(s || '').html();
            }
            $('#info-top').html(esc(d.top));
            $('#info-users').html(esc(d.users));
            $('#info-disks').html(esc(d.disks));
        }
    });
}

$(function() {
    setInterval(refreshStats, 30000);
});
</script>

</body>
</html>
