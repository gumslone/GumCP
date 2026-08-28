<?php
declare(strict_types=1);

$active_page = 'scripts';

require_once('./include/init.php');

$page_title = 'Script Editor';
require_once('./include/header.php');
?>
<link href="./static/css/codemirror.min.css" rel="stylesheet">
<style>
    .CodeMirror { height: 480px; border: 1px solid #ddd; border-radius: 4px; font-size: 13px; }
    #script-sidebar .list-group-item { padding: 8px 12px; cursor: pointer; }
    #script-sidebar .list-group-item small { color: #999; }
    #script-output { max-height: 300px; overflow: auto; white-space: pre-wrap; word-break: break-word; }
</style>

<script>
    var CSRF_TOKEN = <?php echo json_encode($_SESSION['csrf_token']); ?>;
    var GUMCP_I18N = {
        scripts_unsaved: <?php echo json_encode(t('scripts.unsaved', 'Discard unsaved changes to this script?')); ?>
    };
</script>

<div class="page-header">
    <h1><i class="fa fa-code"></i> <?php echo htmlspecialchars(t('scripts.title', 'Script Editor'), ENT_QUOTES, 'UTF-8'); ?></h1>
</div>

<p class="text-muted">
    <?php echo htmlspecialchars(t('scripts.intro',
        'Write shell or Python scripts with syntax highlighting and run them over SSH. '
        . 'Scripts are stored in user_scripts/ (never served over the web). '
        . 'Start from a Raspberry Pi example, or pair a saved script with a Command Button or a cron job.'),
        ENT_QUOTES, 'UTF-8'); ?>
</p>

<div class="row">
    <div class="col-md-3" id="script-sidebar">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-files-o"></i> <?php echo htmlspecialchars(t('scripts.yours', 'Your scripts'), ENT_QUOTES, 'UTF-8'); ?>
            </div>
            <div class="list-group" id="script-list" style="margin-bottom:0">
                <span class="list-group-item text-muted"><?php echo htmlspecialchars(t('scripts.loading', 'Loading…'), ENT_QUOTES, 'UTF-8'); ?></span>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-magic"></i> <?php echo htmlspecialchars(t('scripts.examples', 'Raspberry Pi examples'), ENT_QUOTES, 'UTF-8'); ?>
            </div>
            <div class="list-group" id="template-list" style="margin-bottom:0"></div>
        </div>
    </div>

    <div class="col-md-9">
        <div class="form-inline" style="margin-bottom:10px">
            <div class="form-group">
                <input type="text" class="form-control" id="script-name" style="width:260px"
                       placeholder="my-script.sh" maxlength="64"
                       pattern="[A-Za-z0-9][A-Za-z0-9._-]*\.(sh|py|txt)">
            </div>
            <button type="button" class="btn btn-primary" id="script-save-btn" onclick="scriptSave()">
                <i class="fa fa-save"></i> <?php echo htmlspecialchars(t('scripts.save', 'Save'), ENT_QUOTES, 'UTF-8'); ?>
            </button>
            <button type="button" class="btn btn-success" id="script-run-btn" onclick="scriptRun()">
                <i class="fa fa-play"></i> <?php echo htmlspecialchars(t('scripts.run', 'Save & Run'), ENT_QUOTES, 'UTF-8'); ?>
            </button>
            <button type="button" class="btn btn-default" onclick="scriptNew()">
                <i class="fa fa-file-o"></i> <?php echo htmlspecialchars(t('scripts.new', 'New'), ENT_QUOTES, 'UTF-8'); ?>
            </button>
            <button type="button" class="btn btn-danger" id="script-delete-btn" onclick="scriptDelete()">
                <i class="fa fa-trash"></i> <?php echo htmlspecialchars(t('scripts.delete', 'Delete'), ENT_QUOTES, 'UTF-8'); ?>
            </button>
            <span id="script-status" class="text-muted" style="margin-left:8px"></span>
        </div>

        <textarea id="script-editor"></textarea>

        <div class="panel panel-default" id="script-output-wrap" style="display:none; margin-top:14px">
            <div class="panel-heading"><i class="fa fa-terminal"></i> <?php echo htmlspecialchars(t('scripts.output', 'Output'), ENT_QUOTES, 'UTF-8'); ?></div>
            <pre class="panel-body" id="script-output" style="margin:0; border:0; background:#1e1e1e; color:#e0e0e0"></pre>
        </div>

        <p class="text-muted" style="font-size:12px; margin-top:10px">
            <i class="fa fa-info-circle"></i>
            <?php echo htmlspecialchars(t('scripts.note',
                'Scripts run over SSH as the configured SSH user, exactly like the Actions page. '
                . '.txt files can be edited but not run. To run a saved script from a Command Button or cron, use:'),
                ENT_QUOTES, 'UTF-8'); ?>
            <code>bash <?php echo htmlspecialchars(__DIR__, ENT_QUOTES, 'UTF-8'); ?>/user_scripts/my-script.sh</code>
        </p>
    </div>
</div>

<script src="./static/js/codemirror.min.js"></script>
<script src="./static/js/codemirror-shell.min.js"></script>
<script src="./static/js/codemirror-python.min.js"></script>
<script>
var scriptEditor = CodeMirror.fromTextArea(document.getElementById('script-editor'), {
    lineNumbers: true,
    mode: 'shell',
    indentUnit: 4,
    viewportMargin: Infinity
});
</script>

<?php require_once('./include/footer.php'); ?>
