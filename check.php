<?php
declare(strict_types=1);

$active_page = '';
require_once('./include/init.php');

if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// ── Helpers ───────────────────────────────────────────────────────────────────

function chk(bool $ok, string $label, string $detail = '', string $fix_key = ''): array {
    return compact('ok', 'label', 'detail', 'fix_key');
}

function cmd_exists(string $cmd): bool {
    return !empty(shell_exec('command -v ' . escapeshellarg($cmd) . ' 2>/dev/null'));
}

// ── Checks ────────────────────────────────────────────────────────────────────

$gumcp_dir   = rtrim(__DIR__, '/');
$buttons_dir = $gumcp_dir . '/buttons';
$logs_dir    = $gumcp_dir . '/command_logs';
$config_file = $gumcp_dir . '/include/config.php';
$php_major   = (int)PHP_MAJOR_VERSION;
$php_minor   = (int)PHP_MINOR_VERSION;
$pi_model    = trim((string)@file_get_contents('/proc/device-tree/model'));
$is_pi5      = stripos($pi_model, 'Raspberry Pi 5') !== false;

$sections = [];

$sections['PHP'] = [
    chk(
        $php_major > 7 || ($php_major === 7 && $php_minor >= 0),
        'PHP version',
        'PHP ' . PHP_VERSION . ' (minimum 7.0 required)'
    ),
    chk(
        extension_loaded('ssh2'),
        'php-ssh2 extension',
        extension_loaded('ssh2') ? 'loaded' : 'missing — Actions and Buttons will not work',
        'install_ssh2'
    ),
    chk(
        extension_loaded('json'),
        'php-json extension',
        extension_loaded('json') ? 'loaded' : 'missing'
    ),
    chk(
        extension_loaded('sqlite3'),
        'php-sqlite3 extension',
        extension_loaded('sqlite3') ? 'loaded' : 'missing — TeHyBug module will not work',
        'install_sqlite3'
    ),
    chk(
        extension_loaded('curl'),
        'php-curl extension',
        extension_loaded('curl') ? 'loaded' : 'missing (optional)',
        'install_curl'
    ),
];

$sections['Directories'] = [
    chk(
        is_dir($buttons_dir),
        'buttons/ exists',
        $buttons_dir,
        'buttons_dir'
    ),
    chk(
        is_dir($buttons_dir) && is_writable($buttons_dir),
        'buttons/ writable by web server',
        is_dir($buttons_dir)
            ? (is_writable($buttons_dir) ? 'writable' : 'not writable — buttons cannot be saved')
            : 'directory missing',
        'buttons_dir'
    ),
    chk(
        is_dir($logs_dir),
        'command_logs/ exists',
        $logs_dir,
        'logs_dir'
    ),
    chk(
        is_dir($logs_dir) && is_writable($logs_dir),
        'command_logs/ writable by web server',
        is_dir($logs_dir)
            ? (is_writable($logs_dir) ? 'writable' : 'not writable — background commands will fail')
            : 'directory missing',
        'logs_dir'
    ),
    chk(
        is_readable($config_file),
        'include/config.php readable',
        is_readable($config_file) ? 'readable' : 'cannot read config — GumCP will not load',
        'gumcp_chown'
    ),
    chk(
        file_exists($buttons_dir . '/.htaccess'),
        'buttons/ protected from web access',
        file_exists($buttons_dir . '/.htaccess') ? '.htaccess present' : 'missing .htaccess — buttons.json may be publicly downloadable'
    ),
    chk(
        file_exists($logs_dir . '/.htaccess'),
        'command_logs/ protected from web access',
        file_exists($logs_dir . '/.htaccess') ? '.htaccess present' : 'missing .htaccess — log files may be publicly downloadable'
    ),
    chk(
        file_exists(__DIR__ . '/include/config.defaults.php'),
        'include/config.defaults.php present',
        file_exists(__DIR__ . '/include/config.defaults.php') ? 'present' : 'missing — old config.php may lack new settings'
    ),
];

// SSH test (only if extension loaded)
$ssh_ok     = false;
$ssh_detail = 'not tested — php-ssh2 not loaded';
if (extension_loaded('ssh2')) {
    $conn = @ssh2_connect('localhost', (int)SSH_PORT);
    if ($conn === false) {
        $ssh_detail = 'cannot connect to localhost:' . SSH_PORT;
    } elseif (!@ssh2_auth_password($conn, SSH_USER, SSH_PASS)) {
        $ssh_detail = 'connected but authentication failed — check SSH_USER / SSH_PASS in config.php';
        unset($conn);
    } else {
        $ssh_ok     = true;
        $ssh_detail = 'authenticated as ' . SSH_USER . ' on port ' . SSH_PORT;
        @ssh2_exec($conn, 'exit');
        unset($conn);
    }
}
$sections['SSH'] = [
    chk(extension_loaded('ssh2'), 'php-ssh2 extension',       '', 'install_ssh2'),
    chk($ssh_ok,                  'SSH connection to localhost', $ssh_detail, 'start_ssh'),
];

$sections['GPIO'] = [
    chk(true, 'Hardware', $pi_model !== '' ? $pi_model : 'Unknown (not a Raspberry Pi?)'),
    $is_pi5
        ? chk(
            cmd_exists('raspi-gpio'),
            'raspi-gpio (required on Pi 5)',
            cmd_exists('raspi-gpio') ? 'installed' : 'missing',
            'install_raspi_gpio'
          )
        : chk(
            cmd_exists('gpio'),
            'WiringPi gpio command (required on Pi 1–4)',
            cmd_exists('gpio') ? 'installed' : 'missing — GPIO page will not work'
          ),
];

