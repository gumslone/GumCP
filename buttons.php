<?php
declare(strict_types=1);

$active_page = 'buttons';

require_once('./include/config.php');

if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$message      = '';
$message_type = 'info';

$buttons_dir  = __DIR__ . '/buttons';
$buttons_file = $buttons_dir . '/buttons.json';
$buttons      = [];

if (!is_dir($buttons_dir) && !@mkdir($buttons_dir, 0755, true)) {
    $message      = 'Cannot create buttons directory ' . $buttons_dir
                  . ' — fix with: sudo mkdir -p ' . $buttons_dir
                  . ' &amp;&amp; sudo chown www-data:www-data ' . $buttons_dir;
    $message_type = 'danger';
}

if (file_exists($buttons_file)) {
    $contents = file_get_contents($buttons_file);
    if ($contents !== false) {
        $decoded = json_decode($contents, true);
        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
            $buttons = $decoded;
        } else {
            $message      = 'Warning: buttons.json is corrupted';
            $message_type = 'warning';
        }
    }
}

$csrf = htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8');

$allowed_styles = ['btn-default', 'btn-primary', 'btn-success', 'btn-info', 'btn-warning', 'btn-danger'];
$allowed_sizes  = ['btn-xs', 'btn-sm', 'btn-md', 'btn-lg'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="GumCP Command Buttons">
    <link rel="shortcut icon" href="./static/images/raspberry.png" type="image/png" />
    <link rel="icon" href="./static/images/raspberry.png" type="image/png" />
    <title>GumCP Buttons</title>
    <link href="./static/css.php" rel="stylesheet" type="text/css">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <script src="./static/js.php" type="text/javascript"></script>
    <script>
    var CSRF_TOKEN = <?php echo json_encode($_SESSION['csrf_token']); ?>;

    /* ── modal helpers ──────────────────────────────────────────────────── */
    function openButtonModal(title, buttonId) {
        $('#button-modal .modal-title').text(title);
        $('#button-modal-form')[0].reset();
        $('#modal-button-id').val(buttonId !== undefined ? buttonId : '');
        $('#button-modal').modal('show');
    }

    function addButton() {
        openButtonModal('Add Command Button');
    }

    /* ── edit ───────────────────────────────────────────────────────────── */
    function editButton(buttonId) {
        openButtonModal('Edit Command Button', buttonId);

        $.ajax({
            type: 'POST',
            url: 'ajax.php',
            data: { action: 'edit_button', button_id: buttonId, csrf_token: CSRF_TOKEN },
            dataType: 'json',
            success: function(data) {
                if (data.type === 'error') {
                    alert(data.message);
                    $('#button-modal').modal('hide');
                    return;
                }
                $('#modal-button-title').val(data.button_title   || '');
                $('#modal-button-command').val(data.button_command || '');
                $('#modal-button-icon').val(data.button_icon    || '');
                $('#modal-button-style').val(data.button_style  || 'btn-default');
                $('#modal-button-size').val(data.button_size   || 'btn-md');
            },
            error: function() {
                alert('Error loading button data');
                $('#button-modal').modal('hide');
            }
        });
    }

    /* ── save (add + edit share the same form) ──────────────────────────── */
    function saveButton() {
        var $btn = $('#modal-save-btn');
        $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Saving...');

        var formData = $('#button-modal-form').serializeArray();
        formData.push({ name: 'csrf_token', value: CSRF_TOKEN });

        $.ajax({
            type: 'POST',
            url: 'ajax.php',
            data: formData,
            dataType: 'json',
            success: function(data) {
                if (data.type === 'success') {
                    $('#button-modal').modal('hide');
                    location.reload();
                } else {
                    alert(data.message || 'An error occurred');
                    $btn.prop('disabled', false).text('Save');
                }
            },
            error: function() {
                alert('Error saving button');
                $btn.prop('disabled', false).text('Save');
            }
        });
    }

    /* ── execute ────────────────────────────────────────────────────────── */
    var _execButtonId = null;

    function executeButton(buttonId, title, command) {
        _execButtonId = buttonId;
        $('#exec-modal-title').text(title);
        $('#exec-modal-command').text(command);
        $('#exec-modal-output-wrap').hide();
        $('#exec-modal-output').text('');
        $('#exec-modal-footer-run').show();
        $('#exec-modal-footer-close').hide().text('Close');
        $('#exec-run-btn').prop('disabled', false).html('<i class="fa fa-play"></i> Execute');
        $('#exec-modal').modal('show');
    }

    function runExecCommand() {
        var buttonId = _execButtonId;
        var $runBtn  = $('#exec-run-btn');
        $runBtn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Running&hellip;');
        $('#exec-modal-output-wrap').hide();

        $.ajax({
            type: 'POST',
            url: 'ajax.php',
            data: { action: 'execute_button', button_id: buttonId, csrf_token: CSRF_TOKEN },
            dataType: 'json',
            success: function(data) {
                var ok     = data.type === 'success';
                var output = (data.output || '').trim() || (ok ? '(no output)' : data.message || 'Command failed');
                $('#exec-modal-output')
                    .removeClass('text-success text-danger')
                    .addClass(ok ? 'text-success' : 'text-danger')
                    .text(output);
                $('#exec-modal-output-wrap').show();
                $('#exec-modal-footer-run').hide();
                $('#exec-modal-footer-close').show();
            },
            error: function() {
                $('#exec-modal-output').removeClass('text-success text-danger').addClass('text-danger')
                    .text('Request failed — could not reach the server.');
                $('#exec-modal-output-wrap').show();
                $('#exec-modal-footer-run').hide();
                $('#exec-modal-footer-close').show();
            }
        });
    }

    /* ── delete ─────────────────────────────────────────────────────────── */
    function deleteButton(buttonId) {
        if (!confirm('Delete this button?')) return;

        $.ajax({
            type: 'POST',
            url: 'ajax.php',
            data: { action: 'delete_button', button_id: buttonId, csrf_token: CSRF_TOKEN },
            dataType: 'json',
            success: function(data) {
                if (data.type === 'success') {
                    location.reload();
                } else {
                    alert(data.message || 'Delete failed');
                }
            },
            error: function() { alert('Error deleting button'); }
        });
    }
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

    <div class="page-header">
        <h1>Command Buttons <small>Execute predefined commands</small></h1>
    </div>

    <button type="button" class="btn btn-success" onclick="addButton()">
        <i class="fa fa-plus"></i> Add Command Button
    </button>

    <div class="panel panel-default" style="margin-top: 15px">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-terminal"></i> Command Buttons</h3>
        </div>
        <div class="panel-body">

            <?php if (!empty($message)): ?>
                <div class="alert alert-<?php echo htmlspecialchars($message_type, ENT_QUOTES, 'UTF-8'); ?>" role="alert">
                    <?php echo htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?>
                </div>
            <?php endif; ?>

            <?php if (empty($buttons)): ?>
                <div class="alert alert-info" role="alert">
                    <i class="fa fa-info-circle"></i>
                    No buttons yet. Click <strong>Add Command Button</strong> to create one.
                </div>
            <?php else: ?>
                <div class="button-container">
                    <?php foreach ($buttons as $index => $button):
                        $style   = in_array($button['button_style'] ?? '', $allowed_styles) ? $button['button_style'] : 'btn-default';
                        $size    = in_array($button['button_size']  ?? '', $allowed_sizes)  ? $button['button_size']  : 'btn-md';
                        $title   = htmlspecialchars($button['button_title']   ?? 'Untitled', ENT_QUOTES, 'UTF-8');
                        $command = htmlspecialchars($button['button_command'] ?? '',         ENT_QUOTES, 'UTF-8');
                        $icon    = htmlspecialchars($button['button_icon']    ?? '',         ENT_QUOTES, 'UTF-8');
                        $idx     = (int) $index;
                    ?>
                        <div class="btn-group" role="group" style="margin: 5px;">
                            <button
                                id="execute-btn-<?php echo $idx; ?>"
                                type="button"
                                class="btn <?php echo $style; ?> <?php echo $size; ?>"
                                onclick="executeButton(<?php echo $idx; ?>, <?php echo htmlspecialchars(json_encode($button['button_title'] ?? 'Untitled'), ENT_QUOTES, 'UTF-8'); ?>, <?php echo htmlspecialchars(json_encode($button['button_command'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>)">
                                <?php if ($icon !== ''): ?>
                                    <i class="fa <?php echo $icon; ?>" aria-hidden="true"></i>
                                <?php endif; ?>
                                <?php echo $title; ?>
                            </button>
                            <div class="btn-group" role="group">
                                <button type="button"
                                    class="btn btn-default dropdown-toggle <?php echo $size; ?>"
                                    data-toggle="dropdown"
                                    aria-haspopup="true"
                                    aria-expanded="false">
                                    <span class="caret"></span>
                                    <span class="sr-only">Options</span>
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="#" onclick="editButton(<?php echo $idx; ?>); return false;">
                                            <i class="fa fa-edit"></i> Edit
                                        </a>
                                    </li>
                                    <li role="separator" class="divider"></li>
                                    <li>
                                        <a href="#" onclick="deleteButton(<?php echo $idx; ?>); return false;" class="text-danger">
                                            <i class="fa fa-trash"></i> Delete
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

        </div>
    </div>

    <div class="panel panel-info" style="margin-top:10px">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-info-circle"></i> How it works</h3>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-4">
                    <p><i class="fa fa-plus-circle text-success fa-fw"></i> <strong>Create a button</strong><br>
                    Click <em>Add Command Button</em>, give it a name, and enter the shell command you want to run — for example <code>sudo systemctl restart apache2</code> or <code>sudo reboot</code>. Choose an icon, colour, and size.</p>
                </div>
                <div class="col-sm-4">
                    <p><i class="fa fa-play-circle text-primary fa-fw"></i> <strong>Execute</strong><br>
                    Click any button to open a confirmation dialog showing the exact command that will run. Press <em>Execute</em> to send it to the Raspberry Pi over SSH. The output is displayed in the same dialog.</p>
                </div>
                <div class="col-sm-4">
                    <p><i class="fa fa-cog text-muted fa-fw"></i> <strong>Edit &amp; delete</strong><br>
                    Use the small dropdown arrow next to each button to edit its settings or delete it. Commands run as the SSH user configured in <code>include/config.php</code>.</p>
                </div>
            </div>
            <p class="text-muted" style="margin-bottom:0; font-size:12px">
                <i class="fa fa-exclamation-triangle"></i>
                Commands execute with the SSH user's permissions. Only save commands you trust. Prefix with <code>sudo</code> where root access is needed.
            </p>
        </div>
    </div>

</div><!-- /.container -->

<!-- Add / Edit button modal -->
<div class="modal fade" id="button-modal" tabindex="-1" role="dialog" aria-labelledby="button-modal-label">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="button-modal-label">Command Button</h4>
            </div>
            <div class="modal-body">
                <form id="button-modal-form">
                    <input type="hidden" name="action"    value="submit_button">
                    <input type="hidden" name="button_id" id="modal-button-id" value="">

                    <div class="form-group">
                        <label for="modal-button-title">
                            <i class="fa fa-tag"></i> Button Title <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control" id="modal-button-title"
                               name="button_title" placeholder="e.g., Restart Apache"
                               required maxlength="100">
                    </div>

                    <div class="form-group">
                        <label for="modal-button-command">
                            <i class="fa fa-terminal"></i> Command <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control" id="modal-button-command"
                               name="button_command" placeholder="e.g., sudo systemctl restart apache2"
                               required>
                        <small class="help-block">Shell command executed over SSH when the button is clicked</small>
                    </div>

                    <div class="form-group">
                        <label for="modal-button-icon">
                            <i class="fa fa-picture-o"></i> Icon <small class="text-muted">(optional)</small>
                        </label>
                        <input type="text" class="form-control" id="modal-button-icon"
                               name="button_icon" placeholder="e.g., fa-refresh" maxlength="50">
                        <small class="help-block">
                            <a href="https://fontawesome.com/v4.7.0/icons/" target="_blank" rel="noopener">FontAwesome 4.7 icon name</a>
                        </small>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="modal-button-style">
                                    <i class="fa fa-paint-brush"></i> Style
                                </label>
                                <select class="form-control" id="modal-button-style" name="button_style">
                                    <option value="btn-default">Default (Gray)</option>
                                    <option value="btn-primary">Primary (Blue)</option>
                                    <option value="btn-success">Success (Green)</option>
                                    <option value="btn-info">Info (Light Blue)</option>
                                    <option value="btn-warning">Warning (Orange)</option>
                                    <option value="btn-danger">Danger (Red)</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="modal-button-size">
                                    <i class="fa fa-arrows-alt"></i> Size
                                </label>
                                <select class="form-control" id="modal-button-size" name="button_size">
                                    <option value="btn-lg">Large</option>
                                    <option value="btn-md" selected>Medium</option>
                                    <option value="btn-sm">Small</option>
                                    <option value="btn-xs">Extra Small</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-warning" role="alert">
                        <i class="fa fa-exclamation-triangle"></i>
                        Commands run with the SSH user's permissions. Only save commands you trust.
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="modal-save-btn" onclick="saveButton()">Save</button>
            </div>
        </div>
    </div>
</div>

<!-- Execute confirmation + output modal -->
<div class="modal fade" id="exec-modal" tabindex="-1" role="dialog" aria-labelledby="exec-modal-label">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="exec-modal-label">
                    <i class="fa fa-terminal"></i>
                    Execute: <span id="exec-modal-title"></span>
                </h4>
            </div>
            <div class="modal-body">
                <p class="text-muted" style="margin-bottom:4px">Command</p>
                <pre id="exec-modal-command" style="font-size:13px; word-break:break-all"></pre>

                <div id="exec-modal-output-wrap" style="display:none; margin-top:10px">
                    <p class="text-muted" style="margin-bottom:4px">Output</p>
                    <pre id="exec-modal-output" style="font-size:12px; max-height:300px; overflow-y:auto; word-break:break-all"></pre>
                </div>
            </div>
            <div class="modal-footer">
                <span id="exec-modal-footer-run">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="exec-run-btn" onclick="runExecCommand()">
                        <i class="fa fa-play"></i> Execute
                    </button>
                </span>
                <button type="button" id="exec-modal-footer-close" class="btn btn-default" data-dismiss="modal" style="display:none">Close</button>
            </div>
        </div>
    </div>
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
