<?php
declare(strict_types=1);

// Periodic health check for GumCP alerts. Run it from cron, e.g. every 5 min:
//   */5 * * * * php /var/www/html/GumCP/scripts/alert-check.php
// (System Check has a button that adds this line for you.)
//
// CLI only: this file sits under the web root, and a health check that anyone
// could trigger by URL would be a free way to spam the administrator.
if (PHP_SAPI !== 'cli') {
    http_response_code(404);
    exit();
}

$root = dirname(__DIR__);
if (!is_readable($root . '/include/config.php')) {
    fwrite(STDERR, "include/config.php is not readable by this user\n");
    exit(1);
}
// config.php starts a session and may contain a legacy auth gate; neither
// matters on the command line.
define('GUMCP_API_REQUEST', true);
@require_once($root . '/include/config.php');
require_once($root . '/include/config.defaults.php');
require_once($root . '/include/alerts.php');

if (!gumcp_alert_configured()) {
    echo "No alert channel configured (ALERT_NTFY_URL or ALERT_TELEGRAM_*).\n";
    exit(0);
}

$sent = [];

// CPU temperature
$raw = @file_get_contents('/sys/class/thermal/thermal_zone0/temp');
if ($raw !== false) {
    $temp = ((int)trim($raw)) / 1000;
    if ($temp >= (float)ALERT_TEMP_THRESHOLD
        && gumcp_alert_once('temp', 'CPU temperature high',
               sprintf('%.1f °C (threshold %d °C). Check cooling.', $temp, ALERT_TEMP_THRESHOLD))) {
        $sent[] = 'temp';
    }
}

// Under-voltage / throttling (bit 0 = under-voltage now, bit 2 = throttled now)
$thr = @shell_exec('vcgencmd get_throttled 2>/dev/null');
if (is_string($thr) && preg_match('/0x([0-9a-fA-F]+)/', $thr, $m)) {
    $bits = hexdec($m[1]);
    if (($bits & 0x1) && gumcp_alert_once('undervolt', 'Under-voltage detected',
            'The power supply is sagging — use a stronger supply or a shorter cable.')) {
        $sent[] = 'undervolt';
    }
    if (($bits & 0x4) && gumcp_alert_once('throttled', 'CPU is being throttled',
            'The firmware is limiting CPU speed (heat or power).')) {
        $sent[] = 'throttled';
    }
}

// Root filesystem
$total = @disk_total_space('/');
$free  = @disk_free_space('/');
if ($total && $free !== false) {
    $used = 100 - ($free / $total * 100);
    if ($used >= (float)ALERT_DISK_THRESHOLD
        && gumcp_alert_once('disk', 'Disk almost full',
               sprintf('%.0f%% of / is used (threshold %d%%).', $used, ALERT_DISK_THRESHOLD), 6 * 3600)) {
        $sent[] = 'disk';
    }
}

echo $sent ? 'Alerts sent: ' . implode(', ', $sent) . "\n" : "All clear.\n";
