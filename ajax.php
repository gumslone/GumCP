<?php
declare(strict_types=1);

// Send JSON header first so every response — including early errors — is typed.
header('Content-Type: application/json');

require_once('./include/init.php');

// ── CSRF guard (all POST requests) ───────────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = (string)($_POST['csrf_token'] ?? '');
    if (!isset($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $token)) {
        http_response_code(403);
        echo json_encode(err('CSRF token mismatch'));
        exit();
    }
}

// ── Response helpers ──────────────────────────────────────────────────────────
function ok(string $message, array $extra = []): array {
    return array_merge(['type' => 'success', 'message' => $message], $extra);
}

function err(string $message): array {
    return ['type' => 'error', 'message' => $message];
}

// ── SSH helper ────────────────────────────────────────────────────────────────
require_once(__DIR__ . '/include/ssh.php');

// ── Dashboard collectors ──────────────────────────────────────────────────────
require_once(__DIR__ . '/include/dashboard.php');

// ── Button storage helpers ────────────────────────────────────────────────────
const BUTTONS_FILE = __DIR__ . '/buttons/buttons.json';
const BUTTONS_DIR  = __DIR__ . '/buttons';

function load_buttons() {
    if (!file_exists(BUTTONS_FILE)) {
        return [];
    }
    $raw = file_get_contents(BUTTONS_FILE);
    if ($raw === false) {
        return null;
    }
    $data = json_decode($raw, true);
    return is_array($data) ? $data : null;
}

// Returns an empty string on success, or an error message on failure.
function save_buttons(array $buttons): string {
    if (!is_dir(BUTTONS_DIR)) {
        if (!@mkdir(BUTTONS_DIR, 0755, true)) {
            return 'Cannot create ' . BUTTONS_DIR
                 . ' — fix with: sudo mkdir -p ' . BUTTONS_DIR
                 . ' && sudo chown www-data:www-data ' . BUTTONS_DIR;
        }
    }
    if (file_put_contents(BUTTONS_FILE, json_encode($buttons, JSON_PRETTY_PRINT)) === false) {
        return 'Cannot write ' . BUTTONS_FILE
             . ' — fix with: sudo chown -R www-data:www-data ' . BUTTONS_DIR;
    }
    return '';
}

function validate_button_id($id): bool {
    return is_numeric($id) && (int)$id >= 0;
}

function sanitize_button(array $post): array {
    static $styles = ['btn-default', 'btn-primary', 'btn-success', 'btn-info', 'btn-warning', 'btn-danger'];
    static $sizes  = ['btn-xs', 'btn-sm', 'btn-md', 'btn-lg'];
    return [
        'button_title'   => substr(trim($post['button_title']   ?? ''), 0, 100),
        'button_command' => trim($post['button_command'] ?? ''),
        'button_icon'    => preg_replace('/[^a-z0-9\-]/', '', strtolower($post['button_icon'] ?? '')),
        'button_style'   => in_array($post['button_style'] ?? '', $styles, true) ? $post['button_style'] : 'btn-default',
        'button_size'    => in_array($post['button_size']  ?? '', $sizes,  true) ? $post['button_size']  : 'btn-md',
        'button_direct'  => !empty($post['button_direct']) ? 1 : 0,
    ];
}

// ── Dispatch ──────────────────────────────────────────────────────────────────
$action = trim((string)($_REQUEST['action'] ?? ''));
$out    = err('Unknown action');

