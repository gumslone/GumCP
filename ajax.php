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

    // ── Docker: list containers ───────────────────────────────────────────────
    case 'docker_ps':
        $fmt = '{{.ID}}\t{{.Names}}\t{{.Image}}\t{{.State}}\t{{.Status}}\t{{.Ports}}';
        $r = ssh_run('sudo docker ps -a --format ' . escapeshellarg($fmt) . ' 2>&1');
        if (!$r['success']) { $out = err($r['error']); break; }
        $output = (string)$r['output'];
        if (preg_match('/command not found|not installed/i', $output)) {
            $out = ok('ok', ['available' => false, 'reason' => 'Docker is not installed.', 'containers' => []]);
            break;
        }
        if (stripos($output, 'Cannot connect to the Docker daemon') !== false) {
            $out = ok('ok', ['available' => false, 'reason' => 'Docker daemon is not running.', 'containers' => []]);
            break;
        }
        $containers = [];
        foreach (preg_split('/\r\n|\r|\n/', trim($output)) as $line) {
            if ($line === '') continue;
            $f = explode("\t", $line);
            if (count($f) < 5) continue;
            $containers[] = [
                'id'     => $f[0],
                'name'   => $f[1],
                'image'  => $f[2],
                'state'  => $f[3],
                'status' => $f[4],
                'ports'  => isset($f[5]) ? $f[5] : '',
            ];
        }
        $out = ok('ok', ['available' => true, 'containers' => $containers]);
        break;

    // ── Docker: container action (start/stop/restart/pause/remove) ────────────
    case 'docker_action':
        $id  = trim((string)($_POST['id'] ?? ''));
        $act = (string)($_POST['act'] ?? '');
        if (!preg_match('/^[a-zA-Z0-9_.-]+$/', $id)) { $out = err('Invalid container id'); break; }
        $map = [
            'start'   => 'start',
            'stop'    => 'stop',
            'restart' => 'restart',
            'pause'   => 'pause',
            'unpause' => 'unpause',
            'remove'  => 'rm -f',
        ];
        if (!isset($map[$act])) { $out = err('Unknown action'); break; }
        $r = ssh_run('sudo docker ' . $map[$act] . ' ' . escapeshellarg($id) . ' 2>&1');
        $out = $r['success'] ? ok(ucfirst($act) . ' done', ['output' => $r['output']]) : err($r['error']);
        break;

    // ── Docker: container logs ────────────────────────────────────────────────
    case 'docker_logs':
        $id    = trim((string)($_POST['id'] ?? ''));
        $lines = (int)($_POST['lines'] ?? 200);
        if (!preg_match('/^[a-zA-Z0-9_.-]+$/', $id)) { $out = err('Invalid container id'); break; }
        if ($lines < 10)   $lines = 10;
        if ($lines > 2000) $lines = 2000;
        $r = ssh_run('sudo docker logs --tail ' . $lines . ' ' . escapeshellarg($id) . ' 2>&1');
        $out = $r['success'] ? ok('ok', ['output' => $r['output']]) : err($r['error']);
        break;

    // ── Docker: list images ───────────────────────────────────────────────────
    case 'docker_images':
        $fmt = '{{.Repository}}\t{{.Tag}}\t{{.ID}}\t{{.Size}}';
        $r = ssh_run('sudo docker images --format ' . escapeshellarg($fmt) . ' 2>&1');
        $images = [];
        if ($r['success']) {
            foreach (preg_split('/\r\n|\r|\n/', trim((string)$r['output'])) as $line) {
                if ($line === '') continue;
                $f = explode("\t", $line);
                if (count($f) < 4) continue;
                $images[] = ['repo' => $f[0], 'tag' => $f[1], 'id' => $f[2], 'size' => $f[3]];
            }
        }
        $out = ok('ok', ['images' => $images]);
        break;

    // ── Update: fetch tags from origin and return the full release list ───────
    case 'git_tags':
        $dir = escapeshellarg(__DIR__);
        // Fetch tags from the remote (needs network; via SSH for repo perms).
        $fetch = ssh_run('sudo git -C ' . $dir . ' fetch --tags --prune origin 2>&1');
        $raw   = (string)(@shell_exec('git -C ' . $dir . ' tag --sort=-v:refname 2>/dev/null') ?: '');
        $tags  = array_values(array_filter(array_map('trim', explode("\n", trim($raw)))));
        $out = ok('ok', [
            'tags'  => $tags,
            'error' => $fetch['success'] ? '' : (string)($fetch['error'] ?? 'fetch failed'),
        ]);
        break;

    // ── Packages: list upgradable (read-only, no sudo) ────────────────────────
    case 'pkg_list':
        $raw = (string)(@shell_exec('apt list --upgradable 2>/dev/null') ?: '');
        $pkgs = [];
        foreach (preg_split('/\r\n|\r|\n/', $raw) as $line) {
            // name/suite newver arch [upgradable from: oldver]
            if (preg_match('#^(\S+?)/\S+\s+(\S+)\s+\S+\s+\[upgradable from:\s+([^\]]+)\]#', trim($line), $m)) {
                $pkgs[] = ['name' => $m[1], 'new' => $m[2], 'current' => trim($m[3])];
            }
        }
        // When the apt package index was last refreshed (most recent of the
        // success stamp or the lists directory). Lets the UI flag a stale cache.
        $stamp = 0;
        foreach (['/var/lib/apt/periodic/update-success-stamp', '/var/lib/apt/lists'] as $p) {
            $t = @filemtime($p);
            if ($t !== false && $t > $stamp) $stamp = $t;
        }
        $out = ok('ok', [
            'packages'    => $pkgs,
            'count'       => count($pkgs),
            'index_mtime' => $stamp, // unix time, 0 if unknown
        ]);
        break;

    // ── Packages: refresh apt index (sudo via SSH) ────────────────────────────
    case 'pkg_check':
        $r = ssh_run('sudo apt-get update 2>&1');
        if (!$r['success']) {
            $out = err($r['error']);
            break;
        }
        // ssh_run only reports the SSH call status; inspect apt's own output for
        // repository errors (e.g. EOL release, 404, unreachable mirror).
        $apt_out = (string)$r['output'];
        if (preg_match('/^(E:|Err:|W:|N: Updating from such)/m', $apt_out)) {
            $out = err('apt reported repository problems — your sources may be unreachable or end-of-life.');
            $out['output'] = $apt_out;
        } else {
            $out = ok('Package index refreshed', ['output' => $apt_out]);
        }
        break;

    // ── Packages: upgrade all (sudo via SSH) ──────────────────────────────────
    case 'pkg_upgrade':
        $r = ssh_run('sudo DEBIAN_FRONTEND=noninteractive apt-get -y upgrade 2>&1');
        $out = $r['success'] ? ok('Upgrade finished', ['output' => $r['output']]) : err($r['error']);
        break;

    // ── Logs: view journalctl or a /var/log file (via SSH) ────────────────────
    case 'log_view':
        $source = (string)($_POST['source'] ?? 'journal');
        $lines  = (int)($_POST['lines'] ?? 200);
        if ($lines < 10)   $lines = 10;
        if ($lines > 5000) $lines = 5000;
        $filter = trim((string)($_POST['filter'] ?? ''));

        if ($source === 'journal') {
            $cmd = 'sudo journalctl -n ' . $lines . ' --no-pager 2>&1';
        } elseif ($source === 'dmesg') {
            $cmd = 'sudo dmesg 2>&1 | tail -n ' . $lines;
        } else {
            // Must be a plain file under /var/log
            if (strpos($source, '..') !== false || strpos($source, '/var/log/') !== 0
                || !preg_match('#^/var/log/[a-zA-Z0-9._/-]+$#', $source)) {
                $out = err('Invalid log source');
                break;
            }
            $cmd = 'sudo tail -n ' . $lines . ' ' . escapeshellarg($source) . ' 2>&1';
        }
        if ($filter !== '') {
            $cmd .= ' | grep -F -- ' . escapeshellarg($filter);
        }
        $r = ssh_run($cmd);
        $out = $r['success'] ? ok('ok', ['output' => $r['output']]) : err($r['error']);
        break;

    // ── Cron: list user crontab + /etc/crontab (via SSH) ──────────────────────
    case 'cron_list':
        $r1 = ssh_run('crontab -l 2>/dev/null');
        $r2 = ssh_run('cat /etc/crontab 2>/dev/null');
        $out = ok('ok', [
            'user'   => $r1['success'] ? $r1['output'] : '',
            'system' => $r2['success'] ? $r2['output'] : '',
        ]);
        break;

    // ── Cron: add a line to the user crontab (via SSH) ────────────────────────
    case 'cron_add':
        $schedule = trim((string)($_POST['schedule'] ?? ''));
        $command  = trim((string)($_POST['command'] ?? ''));
        if (!cron_validate_schedule($schedule)) {
            $out = err('Invalid cron schedule expression');
            break;
        }
        if ($command === '') {
            $out = err('Command cannot be empty');
            break;
        }
        $line = $schedule . ' ' . $command;
        // Append safely: keep existing crontab, add the new line.
        $b64 = base64_encode($line);
        $cmd = '( crontab -l 2>/dev/null; echo ' . escapeshellarg($b64) . ' | base64 -d ) | crontab -';
        $r = ssh_run($cmd . ' 2>&1');
        $out = $r['success'] ? ok('Cron job added') : err($r['error']);
        break;

    // ── Cron: delete the Nth line of the user crontab (via SSH) ───────────────
    case 'cron_delete':
        $index = (int)($_POST['index'] ?? -1);
        if ($index < 0) { $out = err('Invalid index'); break; }
        $cur = ssh_run('crontab -l 2>/dev/null');
        if (!$cur['success']) { $out = err($cur['error']); break; }
        $lines = preg_split('/\r\n|\r|\n/', $cur['output']);
        if (!isset($lines[$index])) { $out = err('Line not found'); break; }
        unset($lines[$index]);
        $new = implode("\n", $lines);
        $b64 = base64_encode($new === '' ? '' : $new . "\n");
        $cmd = 'echo ' . escapeshellarg($b64) . ' | base64 -d | crontab -';
        $r = ssh_run($cmd . ' 2>&1');
        $out = $r['success'] ? ok('Cron job removed') : err($r['error']);
        break;

    // ── Raspberry Pi: vcgencmd metrics ────────────────────────────────────────
    case 'rpi_metrics':
        $bin = gumcp_vcgencmd_path();
        if ($bin === '') { $out = err('vcgencmd not available'); break; }
        $vc = function(string $args) use ($bin) {
            return trim((string)(@shell_exec(escapeshellarg($bin) . ' ' . $args . ' 2>/dev/null') ?: ''));
        };
        $clock = function(string $c) use ($vc) {
            $r = $vc('measure_clock ' . $c);
            return preg_match('/=(\d+)/', $r, $m) ? round((int)$m[1] / 1000000, 0) . ' MHz' : '—';
        };
        $volt = function(string $c) use ($vc) {
            $r = $vc('measure_volts ' . $c);
            return preg_match('/=([\d.]+)V/', $r, $m) ? $m[1] . ' V' : '—';
        };
        $mem = function(string $c) use ($vc) {
            $r = $vc('get_mem ' . $c);
            return preg_match('/=(\S+)/', $r, $m) ? $m[1] : '—';
        };
        $codecs = [];
        foreach (['H264', 'H265', 'MPG2', 'WVC1'] as $codec) {
            $r = $vc('codec_enabled ' . $codec);
            $codecs[$codec] = (stripos($r, 'enabled') !== false) ? 'enabled' : 'disabled';
        }
        $out = ok('ok', [
            'firmware'  => $vc('version'),
            'arm_clock' => $clock('arm'),
            'core_clock'=> $clock('core'),
            'v3d_clock' => $clock('v3d'),
            'core_volt' => $volt('core'),
            'sdram_volt'=> $volt('sdram_c'),
            'mem_arm'   => $mem('arm'),
            'mem_gpu'   => $mem('gpu'),
            'codecs'    => $codecs,
        ]);
        break;

    // ── Raspberry Pi: current interface states via raspi-config ───────────────
    case 'rpi_iface_status':
        $ifaces = ['i2c', 'spi', 'onewire', 'ssh', 'vnc', 'camera'];
        $states = [];
        foreach ($ifaces as $i) {
            $r = ssh_run('sudo raspi-config nonint get_' . $i . ' 2>/dev/null');
            // get_X returns 0 = enabled, 1 = disabled
            $v = $r['success'] ? trim($r['output']) : '';
            $states[$i] = $v === '0' ? 'enabled' : ($v === '1' ? 'disabled' : 'unknown');
        }
        $out = ok('ok', ['states' => $states]);
        break;

    // ── Raspberry Pi: toggle an interface via raspi-config (sudo via SSH) ──────
    case 'rpi_interface':
        $iface = (string)($_POST['iface'] ?? '');
        $enable = ((int)($_POST['enable'] ?? 0)) === 1;
        $allowed = ['i2c', 'spi', 'onewire', 'ssh', 'vnc', 'camera'];
        if (!in_array($iface, $allowed, true)) { $out = err('Unknown interface'); break; }
        // raspi-config nonint do_X: 0 = enable, 1 = disable
        $arg = $enable ? '0' : '1';
        $r = ssh_run('sudo raspi-config nonint do_' . $iface . ' ' . $arg . ' 2>&1');
        $out = $r['success'] ? ok(($enable ? 'Enabled ' : 'Disabled ') . strtoupper($iface)) : err($r['error']);
        break;

    // ── Raspberry Pi: read boot config files (via SSH) ────────────────────────
    case 'boot_config_read':
        $which = (string)($_POST['file'] ?? 'config');
        $path  = boot_config_path($which);
        if ($path === '') { $out = err('Unknown file'); break; }
        $r = ssh_run('sudo cat ' . escapeshellarg($path) . ' 2>&1');
        $out = $r['success'] ? ok('ok', ['content' => $r['output'], 'path' => $path]) : err($r['error']);
        break;

    // ── Raspberry Pi: save a boot config file with backup (via SSH) ───────────
    case 'boot_config_save':
        $which   = (string)($_POST['file'] ?? 'config');
        $content = (string)($_POST['content'] ?? '');
        $path    = boot_config_path($which);
        if ($path === '') { $out = err('Unknown file'); break; }
        $b64 = base64_encode($content);
        $bak = $path . '.gumcp.bak';
        $cmd = 'sudo cp ' . escapeshellarg($path) . ' ' . escapeshellarg($bak)
             . ' && echo ' . escapeshellarg($b64) . ' | base64 -d | sudo tee ' . escapeshellarg($path) . ' >/dev/null';
        $r = ssh_run($cmd . ' 2>&1');
        $out = $r['success'] ? ok('Saved (backup: ' . $bak . ')') : err($r['error']);
        break;

    // ── Raspberry Pi: temp/clock history ring buffer ──────────────────────────
    case 'metrics_history':
        $out = ok('ok', ['history' => metrics_history_sample()]);
        break;
}

