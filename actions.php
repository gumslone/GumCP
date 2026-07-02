<?php
declare(strict_types=1);

$active_page = 'actions';

require_once('./include/init.php');

if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$ssh_available = function_exists('ssh2_connect');

// ── Input validation helpers ──────────────────────────────────────────────────
function validate_pid($pid): bool {
    return is_numeric($pid) && (int)$pid > 0;
}

function validate_name(string $name): bool {
    return $name !== '' && preg_match('/^[a-zA-Z0-9_\-\.]+$/', $name) === 1;
}

// ── State ─────────────────────────────────────────────────────────────────────
$message        = '';
$message_type   = 'info';
$executed_cmd   = '';
$command_output = '';
$cmd            = '';

// ── Handle POST ───────────────────────────────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], (string)$_POST['csrf_token'])) {
        $message      = 'Invalid request — CSRF token mismatch. Please reload the page and try again.';
        $message_type = 'danger';

    } elseif (!$ssh_available) {
        $message      = 'The php-ssh2 extension is not installed. Actions require SSH.';
        $message_type = 'danger';

    } else {
        // Rotate the token after each valid submission so it cannot be replayed.
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

        $action = $_POST['action'] ?? '';

        switch ($action) {
            case 'kill_pid':
                $pid = $_POST['pid'] ?? '';
                if (validate_pid($pid)) {
                    $cmd = sprintf('sudo kill -9 %d', (int)$pid);
                } else {
                    $message      = 'Process ID must be a positive integer.';
                    $message_type = 'danger';
                }
                break;

            case 'kill_pname':
                $pname = trim($_POST['pname'] ?? '');
                if (validate_name($pname)) {
                    $cmd = sprintf('sudo killall %s', escapeshellarg($pname));
                } else {
                    $message      = 'Process name may only contain letters, digits, hyphens, underscores and dots.';
                    $message_type = 'danger';
                }
                break;

            case 'start_sname':
                $sname = trim($_POST['sname'] ?? '');
                if (validate_name($sname)) {
                    $cmd = sprintf('sudo service %s start', escapeshellarg($sname));
                } else {
                    $message      = 'Service name may only contain letters, digits, hyphens, underscores and dots.';
                    $message_type = 'danger';
                }
                break;

            case 'stop_sname':
                $sname = trim($_POST['sname'] ?? '');
                if (validate_name($sname)) {
                    $cmd = sprintf('sudo service %s stop', escapeshellarg($sname));
                } else {
                    $message      = 'Service name may only contain letters, digits, hyphens, underscores and dots.';
                    $message_type = 'danger';
                }
                break;

            case 'reboot':
                $cmd = 'sudo reboot';
                break;

            case 'git_pull':
                $git_target = trim((string)($_POST['git_target'] ?? 'master'));
                $base       = 'cd ' . escapeshellarg(__DIR__);
                if ($git_target === 'master') {
                    $cmd = $base . ' && sudo git pull origin master 2>&1';
                } else {
                    // Validate: tags are version strings like 1.0.0 or v1.2.3
                    if (preg_match('/^v?[0-9]+\.[0-9]+(\.[0-9]+)?$/', $git_target)) {
                        $cmd = $base
                            . ' && sudo git fetch --tags origin 2>&1'
                            . ' && sudo git reset --hard ' . escapeshellarg('refs/tags/' . $git_target) . ' 2>&1';
                    } else {
                        $message      = 'Invalid release tag.';
                        $message_type = 'danger';
                    }
                }
                break;

            case 'cmd':
                $raw = trim($_POST['cmd'] ?? '');
                if ($raw !== '') {
                    $cmd = $raw;
                } else {
                    $message      = 'Command cannot be empty.';
                    $message_type = 'danger';
                }
                break;

            default:
                $message      = 'Unknown action.';
                $message_type = 'danger';
                break;
        }
    }
}

// ── Ensure command_logs directory exists (PHP, not via SSH) ───────────────────
$command_logs_dir = __DIR__ . '/command_logs';
if (!is_dir($command_logs_dir)) {
    mkdir($command_logs_dir, 0755, true);
}