switch ($action) {

    // ── Buttons: create / edit ────────────────────────────────────────────────
    case 'submit_button':
        $buttons = load_buttons();
        if ($buttons === null) {
            $out = err('Could not read buttons file');
            break;
        }

        $data = sanitize_button($_POST);

        if ($data['button_title'] === '' || $data['button_command'] === '') {
            $out = err('Button title and command are required');
            break;
        }

        $btn_id = $_POST['button_id'] ?? '';
        if ($btn_id !== '' && validate_button_id($btn_id)) {
            // Preserve existing hash on edit
            $existing_hash = $buttons[(int)$btn_id]['button_hash'] ?? bin2hex(random_bytes(16));
            $data['button_hash'] = $existing_hash;
            $buttons[(int)$btn_id] = $data;
            $msg = 'Button updated';
        } else {
            $data['button_hash'] = bin2hex(random_bytes(16));
            $buttons[] = $data;
            $msg = 'Button created';
        }

        $save_err = save_buttons($buttons);
        $out = $save_err === '' ? ok($msg) : err($save_err);
        break;

    // ── Buttons: read for edit dialog ─────────────────────────────────────────
    case 'edit_button':
        if (!isset($_REQUEST['button_id']) || !validate_button_id($_REQUEST['button_id'])) {
            $out = err('Invalid button ID');
            break;
        }
        $buttons = load_buttons();
        $idx     = (int)$_REQUEST['button_id'];
        if ($buttons === null || !isset($buttons[$idx])) {
            $out = err('Button not found');
            break;
        }
        // Backfill hash for buttons created before the API feature was added
        if (empty($buttons[$idx]['button_hash'])) {
            $buttons[$idx]['button_hash'] = bin2hex(random_bytes(16));
            save_buttons($buttons);
        }
        $out = $buttons[$idx]; // return raw button data (not a type/message envelope)
        break;

    // ── Buttons: regenerate API hash ─────────────────────────────────────────
    case 'regenerate_button_hash':
        if (!isset($_POST['button_id']) || !validate_button_id($_POST['button_id'])) {
            $out = err('Invalid button ID');
            break;
        }
        $buttons = load_buttons();
        $idx = (int)$_POST['button_id'];
        if ($buttons === null || !isset($buttons[$idx])) {
            $out = err('Button not found');
            break;
        }
        $new_hash = bin2hex(random_bytes(16));
        $buttons[$idx]['button_hash'] = $new_hash;
        $save_err = save_buttons($buttons);
        $out = $save_err === '' ? ok('Hash regenerated', ['button_hash' => $new_hash]) : err($save_err);
        break;

    // ── Buttons: execute ──────────────────────────────────────────────────────
    case 'execute_button':
        if (!isset($_POST['button_id']) || !validate_button_id($_POST['button_id'])) {
            $out = err('Invalid button ID');
            break;
        }
        $buttons = load_buttons();
        $idx     = (int)$_POST['button_id'];
        if ($buttons === null || !isset($buttons[$idx])) {
            $out = err('Button not found');
            break;
        }
        $cmd = trim($buttons[$idx]['button_command'] ?? '');
        if ($cmd === '') {
            $out = err('Button has no command configured');
            break;
        }
        $result = ssh_run($cmd);
        $out = $result['success']
            ? ok('Command executed', ['output' => $result['output']])
            : err($result['error']);
        break;

    // ── Buttons: delete ───────────────────────────────────────────────────────
    case 'delete_button':
        if (!isset($_POST['button_id']) || !validate_button_id($_POST['button_id'])) {
            $out = err('Invalid button ID');
            break;
        }
        $buttons = load_buttons();
        if ($buttons === null) {
            $out = err('Could not read buttons file');
            break;
        }
        $idx = (int)$_POST['button_id'];
        if (!isset($buttons[$idx])) {
            $out = err('Button not found');
            break;
        }
        unset($buttons[$idx]);
        $save_err = save_buttons(array_values($buttons));
        $out = $save_err === '' ? ok('Button deleted') : err($save_err);
        break;

    // ── Buttons: reorder ─────────────────────────────────────────────────────
    case 'reorder_buttons':
        $order = $_POST['order'] ?? [];
        if (!is_array($order)) {
            $out = err('Invalid order');
            break;
        }
        $buttons = load_buttons();
        if ($buttons === null) {
            $out = err('Could not read buttons file');
            break;
        }
        $reordered = [];
        foreach ($order as $raw_idx) {
            $idx = (int)$raw_idx;
            if (isset($buttons[$idx])) {
                $reordered[] = $buttons[$idx];
            }
        }
        // Append any buttons not included in the order (safety)
        foreach ($buttons as $i => $b) {
            if (!in_array((string)$i, array_map('strval', $order), true)) {
                $reordered[] = $b;
            }
        }
        $save_err = save_buttons($reordered);
        $out = $save_err === '' ? ok('Buttons reordered') : err($save_err);
        break;

    // ── GPIO: change pin mode ─────────────────────────────────────────────────
    case 'change_mode':
        $bcm  = filter_var($_POST['bcm']  ?? '', FILTER_VALIDATE_INT);
        $mode = preg_replace('/[^a-z]/', '', strtolower((string)($_POST['mode'] ?? '')));

        if ($bcm === false || !in_array($mode, ['in', 'out', 'pwm', 'clock', 'up', 'down', 'tri'], true)) {
            $out = err('Invalid BCM pin number or mode');
            break;
        }
        $cmd    = sprintf('gpio -g mode %d %s', $bcm, $mode);
        $result = ssh_run($cmd, false);
        $out = $result['success']
            ? ok(sprintf('gpio -g mode %d %s executed', $bcm, $mode))
            : err($result['error']);
        break;

    // ── GPIO: write pin value ─────────────────────────────────────────────────
    case 'change_v':
        $bcm = filter_var($_POST['bcm'] ?? '', FILTER_VALIDATE_INT);
        $v   = filter_var($_POST['v']   ?? '', FILTER_VALIDATE_INT);

        if ($bcm === false || $v === false || !in_array($v, [0, 1], true)) {
            $out = err('Invalid BCM pin number or value (must be 0 or 1)');
            break;
        }
        $cmd    = sprintf('gpio -g write %d %d', $bcm, $v);
        $result = ssh_run($cmd, false);
        $out = $result['success']
            ? ok(sprintf('gpio -g write %d %d executed', $bcm, $v))
            : err($result['error']);
        break;

    // ── Logs: delete a background command log ─────────────────────────────────
    // The log files are local to the server — no SSH needed, just unlink().
    case 'delete_log':
        $file = basename(trim((string)($_POST['log_file'] ?? '')));
        if ($file === '' || $file[0] === '.' || substr($file, -4) !== '.log') {
            $out = err('Invalid filename');
            break;
        }
        $path = __DIR__ . '/command_logs/' . $file;
        if (!is_file($path)) {
            $out = err('File not found');
            break;
        }
        $out = unlink($path)
            ? ok('Log deleted')
            : err('Could not delete file — check directory permissions');
        break;

    // ── Dashboard: live system stats ──────────────────────────────────────────
    case 'server_info':
        $out = collect_server_info();
        break;

    // ── Services: list all init.d services and their status ──────────────────
    case 'services':
        $raw = @shell_exec('/usr/sbin/service --status-all 2>&1');
        if ($raw === null || trim($raw) === '') {
            $out = err('service --status-all returned no output — ensure /usr/sbin/service is available');
            break;
        }
        $active = $inactive = $unknown = [];
        foreach (preg_split('/\r\n|\r|\n/', $raw) as $line) {
            if (strpos($line, '[ + ]') !== false) {
                $name = trim(str_replace('[ + ]', '', $line));
                if ($name !== '') $active[] = $name;
            } elseif (strpos($line, '[ - ]') !== false) {
                $name = trim(str_replace('[ - ]', '', $line));
                if ($name !== '') $inactive[] = $name;
            } elseif (strpos($line, '[ ? ]') !== false) {
                $name = trim(str_replace('[ ? ]', '', $line));
                if ($name !== '') $unknown[] = $name;
            }
        }
        $out = ok('ok', ['active' => $active, 'inactive' => $inactive, 'unknown' => $unknown]);
        break;

    // ── System check: re-run all diagnostics, return JSON ─────────────────────
    case 'system_check':
        $gumcp      = rtrim(__DIR__, '/');
        $php_major  = (int)PHP_MAJOR_VERSION;
        $php_minor  = (int)PHP_MINOR_VERSION;
        $btns_dir   = $gumcp . '/buttons';
        $logs_dir   = $gumcp . '/command_logs';

        $checks = [
            'php_version'      => $php_major > 7 || ($php_major === 7 && $php_minor >= 0),
            'ext_ssh2'         => extension_loaded('ssh2'),
            'ext_json'         => extension_loaded('json'),
            'ext_sqlite3'      => extension_loaded('sqlite3'),
            'ext_curl'         => extension_loaded('curl'),
            'buttons_exists'   => is_dir($btns_dir),
            'buttons_writable' => is_dir($btns_dir) && is_writable($btns_dir),
            'buttons_htaccess' => file_exists($btns_dir . '/.htaccess'),
            'logs_exists'      => is_dir($logs_dir),
            'logs_writable'    => is_dir($logs_dir) && is_writable($logs_dir),
            'logs_htaccess'    => file_exists($logs_dir . '/.htaccess'),
            'config_readable'  => is_readable($gumcp . '/include/config.php'),
            'defaults_exists'  => file_exists($gumcp . '/include/config.defaults.php'),
        ];

        // Pi model for GPIO context
        $model = trim((string)@file_get_contents('/proc/device-tree/model'));
        $is_pi5 = stripos($model, 'Raspberry Pi 5') !== false;

        $gpio_ok = false;
        $gpio_detail = '';
        if ($is_pi5) {
            $gpio_ok     = !empty(shell_exec('command -v raspi-gpio 2>/dev/null'));
            $gpio_detail = $gpio_ok ? 'raspi-gpio installed' : 'raspi-gpio missing';
        } else {
            $gpio_ok     = !empty(shell_exec('command -v gpio 2>/dev/null'));
            $gpio_detail = $gpio_ok ? 'gpio (WiringPi) installed' : 'gpio (WiringPi) missing';
        }
        $checks['gpio'] = $gpio_ok;

        $all_pass = !in_array(false, $checks, true);
        $out = ok($all_pass ? 'All checks passed' : 'Some checks failed', [
            'checks'     => $checks,
            'php_version'=> PHP_VERSION,
            'model'      => $model,
            'gpio_detail'=> $gpio_detail,
            'all_pass'   => $all_pass,
        ]);
        break;

    // ── System fix: run a whitelisted repair command via SSH ──────────────────
    case 'system_fix':
        $fix   = (string)($_POST['fix'] ?? '');
        $gumcp = rtrim(__DIR__, '/');
        $btns  = $gumcp . '/buttons';
        $logs  = $gumcp . '/command_logs';

        // All fix commands are pre-defined here — no user-supplied shell strings.
        $allowed = [
            'buttons_dir'        => 'sudo mkdir -p ' . escapeshellarg($btns)
                                  . ' && sudo chown www-data:www-data ' . escapeshellarg($btns)
                                  . ' && sudo chmod 755 ' . escapeshellarg($btns),
            'logs_dir'           => 'sudo mkdir -p ' . escapeshellarg($logs)
                                  . ' && sudo chown www-data:www-data ' . escapeshellarg($logs)
                                  . ' && sudo chmod 755 ' . escapeshellarg($logs),
            'gumcp_chown'        => 'sudo chown -R www-data:www-data ' . escapeshellarg($gumcp),
            'install_ssh2'       => 'sudo apt-get install -y php-ssh2 && sudo systemctl restart apache2',
            'install_sqlite3'    => 'sudo apt-get install -y php-sqlite3 && sudo systemctl restart apache2',
            'install_curl'       => 'sudo apt-get install -y php-curl && sudo systemctl restart apache2',
            'install_raspi_gpio' => 'sudo apt-get install -y raspi-gpio',
            'start_ssh'          => 'sudo systemctl enable ssh && sudo systemctl start ssh',
            'start_apache'       => 'sudo systemctl enable apache2 && sudo systemctl start apache2',
        ];

        if (!array_key_exists($fix, $allowed)) {
            $out = err('Unknown fix key: ' . htmlspecialchars($fix, ENT_QUOTES, 'UTF-8'));
            break;
        }
        $result = ssh_run($allowed[$fix]);
        $out = $result['success']
            ? ok('Fix applied', ['output' => $result['output'], 'fix' => $fix])
            : err($result['error']);
        break;

    case 'save_menu_order':
        $order = $_POST['order'] ?? [];
        if (!is_array($order)) {
            $out = err('Invalid order');
            break;
        }
        $order = array_values(array_map('strval', $order));
        $file  = __DIR__ . '/include/menu_order.json';
        if (file_put_contents($file, json_encode($order)) === false) {
            $out = err('Could not write menu_order.json');
        } else {
            $out = ok('Menu order saved');
        }
        break;
}

