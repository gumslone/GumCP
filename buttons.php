<?php
declare(strict_types=1);

$active_page = 'buttons';

require_once('./include/init.php');

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

$page_title = 'Buttons';
require_once('./include/header.php');
?>

<script>
    var CSRF_TOKEN         = <?php echo json_encode($_SESSION['csrf_token']); ?>;
    var BUTTON_API_ENABLED = <?php echo json_encode(!empty($gumcp_modules['button_api']['module_active'])); ?>;
    </script>
    <div class="page-header">
        <h1><?php echo htmlspecialchars(t('btn.title', 'Command Buttons'), ENT_QUOTES, 'UTF-8'); ?></h1>
    </div>

    <button type="button" class="btn btn-success" onclick="addButton()">
        <i class="fa fa-plus"></i> <?php echo htmlspecialchars(t('btn.add', 'Add Command Button'), ENT_QUOTES, 'UTF-8'); ?>
    </button>

    <div class="panel panel-default" style="margin-top: 15px">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-terminal"></i> <?php echo htmlspecialchars(t('btn.title', 'Command Buttons'), ENT_QUOTES, 'UTF-8'); ?></h3>
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
                <div class="button-container" id="buttons-sortable">
                    <?php foreach ($buttons as $index => $button):
                        $style   = in_array($button['button_style'] ?? '', $allowed_styles) ? $button['button_style'] : 'btn-default';
                        $size    = in_array($button['button_size']  ?? '', $allowed_sizes)  ? $button['button_size']  : 'btn-md';
                        $title   = htmlspecialchars($button['button_title']   ?? 'Untitled', ENT_QUOTES, 'UTF-8');
                        $command = htmlspecialchars($button['button_command'] ?? '',         ENT_QUOTES, 'UTF-8');
                        $icon    = htmlspecialchars($button['button_icon']    ?? '',         ENT_QUOTES, 'UTF-8');
                        $idx     = (int) $index;
                        $direct  = !empty($button['button_direct']);
                        $has_api = !empty($button['button_hash']);
                        $onclick = $direct
                            ? 'executeDirectButton(' . $idx . ', this)'
                            : 'executeButton(' . $idx . ', ' . htmlspecialchars(json_encode($button['button_title'] ?? 'Untitled'), ENT_QUOTES, 'UTF-8') . ', ' . htmlspecialchars(json_encode($button['button_command'] ?? ''), ENT_QUOTES, 'UTF-8') . ')';
                    ?>
                        <div class="btn-draggable" data-idx="<?php echo $idx; ?>"
                             draggable="true">
                        <div class="btn-group" role="group">
                            <button
                                id="execute-btn-<?php echo $idx; ?>"
                                type="button"
                                class="btn <?php echo $style; ?> <?php echo $size; ?>"
                                onclick="<?php echo $onclick; ?>">
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
                                    <?php if ($has_api): ?>
                                    <li>
                                        <a href="#" onclick="editButton(<?php echo $idx; ?>); return false;"
                                           title="Has API URL — open Edit to copy it">
                                            <i class="fa fa-link"></i> API URL
                                        </a>
                                    </li>
                                    <?php endif; ?>
                                    <li role="separator" class="divider"></li>
                                    <li>
                                        <a href="#" onclick="deleteButton(<?php echo $idx; ?>); return false;" class="text-danger">
                                            <i class="fa fa-trash"></i> Delete
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <?php if ($direct): ?>
                        <div id="direct-output-<?php echo $idx; ?>" class="direct-output">
                            <pre></pre>
                        </div>
                        <?php endif; ?>
                        </div><!-- /.btn-draggable -->
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

                    <div class="form-group">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" id="modal-button-direct" name="button_direct" value="1">
                                <strong>Direct execution</strong> — run immediately on click, show output inline (no confirmation modal)
                            </label>
                        </div>
                    </div>

                    <div id="modal-api-section" style="display:none">
                        <hr style="margin:10px 0">
                        <label><i class="fa fa-link"></i> API URL <small class="text-muted">(GET to execute this button)</small></label>
                        <div class="input-group" style="margin-bottom:6px">
                            <input type="text" class="form-control input-sm" id="modal-api-url" readonly
                                   onclick="this.select()" style="font-family:monospace; font-size:11px">
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-default btn-sm" title="Copy URL"
                                        onclick="copyApiUrl()">
                                    <i class="fa fa-copy"></i>
                                </button>
                            </span>
                        </div>
                        <input type="hidden" id="modal-api-hash">
                        <button type="button" class="btn btn-xs btn-warning" onclick="regenerateHash()">
                            <i class="fa fa-refresh"></i> Regenerate hash
                        </button>
                        <span class="text-muted" style="font-size:11px; margin-left:6px">
                            Invalidates the old URL immediately.
                        </span>
                    </div>

                    <div class="alert alert-warning" style="margin-top:10px" role="alert">
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

<?php require_once('./include/footer.php'); ?>