// ── Execute command via SSH ───────────────────────────────────────────────────
if ($cmd !== '') {
    $connection = null;
    try {
        $connection = @ssh2_connect('localhost', (int)SSH_PORT);
        if ($connection === false) {
            throw new Exception('Could not connect to SSH on port ' . SSH_PORT . '. Check that SSH is running.');
        }

        if (!@ssh2_auth_password($connection, SSH_USER, SSH_PASS)) {
            throw new Exception('SSH authentication failed — verify SSH_USER and SSH_PASS in config.php.');
        }

        $stream = ssh2_exec($connection, $cmd);
        if ($stream === false) {
            throw new Exception('ssh2_exec failed for command: ' . $cmd);
        }

        stream_set_blocking($stream, true);
        $stdout_stream = ssh2_fetch_stream($stream, SSH2_STREAM_STDIO);
        $stderr_stream = ssh2_fetch_stream($stream, SSH2_STREAM_STDERR);
        $stdout = (string)stream_get_contents($stdout_stream);
        $stderr = (string)stream_get_contents($stderr_stream);
        fclose($stdout_stream);
        fclose($stderr_stream);

        @ssh2_exec($connection, 'exit');

        $executed_cmd   = $cmd;
        $message        = 'Command executed successfully.';
        $message_type   = 'success';
        $command_output = trim($stdout . ($stderr !== '' ? "\n[stderr]\n" . $stderr : ''));

    } catch (Exception $e) {
        $message      = $e->getMessage();
        $message_type = 'danger';
    } finally {
        unset($connection);
    }
}

// ── Load log files sorted newest-first ───────────────────────────────────────
$log_files = [];
if (is_dir($command_logs_dir)) {
    foreach (array_diff(scandir($command_logs_dir), ['.', '..']) as $file) {
        if ($file[0] === '.') continue; // skip .htaccess and other dot-files
        $path = $command_logs_dir . '/' . $file;
        if (is_file($path) && substr($file, -4) === '.log') {
            $log_files[] = ['name' => $file, 'mtime' => (int)filemtime($path)];
        }
    }
    usort($log_files, function($a, $b) { return $b['mtime'] - $a['mtime']; });
}

$csrf = htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8');
$dir  = htmlspecialchars(__DIR__, ENT_QUOTES, 'UTF-8');

