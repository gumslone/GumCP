<?php
declare(strict_types=1);

$active_page = 'docker';

require_once('./include/init.php');

if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$page_title = 'Docker';
require_once('./include/header.php');
?>

<script>var CSRF_TOKEN = <?php echo json_encode($_SESSION['csrf_token']); ?>;</script>
    <div class="page-header">
        <h1><i class="fa fa-cube"></i> <?php echo htmlspecialchars(t('nav.docker', 'Docker'), ENT_QUOTES, 'UTF-8'); ?>
            <a href="#" onclick="dockerLoad(); return false;" class="btn btn-default btn-sm pull-right">
                <i class="fa fa-refresh"></i> <?php echo htmlspecialchars(t('common.refresh', 'Refresh'), ENT_QUOTES, 'UTF-8'); ?>
            </a>
        </h1>
    </div>

    <div class="alert alert-warning" id="docker-unavailable" style="display:none">
        <i class="fa fa-exclamation-triangle"></i> <span id="docker-unavailable-text"></span>
    </div>

    <!-- Containers -->
    <div class="panel panel-default" id="docker-panel">
        <div class="panel-heading"><i class="fa fa-cubes"></i> <?php echo htmlspecialchars(t('dock.containers', 'Containers'), ENT_QUOTES, 'UTF-8'); ?></div>
        <div class="table-responsive">
            <table class="table table-condensed table-striped" style="margin-bottom:0">
                <thead>
                    <tr><th style="padding-left:15px">Name</th><th>Image</th><th>State</th>
                        <th>Status</th><th>Ports</th><th style="text-align:right; padding-right:15px">Actions</th></tr>
                </thead>
                <tbody id="docker-tbody">
                    <tr><td colspan="6" class="text-muted" style="padding-left:15px">Loading…</td></tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Images -->
    <div class="panel panel-default">
        <div class="panel-heading">
            <a data-toggle="collapse" href="#docker-images" style="text-decoration:none; color:inherit; display:block">
                <i class="fa fa-archive"></i> <?php echo htmlspecialchars(t('dock.images', 'Images'), ENT_QUOTES, 'UTF-8'); ?> <i class="fa fa-caret-down pull-right"></i>
            </a>
        </div>
        <div id="docker-images" class="collapse">
            <table class="table table-condensed table-striped" style="margin-bottom:0">
                <thead>
                    <tr><th style="padding-left:15px">Repository</th><th>Tag</th><th>ID</th><th>Size</th></tr>
                </thead>
                <tbody id="docker-images-tbody">
                    <tr><td colspan="4" class="text-muted" style="padding-left:15px">Expand to load…</td></tr>
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- Logs modal -->
<div class="modal fade" id="docker-logs-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                <h4 class="modal-title"><i class="fa fa-file-text-o"></i> <?php echo htmlspecialchars(t('dock.logs', 'Logs'), ENT_QUOTES, 'UTF-8'); ?>: <span id="docker-logs-name"></span></h4>
            </div>
            <div class="modal-body">
                <pre id="docker-logs-output" style="max-height:480px; overflow:auto; font-size:12px">Loading…</pre>
            </div>
        </div>
    </div>
</div>

<script>
function esc(s) { return $('<div>').text(s == null ? '' : s).html(); }

function dockerStateLabel(state) {
    var s = (state || '').toLowerCase();
    if (s === 'running') return 'label-success';
    if (s === 'paused')  return 'label-warning';
    if (s === 'exited' || s === 'dead') return 'label-default';
    return 'label-info';
}

