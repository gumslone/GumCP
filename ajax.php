<?php
declare(strict_types=1);

// Send JSON header first so every response — including early errors — is typed.
header('Content-Type: application/json');

require_once('./include/config.php');

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
// Connects, authenticates, runs $cmd, captures stdout+stderr, disconnects.
// Returns ['success'=>true,'output'=>string] or ['success'=>false,'error'=>string].
function ssh_run(string $cmd, bool $capture = true): array {
    if (!function_exists('ssh2_connect')) {
        return ['success' => false, 'error' => 'php-ssh2 extension is not installed'];
    }

    $conn = null;
    try {
        $conn = @ssh2_connect('localhost', (int)SSH_PORT);
        if ($conn === false) {
            throw new Exception('Could not connect to SSH on port ' . SSH_PORT);
        }
        if (!@ssh2_auth_password($conn, SSH_USER, SSH_PASS)) {
            throw new Exception('SSH authentication failed — check SSH_USER / SSH_PASS in config.php');
        }

        $stream = ssh2_exec($conn, $cmd);
        if ($stream === false) {
            throw new Exception('ssh2_exec failed');
        }

        $output = '';
        if ($capture) {
            stream_set_blocking($stream, true);
            $stdout = ssh2_fetch_stream($stream, SSH2_STREAM_STDIO);
            $stderr = ssh2_fetch_stream($stream, SSH2_STREAM_STDERR);
            $out_s  = (string)stream_get_contents($stdout);
            $err_s  = (string)stream_get_contents($stderr);
            fclose($stdout);
            fclose($stderr);
            $output = trim($out_s . ($err_s !== '' ? "\n[stderr]\n" . $err_s : ''));
        }

        @ssh2_exec($conn, 'exit');
        return ['success' => true, 'output' => $output];

    } catch (Exception $e) {
        return ['success' => false, 'error' => $e->getMessage()];
    } finally {
        unset($conn);
    }
}

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

function save_buttons(array $buttons): bool {
    if (!is_dir(BUTTONS_DIR)) {
        mkdir(BUTTONS_DIR, 0755, true);
    }
    return file_put_contents(BUTTONS_FILE, json_encode($buttons, JSON_PRETTY_PRINT)) !== false;
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
            $buttons[(int)$btn_id] = $data;
            $msg = 'Button updated';
        } else {
            $buttons[] = $data;
            $msg = 'Button created';
        }

        $out = save_buttons($buttons)
            ? ok($msg)
            : err('Failed to save button — check that the buttons directory is writable');
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
        $out = $buttons[$idx]; // return raw button data (not a type/message envelope)
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
        $out = save_buttons(array_values($buttons))
            ? ok('Button deleted')
            : err('Failed to save buttons file');
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
        if ($file === '' || $file === '..' || $file === '.') {
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

    return $info;
}

function read_cpu_usage(): int {
    $s1 = @file_get_contents('/proc/stat');
    if ($s1 === false) return 0;
    usleep(100000); // 100 ms sample window
    $s2 = @file_get_contents('/proc/stat');
    if ($s2 === false) return 0;

    $parse = static function(string $raw): array {
        return explode(' ', preg_replace('/\s+/', ' ', trim(explode("\n", $raw)[0])));
    };
    $a = $parse($s1);
    $b = $parse($s2);

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