echo json_encode($out);

// ── server_info data collection ───────────────────────────────────────────────
// Extracted into a function to keep the switch readable.
function collect_server_info(): array {
    $info = [];

    // Temperature
    $raw = @file_get_contents('/sys/class/thermal/thermal_zone0/temp');
    $info['temp'] = $raw !== false ? round((float)$raw / 1000, 1) : 0.0;

    // CPU usage — two /proc/stat reads 100 ms apart (no vmstat/awk needed)
    $info['cpuusage'] = read_cpu_usage();

    // Disk (root filesystem)
    $free_b  = (float)(@disk_free_space('/')  ?: 0);
    $total_b = (float)(@disk_total_space('/') ?: 0);
    $used_b  = $total_b - $free_b;
    $info['disk_free']       = format_bytes($free_b);
    $info['disk_total']      = format_bytes($total_b);
    $info['disk_used']       = format_bytes($used_b);
    $info['disk_percentage'] = $total_b > 0 ? (int)round($used_b / $total_b * 100) : 0;

    // Uptime (from /proc/uptime — avoids -p flag missing on older BusyBox)
    $info['uptime'] = read_uptime();

    // Load averages
    $load = function_exists('sys_getloadavg') ? (sys_getloadavg() ?: [0, 0, 0]) : [0, 0, 0];
    $info['load']  = $load;
    $info['load0'] = round($load[0], 2);
    $info['load1'] = round($load[1], 2);
    $info['load2'] = round($load[2], 2);

    // Process count
    $wc = @shell_exec('ps ax | wc -l');
    $info['processes'] = $wc ? max(0, (int)trim($wc) - 1) : 0;

    // Top processes sorted by memory (sort(1) works on BusyBox; --sort is GNU-only)
    $info['top']   = (string)(@shell_exec('ps aux | sort -rk 4,4 | head -n 11') ?: '');
    $info['users'] = (string)(@shell_exec('who') ?: '');
    $info['disks'] = (string)(@shell_exec('df -h') ?: '');
    $info['usb']   = (string)(@shell_exec('lsusb 2>/dev/null') ?: '');
    $info['date']  = date('Y-m-d H:i:s');

    // Memory (from /proc/meminfo — works on all Pi models and Pi OS versions)
    $mem = read_meminfo();
    $used = $mem['total'] - $mem['available'];
    $info['memory_total']      = $mem['total'];
    $info['memory_used']       = $used;
    $info['memory_free']       = $mem['available'];
    $info['memory_shared']     = $mem['shared'];
    $info['memory_buffers']    = $mem['buffers'];
    $info['memory_cached']     = $mem['cached'];
    $info['memory_percentage'] = $mem['total'] > 0
        ? (int)round($used / $mem['total'] * 100)
        : 0;

    // Swap
    $swap = gumcp_swap_info();
    $info['swap_total']      = $swap['total'];
    $info['swap_used']       = $swap['used'];
    $info['swap_free']       = $swap['free'];
    $info['swap_percentage'] = $swap['percent'];

    // Network interfaces
    $info['network'] = gumcp_network_info();

    // Throttling / under-voltage (Raspberry Pi)
    $info['throttled'] = gumcp_throttled_info();

    // Service status badges
    global $gumcp_dashboard_services;
    $info['services_status'] = gumcp_service_status(
        is_array($gumcp_dashboard_services ?? null) ? $gumcp_dashboard_services : []
    );

    return $info;
}