echo json_encode($out);

// ── Cron schedule validation ──────────────────────────────────────────────────
// Accepts an @keyword or five fields (min hour dom mon dow), each validated
// against its allowed range and supporting *, lists, ranges and /steps.
function cron_validate_schedule(string $s): bool {
    $s = trim($s);
    if ($s === '') return false;

    if ($s[0] === '@') {
        $keywords = ['@reboot', '@yearly', '@annually', '@monthly',
                     '@weekly', '@daily', '@midnight', '@hourly'];
        return in_array(strtolower($s), $keywords, true);
    }

    $parts = preg_split('/\s+/', $s);
    if (count($parts) !== 5) return false;

    $ranges = [[0, 59], [0, 23], [1, 31], [1, 12], [0, 7]];
    $names  = [
        3 => ['jan'=>1,'feb'=>2,'mar'=>3,'apr'=>4,'may'=>5,'jun'=>6,
              'jul'=>7,'aug'=>8,'sep'=>9,'oct'=>10,'nov'=>11,'dec'=>12],
        4 => ['sun'=>0,'mon'=>1,'tue'=>2,'wed'=>3,'thu'=>4,'fri'=>5,'sat'=>6],
    ];
    foreach ($parts as $i => $field) {
        if (!cron_field_valid($field, $ranges[$i][0], $ranges[$i][1], isset($names[$i]) ? $names[$i] : [])) {
            return false;
        }
    }
    return true;
}