// ── Available git tags (for the update dropdown) ──────────────────────────────
$git_tags = [];
$raw_tags = shell_exec('git -C ' . escapeshellarg(__DIR__) . ' tag --sort=-v:refname 2>/dev/null');
if ($raw_tags !== null) {
    foreach (explode("\n", trim($raw_tags)) as $t) {
        $t = trim($t);
        if ($t !== '') $git_tags[] = $t;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="GumCP Actions">
    <link rel="shortcut icon" href="./static/images/raspberry.png" type="image/png" />
    <link rel="icon" href="./static/images/raspberry.png" type="image/png" />
    <title>GumCP Actions</title>
    <link href="./static/css.php" rel="stylesheet" type="text/css">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <script src="./static/js.php" type="text/javascript"></script>
    <script>
    var CSRF_TOKEN = <?php echo json_encode($_SESSION['csrf_token']); ?>;

    function confirmGitUpdate() {
        var sel = document.getElementById('git-target');
        var val = sel.value;
        var label = sel.options[sel.selectedIndex].text.trim();
        var msg = val === 'master'
            ? 'Pull the latest master branch from GitHub?\n\nRuns: git pull origin master'
            : 'Switch to ' + label + ' from GitHub?\n\nRuns: git fetch --tags && git reset --hard refs/tags/' + val + '\n\nThis will overwrite any local file changes.';
        return confirm(msg);
    }

    function refreshGitTags() {
        var $b = $('#git-refresh-btn');
        $b.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i>');
        $.ajax({
            type: 'POST', url: 'ajax.php', dataType: 'json',
            data: { action: 'git_tags', csrf_token: CSRF_TOKEN },
            success: function(d) {
                var tags = (d && d.tags) || [];
                var sel = document.getElementById('git-target');
                var current = sel.value;
                sel.options.length = 1; // keep "Latest (master branch)"
                tags.forEach(function(t) {
                    var o = document.createElement('option');
                    o.value = t; o.textContent = 'Release ' + t;
                    sel.appendChild(o);
                });
                sel.value = current; // restore selection if still present
                if (d && d.error) {
                    alert('Tags refreshed from local repo, but fetching from GitHub failed:\n' + d.error);
                }
            },
            error: function() { alert('Request failed — check SSH settings.'); },
            complete: function() { $b.prop('disabled', false).html('<i class="fa fa-refresh"></i>'); }
        });
    }

    $(document).ready(function() {

        // ── Background command form ───────────────────────────────────────────
        $('#advanced-command-form').on('submit', function(e) {
            if (!confirm('Are you sure you want to execute this command?')) {
                e.preventDefault();
                return false;
            }
            if ($('#background-command').is(':checked')) {
                e.preventDefault();
                var $btn = $(this).find('button[type=submit]');
                $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Sending...');

                $.ajax({
                    type: 'POST',
                    url: 'execute_command.php',
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function(data) {
                        if (data.success) {
                            alert('Command sent to background.' + (data.log_file ? '\nLog: ' + data.log_file : ''));
                            $('#cmd').val('');
                            location.reload();
                        } else {
                            alert('Error: ' + (data.message || 'Unknown error'));
                        }
                        $btn.prop('disabled', false).html('Execute');
                    },
                    error: function() {
                        alert('Error communicating with server');
                        $btn.prop('disabled', false).html('Execute');
                    }
                });
                return false;
            }
        });

        // ── Delete log file ───────────────────────────────────────────────────
        $(document).on('click', '.delete-log-btn', function() {
            var file = $(this).data('file');
            var $row = $(this).closest('.log-entry');
            if (!confirm('Delete log file "' + file + '"?')) return;

            $.ajax({
                type: 'POST',
                url: 'ajax.php',
                data: { action: 'delete_log', log_file: file, csrf_token: CSRF_TOKEN },
                dataType: 'json',
                success: function(data) {
                    if (data.type === 'success') {
                        $row.remove();
                    } else {
                        alert(data.message || 'Delete failed');
                    }
                },
                error: function() { alert('Error deleting log'); }
            });
        });

    });
    </script>
</head>

<body>
<div class="container">

    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="./index.php">
                    <img src="./static/images/raspberry.png" alt="Logo" />GumCP
                </a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav navbar-right">
                    <?php require_once('./include/menu.php'); ?>
                </ul>
            </div>
        </div>
    </nav>

    <?php if (!$ssh_available): ?>
        <div class="alert alert-danger" role="alert">
            <i class="fa fa-exclamation-circle"></i>
            <strong>php-ssh2 is not installed.</strong>
            This page requires the SSH2 PHP extension.
            Install it with: <code>sudo apt-get install php-ssh2 &amp;&amp; sudo systemctl restart apache2</code>
        </div>
    <?php endif; ?>

    <!-- Result message -->
    <?php if ($message !== ''): ?>
        <div class="alert alert-<?php echo htmlspecialchars($message_type, ENT_QUOTES, 'UTF-8'); ?>" role="alert">
            <i class="fa fa-<?php echo $message_type === 'success' ? 'check-circle' : ($message_type === 'danger' ? 'times-circle' : 'info-circle'); ?>"></i>
            <?php echo htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?>
            <?php if ($executed_cmd !== ''): ?>
                <br><strong>Command:</strong> <code><?php echo htmlspecialchars($executed_cmd, ENT_QUOTES, 'UTF-8'); ?></code>
            <?php endif; ?>
            <?php if ($command_output !== ''): ?>
                <pre class="pre-scrollable" style="margin-top:8px; font-size:12px;"><?php echo htmlspecialchars($command_output, ENT_QUOTES, 'UTF-8'); ?></pre>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-cogs"></i> <?php echo htmlspecialchars(t('act.title', 'Actions'), ENT_QUOTES, 'UTF-8'); ?></h3>
        </div>
        <div class="panel-body">

            <!-- Kill by PID -->
            <form method="post" onsubmit="return confirm('Kill process?')">
                <input type="hidden" name="csrf_token" value="<?php echo $csrf; ?>">
                <input type="hidden" name="action"     value="kill_pid">
                <div class="form-group row">
                    <label class="col-sm-3 control-label" for="pid"><?php echo htmlspecialchars(t('act.kill_pid', 'Kill process by PID'), ENT_QUOTES, 'UTF-8'); ?></label>
                    <div class="col-sm-4">
                        <input type="number" class="form-control" id="pid" name="pid"
                               placeholder="Process ID" min="1" required>
                    </div>
                    <div class="col-sm-2">
                        <button type="submit" class="btn btn-danger">
                            <i class="fa fa-times"></i> <?php echo htmlspecialchars(t('act.kill', 'Kill'), ENT_QUOTES, 'UTF-8'); ?>
                        </button>
                    </div>
                </div>
            </form>

            <hr>

            <!-- Kill by name -->
            <form method="post" onsubmit="return confirm('Kill all processes with this name?')">
                <input type="hidden" name="csrf_token" value="<?php echo $csrf; ?>">
                <input type="hidden" name="action"     value="kill_pname">
                <div class="form-group row">
                    <label class="col-sm-3 control-label" for="pname"><?php echo htmlspecialchars(t('act.kill_pname', 'Kill processes by name'), ENT_QUOTES, 'UTF-8'); ?></label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="pname" name="pname"
                               placeholder="Process name" pattern="[a-zA-Z0-9_\-\.]+" required>
                    </div>
                    <div class="col-sm-2">
                        <button type="submit" class="btn btn-danger">
                            <i class="fa fa-times"></i> <?php echo htmlspecialchars(t('act.kill', 'Kill'), ENT_QUOTES, 'UTF-8'); ?>
                        </button>
                    </div>
                </div>
            </form>

            <hr>

            <!-- Start service -->
            <form method="post" onsubmit="return confirm('Start this service?')">
                <input type="hidden" name="csrf_token" value="<?php echo $csrf; ?>">
                <input type="hidden" name="action"     value="start_sname">
                <div class="form-group row">
                    <label class="col-sm-3 control-label" for="sname-start"><?php echo htmlspecialchars(t('act.start_service', 'Start service'), ENT_QUOTES, 'UTF-8'); ?></label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="sname-start" name="sname"
                               placeholder="Service name" pattern="[a-zA-Z0-9_\-\.]+" required>
                    </div>
                    <div class="col-sm-2">
                        <button type="submit" class="btn btn-success">
                            <i class="fa fa-play"></i> <?php echo htmlspecialchars(t('act.start', 'Start'), ENT_QUOTES, 'UTF-8'); ?>
                        </button>
                    </div>
                </div>
            </form>

            <hr>

            <!-- Stop service -->
            <form method="post" onsubmit="return confirm('Stop this service?')">
                <input type="hidden" name="csrf_token" value="<?php echo $csrf; ?>">
                <input type="hidden" name="action"     value="stop_sname">
                <div class="form-group row">
                    <label class="col-sm-3 control-label" for="sname-stop"><?php echo htmlspecialchars(t('act.stop_service', 'Stop service'), ENT_QUOTES, 'UTF-8'); ?></label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="sname-stop" name="sname"
                               placeholder="Service name" pattern="[a-zA-Z0-9_\-\.]+" required>
                    </div>
                    <div class="col-sm-2">
                        <button type="submit" class="btn btn-warning">
                            <i class="fa fa-stop"></i> <?php echo htmlspecialchars(t('act.stop', 'Stop'), ENT_QUOTES, 'UTF-8'); ?>
                        </button>
                    </div>
                </div>
            </form>

            <hr>

            <!-- Advanced command -->
            <form method="post" id="advanced-command-form">
                <input type="hidden" name="csrf_token" value="<?php echo $csrf; ?>">
                <input type="hidden" name="action"     value="cmd">
                <div class="form-group row">
                    <label class="col-sm-3 control-label" for="cmd">
                        <?php echo htmlspecialchars(t('act.exec_label', 'Execute command'), ENT_QUOTES, 'UTF-8'); ?>
                        <small class="text-danger"><br>Advanced users only</small>
                    </label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" id="cmd" name="cmd"
                               placeholder="e.g. sudo systemctl restart apache2" required>
                        <div class="checkbox" style="margin-top:6px;">
                            <label>
                                <input type="checkbox" id="background-command" name="background_command" value="1">
                                <?php echo htmlspecialchars(t('act.background', 'Run in background (output saved to log file)'), ENT_QUOTES, 'UTF-8'); ?>
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-terminal"></i> <?php echo htmlspecialchars(t('act.exec', 'Execute'), ENT_QUOTES, 'UTF-8'); ?>
                        </button>
                    </div>
                </div>
            </form>

        </div>
    </div>

    <!-- Reboot & Update -->
    <div class="panel panel-warning" style="margin-top:10px">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-wrench"></i> <?php echo htmlspecialchars(t('act.system', 'System'), ENT_QUOTES, 'UTF-8'); ?></h3>
        </div>
        <div class="panel-body">

            <!-- Reboot -->
            <form method="post" onsubmit="return confirm('Reboot the Raspberry Pi now?')">
                <input type="hidden" name="csrf_token" value="<?php echo $csrf; ?>">
                <input type="hidden" name="action"     value="reboot">
                <div class="form-group row" style="margin-bottom:0">
                    <label class="col-sm-3 control-label"><?php echo htmlspecialchars(t('act.reboot_label', 'Reboot Raspberry Pi'), ENT_QUOTES, 'UTF-8'); ?></label>
                    <div class="col-sm-9">
                        <button type="submit" class="btn btn-danger">
                            <i class="fa fa-refresh"></i> <?php echo htmlspecialchars(t('act.reboot', 'Reboot'), ENT_QUOTES, 'UTF-8'); ?>
                        </button>
                    </div>
                </div>
            </form>

            <hr>

            <!-- Update from GitHub -->
            <form method="post" id="git-update-form" onsubmit="return confirmGitUpdate()">
                <input type="hidden" name="csrf_token" value="<?php echo $csrf; ?>">
                <input type="hidden" name="action"     value="git_pull">
                <div class="form-group row" style="margin-bottom:0">
                    <label class="col-sm-3 control-label">
                        <?php echo htmlspecialchars(t('act.update_label', 'Update GumCP'), ENT_QUOTES, 'UTF-8'); ?>
                        <small class="text-muted"><br>from GitHub</small>
                    </label>
                    <div class="col-sm-9">
                        <div class="input-group" style="max-width:320px">
                            <select name="git_target" id="git-target" class="form-control">
                                <option value="master">Latest (master branch)</option>
                                <?php foreach ($git_tags as $tag): ?>
                                    <option value="<?php echo htmlspecialchars($tag, ENT_QUOTES, 'UTF-8'); ?>">
                                        Release <?php echo htmlspecialchars($tag, ENT_QUOTES, 'UTF-8'); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-default" id="git-refresh-btn"
                                        onclick="refreshGitTags()" title="Fetch latest releases from GitHub">
                                    <i class="fa fa-refresh"></i>
                                </button>
                                <button type="submit" class="btn btn-warning">
                                    <i class="fa fa-cloud-download"></i> <?php echo htmlspecialchars(t('act.update', 'Update'), ENT_QUOTES, 'UTF-8'); ?>
                                </button>
                            </span>
                        </div>
                        <small class="text-muted" style="display:block; margin-top:4px">
                            Only releases this Pi has fetched are listed — click
                            <i class="fa fa-refresh"></i> to fetch the newest from GitHub.
                            Your <code>config.php</code>, buttons and logs are preserved.
                        </small>
                    </div>
                </div>
            </form>

        </div>
    </div>

    <!-- System check shortcut -->
    <div class="panel panel-info" style="margin-top:10px">
        <div class="panel-body" style="display:flex; align-items:center; justify-content:space-between">
            <span>
                <i class="fa fa-stethoscope fa-lg"></i>
                <strong style="margin-left:6px"><?php echo htmlspecialchars(t('act.syscheck', 'System Check'), ENT_QUOTES, 'UTF-8'); ?></strong>
                <span class="text-muted" style="margin-left:8px">— verify PHP extensions, directory permissions, SSH and GPIO tools</span>
            </span>
            <a href="./check.php" class="btn btn-info btn-sm">
                <i class="fa fa-stethoscope"></i> <?php echo htmlspecialchars(t('act.syscheck_run', 'Run System Check'), ENT_QUOTES, 'UTF-8'); ?>
            </a>
        </div>
    </div>

    <?php if (!empty($gumcp_modules['button_api']['module_active'])): ?>
    <div class="panel panel-info" style="margin-top:10px">
        <div class="panel-body" style="display:flex; align-items:center; justify-content:space-between">
            <span>
                <i class="fa fa-link fa-lg"></i>
                <strong style="margin-left:6px">Button API</strong>
                <span class="text-muted" style="margin-left:8px">— trigger any button via a secret URL, no login required</span>
            </span>
            <a href="./buttons.php" class="btn btn-info btn-sm">
                <i class="fa fa-link"></i> Manage Buttons
            </a>
        </div>
    </div>
    <?php endif; ?>

    <!-- Useful commands reference -->
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-book"></i> <?php echo htmlspecialchars(t('act.useful', 'Useful commands'), ENT_QUOTES, 'UTF-8'); ?></h3>
        </div>
        <div class="panel-body">
            <dl class="dl-horizontal">
                <dt>Run a Python script</dt>
                <dd><code>python3 /path/to/script.py</code></dd>
                <dt>Update package sources</dt>
                <dd><code>sudo apt-get update</code></dd>
                <dt>Update RPi firmware</dt>
                <dd><code>sudo rpi-update</code></dd>
                <dt>Reboot</dt>
                <dd><code>sudo reboot</code></dd>
                <dt>Update GumCP</dt>
                <dd><code>cd <?php echo $dir; ?> &amp;&amp; sudo git pull origin master</code>
                    <small class="text-muted"> — re-check config.php after update</small></dd>
                <dt>Fix config permissions</dt>
                <dd><code>sudo chmod 664 <?php echo $dir; ?>/include/config.php</code></dd>
            </dl>
        </div>
    </div>

    <!-- Background command logs -->
    <?php if (!empty($log_files)): ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-file-text-o"></i> <?php echo htmlspecialchars(t('act.bg_logs', 'Background command logs'), ENT_QUOTES, 'UTF-8'); ?></h3>
            </div>
            <div class="panel-body">
                <table class="table table-condensed table-hover">
                    <thead>
                        <tr>
                            <th>File</th>
                            <th>Date</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($log_files as $log): ?>
                            <tr class="log-entry">
                                <td>
                                    <a href="./command_logs/<?php echo htmlspecialchars($log['name'], ENT_QUOTES, 'UTF-8'); ?>">
                                        <?php echo htmlspecialchars($log['name'], ENT_QUOTES, 'UTF-8'); ?>
                                    </a>
                                </td>
                                <td><?php echo htmlspecialchars(date('Y-m-d H:i:s', $log['mtime']), ENT_QUOTES, 'UTF-8'); ?></td>
                                <td>
                                    <button type="button" class="btn btn-xs btn-danger delete-log-btn"
                                            data-file="<?php echo htmlspecialchars($log['name'], ENT_QUOTES, 'UTF-8'); ?>"
                                            title="Delete log">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif; ?>

</div>

<footer class="footer">
    <div class="container">
        <p class="text-muted">
            GumCP <a href="https://github.com/gumslone/GumCP" target="_blank" rel="noopener">GitHub</a>.
            <a href="https://www.paypal.com/donate/?hosted_button_id=VCWHQPACTXV5N" target="_blank" rel="noopener">
                <img src="./static/images/Donate-PayPal-green.svg" alt="Donate"/>
            </a>
        </p>
    </div>
</footer>

</body>
</html>
