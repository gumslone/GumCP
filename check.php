<?php
declare(strict_types=1);

$active_page = '';
require_once('./include/init.php');

// ── Helpers ───────────────────────────────────────────────────────────────────

function chk(bool $ok, string $label, string $detail = '', string $fix_key = ''): array {
    return compact('ok', 'label', 'detail', 'fix_key');
}

/**
 * Verify every installed optional module is reachable only through its guarded
 * entry point. Returns '' when all is well, or a description of the problem.
 *
 * Checks both layers, because each can fail on its own: the entry file must load
 * include/module_guard.php, and the vendored upstream file must carry the
 * injected GUMCP_MODULE_KEY guard (the vendor/.htaccess is not sufficient —
 * Debian ships Apache with AllowOverride None, which ignores .htaccess).
 */
function gumcp_modules_protected(): string {
    $problems = [];
    foreach (['adminer', 'tinyfilemanager'] as $key) {
        $dir   = __DIR__ . '/modules/' . $key;
        $entry = $dir . '/' . $key . '.php';
        if (!is_file($entry)) continue;   // not installed

        $src = (string)@file_get_contents($entry);
        if (strpos($src, 'module_guard.php') === false) {
            $problems[] = $key . ': entry point does not require the login guard';
        }
        foreach ((array)@glob($dir . '/vendor/*.php') as $vendor) {
            $problems[] = $key . ': ' . basename($vendor)
                        . ' is directly executable — reinstall it from the Actions page';
        }
    }
    return implode('; ', $problems);
}

/**
 * Actually fetch a path over HTTP to see whether the web server serves it.
 *
 * Checking that an .htaccess file exists proves nothing: Debian and Raspberry Pi
 * OS use "AllowOverride None" for /var/www, which makes .htaccess inert. The only
 * reliable test is to request the URL and look at what comes back.
 *
 * Returns 'protected', 'EXPOSED' or 'unknown' (could not test).
 */
function gumcp_probe_path(string $relative): string {
    $base = gumcp_base_url();
    if ($base === '' || !function_exists('curl_init')) return 'unknown';

    $ch = curl_init($base . '/' . ltrim($relative, '/'));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 4);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);   // self-signed is common here
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    $body = curl_exec($ch);
    $code = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
    if (PHP_VERSION_ID < 80000) curl_close($ch);   // no-op since 8.0, deprecated in 8.5

    if ($body === false || $code === 0) return 'unknown';
    if ($code === 200 && trim((string)$body) !== '') return 'EXPOSED';
    return 'protected';   // 403/404/empty — not being served
}

function gumcp_base_url(): string {
    $host = (string)($_SERVER['HTTP_HOST'] ?? '');
    if ($host === '') return '';
    $https  = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off');
    $scheme = $https ? 'https' : 'http';
    $dir    = rtrim(str_replace('\\', '/', dirname((string)($_SERVER['SCRIPT_NAME'] ?? '/'))), '/');
    return $scheme . '://' . $host . $dir;
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

// Probe the sensitive directories over HTTP once, and reuse the result below.
// A missing file would 404 and look "protected", so ask for something that
// definitely exists where possible.
$probe_buttons = gumcp_probe_path(
    is_file($gumcp_dir . '/buttons/buttons.json') ? 'buttons/buttons.json' : 'buttons/'
);
$probe_logs = gumcp_probe_path('command_logs/');

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

$sections['Security'] = [
    chk(
        gumcp_auth_configured(),
        'Authentication configured',
        gumcp_auth_configured()
            ? 'login page and/or HTTP Basic Auth is enabled'
            : 'NO authentication — anyone reaching this panel can run commands as ' . SSH_USER
    ),
    chk(
        !gumcp_open_mode(),
        'Unauthenticated access not allowed',
        gumcp_open_mode()
            ? 'GUMCP_ALLOW_UNAUTHENTICATED is true — the panel is open to everyone'
            : 'open access is disabled'
    ),
    chk(
        gumcp_modules_protected() === '',
        'Optional modules protected',
        gumcp_modules_protected() === ''
            ? 'installed modules require a login before any third-party code runs'
            : gumcp_modules_protected()
    ),
    chk(
        !gumcp_default_credentials(),
        'Credentials changed from defaults',
        gumcp_default_credentials()
            ? 'still using a shipped default password — change it in include/config.php'
            : 'not using the shipped defaults'
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
        $probe_buttons !== 'EXPOSED',
        'buttons/ not readable over HTTP',
        $probe_buttons === 'EXPOSED'
            ? 'buttons.json IS downloadable — it contains each button\'s API hash, which triggers commands without a login. Run: sudo a2enconf gumcp && sudo systemctl reload apache2'
            : ($probe_buttons === 'protected'
                ? 'verified by request — the web server refuses it'
                : 'could not test (needs php-curl); .htaccess '
                  . (file_exists($buttons_dir . '/.htaccess') ? 'present' : 'MISSING')
                  . ' — note .htaccess is ignored when Apache uses AllowOverride None')
    ),
    chk(
        $probe_logs !== 'EXPOSED',
        'command_logs/ not readable over HTTP',
        $probe_logs === 'EXPOSED'
            ? 'command output IS downloadable — it may contain anything your commands printed. Run: sudo a2enconf gumcp && sudo systemctl reload apache2'
            : ($probe_logs === 'protected'
                ? 'verified by request — the web server refuses it'
                : 'could not test (needs php-curl); .htaccess '
                  . (file_exists($logs_dir . '/.htaccess') ? 'present' : 'MISSING'))
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