function cron_field_valid(string $field, int $min, int $max, array $names): bool {
    if ($field === '') return false;
    foreach (explode(',', $field) as $item) {
        if ($item === '') return false;
        $range = $item;
        if (strpos($item, '/') !== false) {
            $bits = explode('/', $item, 2);
            $range = $bits[0];
            if (!preg_match('/^\d+$/', $bits[1]) || (int)$bits[1] < 1) return false;
        }
        if ($range === '*') continue;
        if (strpos($range, '-') !== false) {
            $ab = explode('-', $range, 2);
            $a = cron_token_value($ab[0], $min, $max, $names);
            $b = cron_token_value($ab[1], $min, $max, $names);
            if ($a === null || $b === null || $a > $b) return false;
        } else {
            if (cron_token_value($range, $min, $max, $names) === null) return false;
        }
    }
    return true;
}

function cron_token_value(string $t, int $min, int $max, array $names) {
    $t = strtolower($t);
    if (isset($names[$t])) {
        $v = $names[$t];
    } elseif (preg_match('/^\d+$/', $t)) {
        $v = (int)$t;
    } else {
        return null;
    }
    return ($v < $min || $v > $max) ? null : $v;
}

// ── Boot config path resolver ─────────────────────────────────────────────────
// Bookworm moved the boot partition to /boot/firmware; older OSes use /boot.
function boot_config_path(string $which): string {
    $name = $which === 'cmdline' ? 'cmdline.txt' : ($which === 'config' ? 'config.txt' : '');
    if ($name === '') return '';
    foreach (['/boot/firmware/', '/boot/'] as $dir) {
        if (@file_exists($dir . $name)) return $dir . $name;
    }
    // Default to the modern location even if not readable by the web user.
    return '/boot/firmware/' . $name;
}