function dockerLoad() {
    $.ajax({
        type: 'POST', url: 'ajax.php', dataType: 'json',
        data: { action: 'docker_ps', csrf_token: CSRF_TOKEN },
        success: function(d) {
            if (d && d.type === 'error') {
                $('#docker-unavailable-text').text(d.message || 'Docker error');
                $('#docker-unavailable').show(); $('#docker-panel').hide();
                return;
            }
            if (d && d.available === false) {
                $('#docker-unavailable-text').text(d.reason || 'Docker is not available.');
                $('#docker-unavailable').show(); $('#docker-panel').hide();
                return;
            }
            $('#docker-unavailable').hide(); $('#docker-panel').show();
            var list = (d && d.containers) || [];
            if (!list.length) {
                $('#docker-tbody').html('<tr><td colspan="6" class="text-muted" style="padding-left:15px">No containers.</td></tr>');
                return;
            }
            var html = '';
            list.forEach(function(c) {
                var running = (c.state || '').toLowerCase() === 'running';
                var paused  = (c.state || '').toLowerCase() === 'paused';
                var btns = '';
                if (running || paused) {
                    btns += dockerBtn(c.id, c.name, 'stop', 'btn-warning', 'fa-stop', 'Stop');
                    btns += dockerBtn(c.id, c.name, 'restart', 'btn-info', 'fa-refresh', 'Restart');
                    btns += paused
                        ? dockerBtn(c.id, c.name, 'unpause', 'btn-default', 'fa-play-circle', 'Unpause')
                        : dockerBtn(c.id, c.name, 'pause', 'btn-default', 'fa-pause', 'Pause');
                } else {
                    btns += dockerBtn(c.id, c.name, 'start', 'btn-success', 'fa-play', 'Start');
                }
                btns += '<button class="btn btn-xs btn-default" onclick="dockerLogs(\'' + esc(c.id) + '\',\'' + esc(c.name) + '\')" title="Logs"><i class="fa fa-file-text-o"></i></button> ';
                btns += dockerBtn(c.id, c.name, 'remove', 'btn-danger', 'fa-trash', 'Remove');
                html += '<tr>'
                    + '<td style="padding-left:15px"><strong>' + esc(c.name) + '</strong></td>'
                    + '<td class="text-muted">' + esc(c.image) + '</td>'
                    + '<td><span class="label ' + dockerStateLabel(c.state) + '">' + esc(c.state) + '</span></td>'
                    + '<td class="text-muted" style="font-size:12px">' + esc(c.status) + '</td>'
                    + '<td class="text-muted" style="font-size:12px">' + esc(c.ports) + '</td>'
                    + '<td style="text-align:right; padding-right:15px; white-space:nowrap">' + btns + '</td>'
                    + '</tr>';
            });
            $('#docker-tbody').html(html);
        },
        error: function() {
            $('#docker-unavailable-text').text('Request failed — check SSH settings.');
            $('#docker-unavailable').show();
        }
    });
}

function dockerBtn(id, name, act, cls, icon, label) {
    return '<button class="btn btn-xs ' + cls + '" title="' + label + '" '
         + 'onclick="dockerAction(\'' + esc(id) + '\',\'' + esc(name) + '\',\'' + act + '\')">'
         + '<i class="fa ' + icon + '"></i></button> ';
}

function dockerAction(id, name, act) {
    if (act === 'remove' && !confirm('Remove container "' + name + '"? This cannot be undone.')) return;
    if (act === 'stop'   && !confirm('Stop container "' + name + '"?')) return;
    $.ajax({
        type: 'POST', url: 'ajax.php', dataType: 'json',
        data: { action: 'docker_action', id: id, act: act, csrf_token: CSRF_TOKEN },
        success: function(d) {
            if (d && d.type === 'error') alert(d.message || 'Action failed');
            dockerLoad();
        },
        error: function() { alert('Request failed — check SSH settings.'); }
    });
}

function dockerLogs(id, name) {
    $('#docker-logs-name').text(name);
    $('#docker-logs-output').text('Loading…');
    $('#docker-logs-modal').modal('show');
    $.ajax({
        type: 'POST', url: 'ajax.php', dataType: 'json',
        data: { action: 'docker_logs', id: id, lines: 300, csrf_token: CSRF_TOKEN },
        success: function(d) {
            $('#docker-logs-output').text((d && (d.output || d.message)) || '(no output)');
        },
        error: function() { $('#docker-logs-output').text('Request failed — check SSH settings.'); }
    });
}

function dockerLoadImages() {
    $.ajax({
        type: 'POST', url: 'ajax.php', dataType: 'json',
        data: { action: 'docker_images', csrf_token: CSRF_TOKEN },
        success: function(d) {
            var imgs = (d && d.images) || [];
            if (!imgs.length) {
                $('#docker-images-tbody').html('<tr><td colspan="4" class="text-muted" style="padding-left:15px">No images.</td></tr>');
                return;
            }
            var html = '';
            imgs.forEach(function(im) {
                html += '<tr><td style="padding-left:15px">' + esc(im.repo) + '</td>'
                     + '<td>' + esc(im.tag) + '</td><td class="text-muted">' + esc(im.id) + '</td>'
                     + '<td>' + esc(im.size) + '</td></tr>';
            });
            $('#docker-images-tbody').html(html);
        }
    });
}

$(function() {
    dockerLoad();
    $('#docker-images').one('shown.bs.collapse', dockerLoadImages);
});
</script>

<?php require_once('./include/footer.php'); ?>