function read_cpu_usage(): int {
    // Persist the previous /proc/stat snapshot between AJAX polls so the delta
    // is measured over the full ~30 s polling interval instead of a tiny window.
    // This prevents the "always 0%" problem on lightly-loaded Pis where no
    // non-idle jiffies tick during a short in-process usleep sample.
    $cache = sys_get_temp_dir() . '/gumcp_cpu_stat';

    $parse = static function(string $raw): array {
        return explode(' ', preg_replace('/\s+/', ' ', trim(explode("\n", $raw)[0])));
    };

    $current = @file_get_contents('/proc/stat');
    if ($current === false) return 0;

    $b    = $parse($current);
    $prev = @file_get_contents($cache);

    // Save current snapshot for the next call before any early return.
    @file_put_contents($cache, $current, LOCK_EX);

    if ($prev === false || $prev === '') {
        // No baseline yet — fall back to a 300 ms in-process sample.
        usleep(300000);
        $s2 = @file_get_contents('/proc/stat');
        if ($s2 === false) return 0;
        $b = $parse($s2);
        @file_put_contents($cache, $s2, LOCK_EX);
        $a = $parse($current);
    } else {
        $a = $parse($prev);
    }

    $idle  = (int)$b[4] - (int)$a[4];
    $total = 0;
    for ($i = 1; $i <= 8; $i++) {
        $total += ((int)($b[$i] ?? 0)) - ((int)($a[$i] ?? 0));
    }
    return $total > 0 ? (int)round(100 - ($idle * 100 / $total)) : 0;
}