// ── Temp/clock history ring buffer (sampled on each call) ─────────────────────
function metrics_history_sample(): array {
    $file = __DIR__ . '/command_logs/metrics_history.json';

    $temp = read_cpu_temp();

    $freq_raw = @file_get_contents('/sys/devices/system/cpu/cpu0/cpufreq/scaling_cur_freq');
    $freq = $freq_raw !== false ? (int)round((int)$freq_raw / 1000) : 0; // MHz

    $history = [];
    $existing = @file_get_contents($file);
    if ($existing !== false) {
        $decoded = json_decode($existing, true);
        if (is_array($decoded)) $history = $decoded;
    }

    $history[] = ['t' => time(), 'temp' => $temp, 'freq' => $freq];
    if (count($history) > 120) {
        $history = array_slice($history, -120);
    }
    @file_put_contents($file, json_encode($history), LOCK_EX);
    return $history;
}

// ── server_info data collection ───────────────────────────────────────────────
// Extracted into a function to keep the switch readable.
function collect_server_info(): array {
    $info = [];

    // Temperature and CPU usage (shared readers in include/dashboard.php)
    $info['temp']     = read_cpu_temp();
    $info['cpuusage'] = read_cpu_usage();

    // Disk (root filesystem)
    $free_b  = (float)(@disk_free_space('/')  ?: 0);
    $total_b = (float)(@disk_total_space('/') ?: 0);
    $used_b  = $total_b - $free_b;
    $info['disk_free']       = gumcp_fmt_bytes($free_b);
    $info['disk_total']      = gumcp_fmt_bytes($total_b);
    $info['disk_used']       = gumcp_fmt_bytes($used_b);
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
    $info['blk']   = (string)(@shell_exec('lsblk 2>/dev/null') ?: '');
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

// read_cpu_usage(), read_uptime(), read_meminfo(), read_cpu_temp() and
// gumcp_fmt_bytes() live in include/dashboard.php, shared with index.php.
