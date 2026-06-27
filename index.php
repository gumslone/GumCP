<?php
declare(strict_types=1);

$active_page = 'index';
require_once('./include/init.php');
require_once('./include/dashboard.php');

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
        'usb'          => (string)(@shell_exec('lsusb 2>/dev/null') ?: ''),
        'blk'          => (string)(@shell_exec('lsblk 2>/dev/null') ?: ''),
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
    $parse = static function(string $r): array {
        return explode(' ', preg_replace('/\s+/', ' ', trim(explode("\n", $r)[0])));
    };
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
    $get = static function(string $k) use ($raw): int {
        return preg_match('/^' . $k . ':\s+(\d+)/m', $raw, $m) ? (int)$m[1] : 0;
    };
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

// Extra dashboard data
$swap       = gumcp_swap_info();
$swap_color = bar_color($swap['percent']);
$network    = gumcp_network_info();
$throttled  = gumcp_throttled_info();
$services   = gumcp_service_status(
    is_array($gumcp_dashboard_services ?? null) ? $gumcp_dashboard_services : []
);

// Map a systemd state to a Bootstrap label class.
function service_label_class(string $state): string {
    switch ($state) {
        case 'active':   return 'label-success';
        case 'inactive': return 'label-default';
        case 'failed':   return 'label-danger';
        default:         return 'label-warning';
    }
}