function read_uptime(): string {
    $raw = @file_get_contents('/proc/uptime');
    if ($raw === false) return 'Unknown';

    $sec  = (int)explode(' ', $raw)[0];
    $d    = (int)floor($sec / 86400);
    $h    = (int)floor(($sec % 86400) / 3600);
    $m    = (int)floor(($sec % 3600) / 60);
    return sprintf('up %d day%s, %d hour%s, %d minute%s',
        $d, $d !== 1 ? 's' : '',
        $h, $h !== 1 ? 's' : '',
        $m, $m !== 1 ? 's' : '');
}

function read_meminfo(): array {
    $defaults = ['total' => 0, 'free' => 0, 'available' => 0, 'buffers' => 0, 'cached' => 0, 'shared' => 0];
    $raw = @file_get_contents('/proc/meminfo');
    if ($raw === false) return $defaults;

    $get = static function(string $key) use ($raw): int {
        return preg_match('/^' . $key . ':\s+(\d+)/m', $raw, $m) ? (int)$m[1] : 0;
    };
    $total = $get('MemTotal');
    $free  = $get('MemFree');
    return [
        'total'     => $total,
        'free'      => $free,
        'available' => $get('MemAvailable') ?: $free,
        'buffers'   => $get('Buffers'),
        'cached'    => $get('Cached'),
        'shared'    => $get('Shmem'),
    ];
}

function format_bytes(float $bytes): string {
    $units = ['B', 'KB', 'MB', 'GB', 'TB', 'EB'];
    $i = $bytes > 0 ? min((int)log($bytes, 1024), count($units) - 1) : 0;
    return sprintf('%1.2f %s', $bytes / pow(1024, $i), $units[$i]);
}