$sections['System Commands'] = [
    chk(cmd_exists('ps'),      'ps'),
    chk(cmd_exists('who'),     'who'),
    chk(cmd_exists('df'),      'df'),
    chk(cmd_exists('service'), 'service'),
];

$total_fail = 0;
foreach ($sections as $checks) {
    foreach ($checks as $c) {
        if (!$c['ok']) $total_fail++;
    }
}

$csrf = htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8');

$page_title = 'System Check';
require_once('./include/header.php');
?>

<script>
    var CSRF_TOKEN = <?php echo json_encode($_SESSION['csrf_token']); ?>;

    function applyFix(fixKey, btn) {
        var $btn = $(btn);
        var $row = $btn.closest('tr');
        $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Fixing...');

        $.ajax({
            type: 'POST',
            url: 'ajax.php',
            data: { action: 'system_fix', fix: fixKey, csrf_token: CSRF_TOKEN },
            dataType: 'json',
            success: function(data) {
                if (data.type === 'success') {
                    $row.removeClass('danger').addClass('success');
                    $btn.replaceWith('<span class="text-success"><i class="fa fa-check"></i> Fixed</span>');
                    var output = data.output ? data.output.trim() : '';
                    if (output) {
                        $row.after('<tr class="success"><td colspan="4"><pre style="margin:4px 0;font-size:11px;background:transparent;border:none">'
                            + $('<span>').text(output).html() + '</pre></td></tr>');
                    }
                } else {
                    $btn.prop('disabled', false).html('<i class="fa fa-wrench"></i> Fix');
                    alert('Fix failed: ' + (data.message || 'unknown error'));
                }
            },
            error: function() {
                $btn.prop('disabled', false).html('<i class="fa fa-wrench"></i> Fix');
                alert('Request failed — check your SSH settings.');
            }
        });
    }

    function recheck() {
        var $btn = $('#recheck-btn');
        $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Checking...');
        $.ajax({
            type: 'POST',
            url: 'ajax.php',
            data: { action: 'system_check', csrf_token: CSRF_TOKEN },
            dataType: 'json',
            success: function(data) {
                $btn.prop('disabled', false).html('<i class="fa fa-refresh"></i> Re-check');
                if (data.all_pass) {
                    location.reload();
                } else {
                    location.reload();
                }
            },
            error: function() {
                $btn.prop('disabled', false).html('<i class="fa fa-refresh"></i> Re-check');
            }
        });
    }
    </script>
    <div class="page-header">
        <h1>
            <i class="fa fa-stethoscope"></i> System Check
            <small>PHP <?php echo htmlspecialchars(PHP_VERSION, ENT_QUOTES, 'UTF-8'); ?></small>
        </h1>
    </div>

    <?php if ($total_fail === 0): ?>
        <div class="alert alert-success" role="alert">
            <i class="fa fa-check-circle fa-lg"></i>
            <strong>All checks passed.</strong> GumCP is correctly installed and configured.
        </div>
    <?php else: ?>
        <div class="alert alert-warning" role="alert">
            <i class="fa fa-exclamation-triangle fa-lg"></i>
            <strong><?php echo $total_fail; ?> check<?php echo $total_fail !== 1 ? 's' : ''; ?> failed.</strong>
            Click <strong>Fix</strong> next to any failing item to repair it via SSH,
            then click <strong>Re-check</strong> to refresh.
        </div>
    <?php endif; ?>

    <?php foreach ($sections as $title => $checks): ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <i class="fa fa-folder-open-o"></i>
                    <?php echo htmlspecialchars($title, ENT_QUOTES, 'UTF-8'); ?>
                </h3>
            </div>
            <table class="table table-condensed" style="margin-bottom:0">
                <tbody>
                    <?php foreach ($checks as $c): ?>
                        <tr class="<?php echo $c['ok'] ? '' : 'danger'; ?>">
                            <td style="width:28px; padding-left:14px; vertical-align:middle">
                                <i class="fa <?php echo $c['ok'] ? 'fa-check text-success' : 'fa-times text-danger'; ?>"></i>
                            </td>
                            <td style="width:280px; vertical-align:middle">
                                <strong><?php echo htmlspecialchars($c['label'], ENT_QUOTES, 'UTF-8'); ?></strong>
                            </td>
                            <td class="text-muted" style="font-size:13px; vertical-align:middle">
                                <?php echo htmlspecialchars($c['detail'], ENT_QUOTES, 'UTF-8'); ?>
                            </td>
                            <td style="width:90px; vertical-align:middle; text-align:right">
                                <?php if (!$c['ok'] && $c['fix_key'] !== ''): ?>
                                    <button type="button"
                                            class="btn btn-xs btn-warning"
                                            onclick="applyFix(<?php echo htmlspecialchars(json_encode($c['fix_key']), ENT_QUOTES, 'UTF-8'); ?>, this)">
                                        <i class="fa fa-wrench"></i> Fix
                                    </button>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endforeach; ?>

    <button id="recheck-btn" type="button" class="btn btn-default" onclick="recheck()">
        <i class="fa fa-refresh"></i> Re-check
    </button>

    <p class="text-muted" style="font-size:12px; margin-top:12px">
        <i class="fa fa-info-circle"></i>
        Fix commands run via SSH as <strong><?php echo htmlspecialchars(SSH_USER, ENT_QUOTES, 'UTF-8'); ?></strong>.
        For issues that cannot be fixed here, run on the Pi:
        <code>sudo bash <?php echo htmlspecialchars($gumcp_dir, ENT_QUOTES, 'UTF-8'); ?>/check.sh --fix</code>
    </p>

</div>

<?php require_once('./include/footer.php'); ?>