// Format Wi-Fi signal (dBm) to a short quality word.
function signal_quality($dbm): string {
    if ($dbm === null) return '';
    if ($dbm >= -50) return 'excellent';
    if ($dbm >= -60) return 'good';
    if ($dbm >= -70) return 'fair';
    return 'weak';
}

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
                    <li>
                        <a href="#" title="Reorder menu"
                           onclick="openMenuReorder(); return false;"
                           style="opacity:.6">
                            <i class="fa fa-bars"></i>
                        </a>
                    </li>
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

    <!-- Service badges + power/throttle status -->
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading"><i class="fa fa-heartbeat"></i> Service Status</div>
                <div class="panel-body" id="service-badges">
                    <?php if (empty($services)): ?>
                        <span class="text-muted">No services configured.
                            Set <code>$gumcp_dashboard_services</code> in <code>config.php</code>.</span>
                    <?php else: foreach ($services as $svc): ?>
                        <span class="label <?php echo service_label_class($svc['state']); ?>"
                              style="display:inline-block; margin:3px; padding:6px 10px; font-size:13px"
                              title="<?php echo htmlspecialchars($svc['state'], ENT_QUOTES, 'UTF-8'); ?>">
                            <i class="fa fa-circle"></i>
                            <?php echo htmlspecialchars($svc['name'], ENT_QUOTES, 'UTF-8'); ?>
                        </span>
                    <?php endforeach; endif; ?>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading"><i class="fa fa-bolt"></i> Power &amp; Throttling</div>
                <div class="panel-body" id="throttle-status">
                    <?php if (!$throttled['available']): ?>
                        <span class="text-muted">
                            <i class="fa fa-question-circle"></i>
                            Not available (<code>vcgencmd</code> not found — non-Pi hardware?)
                        </span>
                    <?php elseif ($throttled['healthy']): ?>
                        <span class="text-success">
                            <i class="fa fa-check-circle"></i> Healthy — no under-voltage or throttling.
                        </span>
                    <?php else: ?>
                        <?php foreach ($throttled['messages'] as $msg): ?>
                            <div class="text-danger">
                                <i class="fa fa-exclamation-triangle"></i>
                                <?php echo htmlspecialchars($msg, ENT_QUOTES, 'UTF-8'); ?>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
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
                        <label>Swap Usage</label>
                        <div class="progress">
                            <div id="bar-swap" class="progress-bar progress-bar-<?php echo $swap_color; ?>"
                                 role="progressbar"
                                 aria-valuenow="<?php echo $swap['percent']; ?>"
                                 aria-valuemin="0" aria-valuemax="100"
                                 style="width:<?php echo $swap['percent']; ?>%">
                                <?php if ($swap['total'] > 0): ?>
                                    <?php echo $swap['percent']; ?>%
                                    (<?php echo fmt_kb($swap['used']); ?> / <?php echo fmt_kb($swap['total']); ?>)
                                <?php else: ?>
                                    No swap
                                <?php endif; ?>
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

    <!-- Network -->
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-info">
                <div class="panel-heading"><i class="fa fa-sitemap"></i> Network</div>
                <div class="panel-body" style="padding:0">
                    <table class="table table-condensed" style="margin-bottom:0" id="network-table">
                        <thead>
                            <tr>
                                <th style="padding-left:15px">Interface</th>
                                <th>IPv4</th>
                                <th>State</th>
                                <th>Signal</th>
                                <th class="text-right">Received</th>
                                <th class="text-right" style="padding-right:15px">Transmitted</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($network)): ?>
                                <tr><td colspan="6" class="text-muted" style="padding-left:15px">No network interfaces found.</td></tr>
                            <?php else: foreach ($network as $n):
                                $up = $n['state'] === 'up';
                                $sig = $n['signal'] !== null
                                    ? $n['signal'] . ' dBm (' . signal_quality($n['signal']) . ')'
                                    : ($n['wireless'] ? '—' : '');
                            ?>
                                <tr>
                                    <td style="padding-left:15px">
                                        <i class="fa <?php echo $n['wireless'] ? 'fa-wifi' : 'fa-exchange'; ?> text-muted"></i>
                                        <strong><?php echo htmlspecialchars($n['iface'], ENT_QUOTES, 'UTF-8'); ?></strong>
                                    </td>
                                    <td><?php echo $n['ip'] !== '' ? htmlspecialchars($n['ip'], ENT_QUOTES, 'UTF-8') : '<span class="text-muted">—</span>'; ?></td>
                                    <td>
                                        <span class="label <?php echo $up ? 'label-success' : 'label-default'; ?>">
                                            <?php echo htmlspecialchars($n['state'], ENT_QUOTES, 'UTF-8'); ?>
                                        </span>
                                    </td>
                                    <td><?php echo htmlspecialchars($sig, ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td class="text-right"><?php echo gumcp_fmt_bytes((float)$n['rx']); ?></td>
                                    <td class="text-right" style="padding-right:15px"><?php echo gumcp_fmt_bytes((float)$n['tx']); ?></td>
                                </tr>
                            <?php endforeach; endif; ?>
                        </tbody>
                    </table>
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

    <!-- Connected USB devices -->
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading"><i class="fa fa-usb"></i> Connected USB Devices</div>
                <div class="panel-body">
                    <?php if (trim($sys['usb']) === ''): ?>
                        <pre id="info-usb" class="text-muted">No USB devices listed (<code>lsusb</code> not installed? <code>sudo apt-get install usbutils</code>)</pre>
                    <?php else: ?>
                        <pre id="info-usb"><?php echo htmlspecialchars($sys['usb'], ENT_QUOTES, 'UTF-8'); ?></pre>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Block devices -->
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading"><i class="fa fa-hdd-o"></i> Block Devices</div>
                <div class="panel-body">
                    <?php if (trim($sys['blk']) === ''): ?>
                        <pre id="info-blk" class="text-muted">No block devices listed (<code>lsblk</code> not available?)</pre>
                    <?php else: ?>
                        <pre id="info-blk"><?php echo htmlspecialchars($sys['blk'], ENT_QUOTES, 'UTF-8'); ?></pre>
                    <?php endif; ?>
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
var CSRF_TOKEN = <?php echo json_encode($_SESSION['csrf_token']); ?>;
</script>

<?php
// Build ordered active-module list for the reorder modal
$menu_order_file = __DIR__ . '/include/menu_order.json';
$saved_menu_order = [];
if (is_readable($menu_order_file)) {
    $decoded = json_decode(file_get_contents($menu_order_file), true);
    if (is_array($decoded)) $saved_menu_order = $decoded;
}
$modal_modules = [];
if (!empty($saved_menu_order)) {
    foreach ($saved_menu_order as $k) {
        if (isset($gumcp_modules[$k]) && ($gumcp_modules[$k]['module_active'] ?? 0) == 1
            && empty($gumcp_modules[$k]['module_no_nav'])) {
            $modal_modules[$k] = $gumcp_modules[$k];
        }
    }
}
foreach ($gumcp_modules as $k => $m) {
    if (($m['module_active'] ?? 0) == 1 && !isset($modal_modules[$k])
        && empty($m['module_no_nav'])) {
        $modal_modules[$k] = $m;
    }
}
?>

<!-- Menu Reorder Modal -->
<div class="modal fade" id="menu-reorder-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                <h4 class="modal-title"><i class="fa fa-bars"></i> Reorder Menu</h4>
            </div>
            <div class="modal-body">
                <p class="text-muted" style="font-size:12px; margin-bottom:8px">
                    Drag items to reorder. Dashboard is always first.
                </p>
                <ul id="menu-sortable-list">
                    <li class="menu-item-fixed">
                        <i class="fa fa-home fa-fw"></i> Dashboard
                    </li>
                    <?php foreach ($modal_modules as $key => $mod): ?>
                    <li data-key="<?php echo htmlspecialchars($key, ENT_QUOTES, 'UTF-8'); ?>"
                        draggable="true">
                        <i class="fa fa-bars fa-fw text-muted"></i>
                        <?php echo htmlspecialchars($mod['module_title'] ?? $key, ENT_QUOTES, 'UTF-8'); ?>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="menu-reorder-save-btn"
                        onclick="saveMenuOrder()">
                    <i class="fa fa-save"></i> Save
                </button>
            </div>
        </div>
    </div>
</div>

</body>
</html>
