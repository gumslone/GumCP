<?php
declare(strict_types=1);

require_once('../../include/init.php');

if (empty($gumcp_modules['tehybug']['module_active'])) {
    http_response_code(404);
    exit();
}

if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// ── Database ──────────────────────────────────────────────────────────────────

$db = new SQLite3(__DIR__ . '/tehybug.sqlite');
$db->busyTimeout(3000);

$db->exec('CREATE TABLE IF NOT EXISTS tehybugs (
    bug_id          INTEGER PRIMARY KEY AUTOINCREMENT,
    bug_key         TEXT,
    bug_title       TEXT,
    bug_description TEXT,
    bug_details     TEXT,
    bug_type        TEXT,
    bug_settings    TEXT,
    bug_position    INTEGER,
    bug_last_active INTEGER,
    bug_time        INTEGER
)');

$db->exec('CREATE TABLE IF NOT EXISTS tehybug_data (
    data_id     INTEGER PRIMARY KEY AUTOINCREMENT,
    data_bug_id INTEGER,
    data_bug_key TEXT,
    data_details TEXT,
    data_time   INTEGER
)');

// ── CRUD helpers ──────────────────────────────────────────────────────────────

function db_create(SQLite3 $db, array $post): bool {
    $key = trim((string)($post['bug_key'] ?? ''));
    if ($key === '') return false;

    $check = $db->prepare('SELECT bug_id FROM tehybugs WHERE bug_key = :k LIMIT 1');
    $check->bindValue(':k', $key, SQLITE3_TEXT);
    $row = $check->execute()->fetchArray(SQLITE3_ASSOC);
    if (!empty($row['bug_id'])) return false;

    $settings = json_encode(['system' => (string)($post['bug_settings_system'] ?? 'metric')]);
    $ins = $db->prepare(
        'INSERT INTO tehybugs (bug_key, bug_title, bug_settings, bug_time)
         VALUES (:k, :t, :s, :ts)'
    );
    $ins->bindValue(':k',  $key,                                SQLITE3_TEXT);
    $ins->bindValue(':t',  (string)($post['bug_title'] ?? ''), SQLITE3_TEXT);
    $ins->bindValue(':s',  $settings,                           SQLITE3_TEXT);
    $ins->bindValue(':ts', time(),                              SQLITE3_INTEGER);
    $ins->execute();

    $last_id = $db->lastInsertRowID();
    $upd = $db->prepare('UPDATE tehybug_data SET data_bug_id = :id WHERE data_bug_key = :k');
    $upd->bindValue(':id', (int)$last_id, SQLITE3_INTEGER);
    $upd->bindValue(':k',  $key,          SQLITE3_TEXT);
    $upd->execute();

    return true;
}

function db_update(SQLite3 $db, array $post): bool {
    $id = (int)($post['bug_id'] ?? 0);
    if ($id <= 0) return false;

    $sel = $db->prepare('SELECT bug_settings FROM tehybugs WHERE bug_id = :id LIMIT 1');
    $sel->bindValue(':id', $id, SQLITE3_INTEGER);
    $row = $sel->execute()->fetchArray(SQLITE3_ASSOC);
    if (empty($row)) return false;

    $settings = (array)json_decode($row['bug_settings'] ?? '{}', true);
    $settings['system'] = (string)($post['bug_settings_system'] ?? 'metric');

    $upd = $db->prepare(
        'UPDATE tehybugs
         SET bug_title = :t, bug_description = :d, bug_settings = :s, bug_time = :ts
         WHERE bug_id = :id'
    );
    $upd->bindValue(':t',  (string)($post['bug_title']       ?? ''), SQLITE3_TEXT);
    $upd->bindValue(':d',  (string)($post['bug_description'] ?? ''), SQLITE3_TEXT);
    $upd->bindValue(':s',  json_encode($settings),                    SQLITE3_TEXT);
    $upd->bindValue(':ts', time(),                                     SQLITE3_INTEGER);
    $upd->bindValue(':id', $id,                                        SQLITE3_INTEGER);
    $upd->execute();
    return true;
}

function db_delete(SQLite3 $db, int $id): bool {
    if ($id <= 0) return false;
    $db->exec('DELETE FROM tehybugs     WHERE bug_id      = ' . $id);
    $db->exec('DELETE FROM tehybug_data WHERE data_bug_id = ' . $id);
    return true;
}

function db_order(SQLite3 $db, string $order_csv): bool {
    $ids = explode(',', $order_csv);
    foreach ($ids as $pos => $raw) {
        $id = (int)str_replace('bug_id_', '', trim($raw));
        if ($id > 0) {
            $db->exec('UPDATE tehybugs SET bug_position = ' . $pos . ' WHERE bug_id = ' . $id);
        }
    }
    return true;
}

// ── AJAX actions (JSON responses) ─────────────────────────────────────────────

$action = (string)($_REQUEST['action'] ?? '');

if ($action !== '') {
    header('Content-Type: application/json');

    // CSRF guard on POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $token = (string)($_POST['csrf_token'] ?? '');
        if (!isset($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $token)) {
            http_response_code(403);
            echo json_encode(['error' => 'CSRF token mismatch']);
            exit();
        }
    }

    $ok = false;
    switch ($action) {
        case 'add_tehybug':    $ok = db_create($db, $_POST); break;
        case 'update_tehybug': $ok = db_update($db, $_POST); break;
        case 'delete_tehybug': $ok = db_delete($db, (int)($_POST['bug_id'] ?? 0)); break;
        case 'order_tehybugs': $ok = db_order($db,  (string)($_POST['order'] ?? '')); break;
    }

    echo json_encode($ok ? ['success' => 1] : ['error' => 1]);
    exit();
}

// ── Load all bugs for page render ─────────────────────────────────────────────

$tehybugs     = [];
$tehybugs_map = [];

$result = $db->query('SELECT * FROM tehybugs ORDER BY bug_position ASC LIMIT 100');
while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
    $row['bug_settings'] = json_decode($row['bug_settings'] ?? '{}', true) ?? [];
    $tehybugs[]                      = $row;
    $tehybugs_map[$row['bug_id']]    = $row;
}

$csrf     = htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8');
$base_url = 'http://' . htmlspecialchars($_SERVER['SERVER_ADDR'], ENT_QUOTES, 'UTF-8')
          . htmlspecialchars(dirname($_SERVER['SCRIPT_NAME']), ENT_QUOTES, 'UTF-8');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#ffffff">
    <title>TeHyBug — Temperature &amp; Humidity Tracker</title>
    <link href="../../static/css.php" rel="stylesheet">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <script src="../../static/js.php"></script>
    <script src="//code.jquery.com/ui/1.12.1/jquery-ui.min.js"
            integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <style>
    .ui-datepicker { background:#fff; border:1px solid #66afe9; border-radius:4px;
                     box-shadow:0 0 8px rgba(102,175,233,.6); display:none; margin-top:10px; padding:10px; width:240px; }
    .ui-datepicker a, .ui-datepicker a:hover { text-decoration:none; }
    .ui-datepicker a:hover, .ui-datepicker td:hover a { color:#2a6496; transition:color .1s; }
    .ui-datepicker .ui-datepicker-header { margin-bottom:4px; text-align:center; }
    .ui-datepicker .ui-datepicker-title { font-weight:700; }
    .ui-datepicker .ui-datepicker-prev,
    .ui-datepicker .ui-datepicker-next { cursor:default; font-family:'Glyphicons Halflings';
                                         -webkit-font-smoothing:antialiased; font-weight:normal;
                                         height:20px; line-height:1; margin-top:2px; width:30px; }
    .ui-datepicker .ui-datepicker-prev { float:left; text-align:left; }
    .ui-datepicker .ui-datepicker-next { float:right; text-align:right; }
    .ui-datepicker .ui-datepicker-prev:before { content:"\e079"; }
    .ui-datepicker .ui-datepicker-next:before { content:"\e080"; }
    .ui-datepicker .ui-icon { display:none; }
    .ui-datepicker .ui-datepicker-calendar { table-layout:fixed; width:100%; }
    .ui-datepicker .ui-datepicker-calendar th,
    .ui-datepicker .ui-datepicker-calendar td { text-align:center; padding:4px 0; }
    .ui-datepicker .ui-datepicker-calendar td { border-radius:4px; transition:background-color .1s, color .1s; }
    .ui-datepicker .ui-datepicker-calendar td:hover { background:#eee; cursor:pointer; }
    .ui-datepicker .ui-datepicker-calendar td a { text-decoration:none; }
    .ui-datepicker .ui-datepicker-current-day { background:#4289cc; }
    .ui-datepicker .ui-datepicker-current-day a { color:#fff; }
    .ui-datepicker .ui-datepicker-calendar .ui-datepicker-unselectable:hover { background:#fff; cursor:default; }
    </style>
</head>
<body>

<div class="container">
    <div class="row">

        <!-- Sidebar -->
        <div class="hidden-xs col-sm-3">
            <div style="margin-bottom:15px"></div>
            <div class="list-group">
                <a href="#" class="list-group-item" onclick="openAddDialog(); return false;">
                    <i class="fa fa-plus fa-fw"></i> Add a TeHyBug
                </a>
                <a href="#" class="list-group-item" onclick="openConfigDialog(); return false;">
                    <i class="fa fa-question-circle fa-fw"></i> How to configure
                </a>
            </div>
            <div class="well well-sm">
                Order your TeHyBug from:<br>
                <a href="https://www.tindie.com/stores/gumslone/" target="_blank" rel="noopener">
                    <img src="https://d2ss6ovg47m0r5.cloudfront.net/badges/tindie-larges.png"
                         alt="I sell on Tindie" width="200" height="104">
                </a><br>
                or <a href="http://www.tehybug.com" target="_blank" rel="noopener">www.tehybug.com</a>
            </div>
        </div>

        <!-- Bug panels -->
        <div class="col-md-9 col-xs-12 col-sm-9">
            <?php if (empty($tehybugs)): ?>
                <div class="alert alert-info">
                    <i class="fa fa-info-circle"></i>
                    No TeHyBugs yet. Click <strong>Add a TeHyBug</strong> to get started.
                </div>
            <?php else: ?>
                <div class="sortable">
                <?php foreach ($tehybugs as $bug):
                    $bug_id    = (int)$bug['bug_id'];
                    $bug_title = htmlspecialchars($bug['bug_title'] ?? '', ENT_QUOTES, 'UTF-8');
                    $bug_sys   = htmlspecialchars($bug['bug_settings']['system'] ?? 'metric', ENT_QUOTES, 'UTF-8');
                    $today     = htmlspecialchars(date('Y-m-d'), ENT_QUOTES, 'UTF-8');
                ?>
                    <div class="panel panel-default panel-sortable"
                         id="bug_id_<?php echo $bug_id; ?>"
                         data-bug-id="<?php echo $bug_id; ?>">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                <strong><?php echo $bug_title; ?></strong>
                                <span class="pull-right">
                                    <input type="text" id="stats_date_<?php echo $bug_id; ?>"
                                           class="form-control input-sm stats_date"
                                           style="width:110px; display:inline-block;"
                                           value="<?php echo $today; ?>">
                                    <button type="button"
                                            class="btn btn-default btn-sm"
                                            onclick="loadChart(<?php echo $bug_id; ?>)">
                                        <i class="fa fa-check"></i>
                                    </button>
                                    <button type="button"
                                            class="btn btn-default btn-sm"
                                            onclick="openSettingsDialog(<?php echo $bug_id; ?>, <?php echo htmlspecialchars(json_encode($bug['bug_title']), ENT_QUOTES, 'UTF-8'); ?>, <?php echo htmlspecialchars(json_encode($bug_sys), ENT_QUOTES, 'UTF-8'); ?>)">
                                        <i class="fa fa-cog"></i>
                                    </button>
                                </span>
                            </h3>
                        </div>
                        <div class="row last_data"></div>
                        <div id="chart_bug_id_<?php echo $bug_id; ?>"
                             class="chart" style="height:350px; width:100%;"></div>
                    </div>
                <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

    </div>
</div>

<!-- How-to-configure info (hidden, shown in modal) -->
<div id="how_to_configure" style="display:none">
    <p>Enter the following URL into your TeHyBug's configuration:</p>
    <p><strong>s1 / s2 (temperature + humidity):</strong></p>
    <div class="well well-sm"><?php echo $base_url; ?>/track.php?t=%temp%&amp;h=%humi%&amp;chipid=%chipid%&amp;sensor=%sensor%</div>
    <p><strong>s3 (temperature + pressure):</strong></p>
    <div class="well well-sm"><?php echo $base_url; ?>/track.php?t=%temp%&amp;p=%qfe%&amp;chipid=%chipid%&amp;sensor=%sensor%</div>
    <p><strong>s4 (temperature only):</strong></p>
    <div class="well well-sm"><?php echo $base_url; ?>/track.php?t=%temp%&amp;chipid=%chipid%&amp;sensor=%sensor%</div>
    <p><strong>s5 (temperature + humidity + pressure):</strong></p>
    <div class="well well-sm"><?php echo $base_url; ?>/track.php?t=%temp%&amp;h=%humi%&amp;p=%qfe%&amp;chipid=%chipid%&amp;sensor=%sensor%</div>
    <p class="text-muted">Set a static IP for your Raspberry Pi in your router to keep the URL stable.</p>
</div>

<!-- Add TeHyBug modal -->
<div class="modal fade" id="add-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                <h4 class="modal-title"><i class="fa fa-plus"></i> Add a TeHyBug</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>TeHyBug Key</label>
                    <input type="text" class="form-control" id="add-key"
                           placeholder="xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx">
                </div>
                <div class="form-group">
                    <label>Title (e.g. room name)</label>
                    <input type="text" class="form-control" id="add-title" placeholder="Kitchen">
                </div>
                <div class="form-group">
                    <label>Unit system</label>
                    <div class="radio"><label>
                        <input type="radio" name="add-system" value="metric" checked> Metric (°C / hPa)
                    </label></div>
                    <div class="radio"><label>
                        <input type="radio" name="add-system" value="imperial"> Imperial (°F / inHg)
                    </label></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="add-submit-btn" onclick="submitAdd()">
                    <i class="fa fa-plus"></i> Add
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Settings modal -->
<div class="modal fade" id="settings-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                <h4 class="modal-title"><i class="fa fa-cog"></i> TeHyBug Settings</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="settings-bug-id">
                <div class="form-group">
                    <label>Title</label>
                    <input type="text" class="form-control" id="settings-title">
                </div>
                <div class="form-group">
                    <label>Unit system</label>
                    <div class="radio"><label>
                        <input type="radio" name="settings-system" value="metric"> Metric (°C / hPa)
                    </label></div>
                    <div class="radio"><label>
                        <input type="radio" name="settings-system" value="imperial"> Imperial (°F / inHg)
                    </label></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger pull-left" id="settings-delete-btn"
                        onclick="deleteBug()">
                    <i class="fa fa-trash"></i> Delete
                </button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="settings-save-btn"
                        onclick="submitSettings()">
                    <i class="fa fa-save"></i> Save
                </button>
            </div>
        </div>
    </div>
</div>

<script>
var CSRF_TOKEN = <?php echo json_encode($_SESSION['csrf_token']); ?>;
var tehyBugs  = <?php echo json_encode($tehybugs_map); ?>;

// ── Chart ─────────────────────────────────────────────────────────────────────
function loadChart(bugId) {
    var date = $('#stats_date_' + bugId).val() || '<?php echo date('Y-m-d'); ?>';
    var bug  = tehyBugs[bugId];
    var imperial = bug && bug.bug_settings && bug.bug_settings.system === 'imperial';

    $.getJSON('./chart_data.php?act=by_date&tehy_bug_id=' + bugId + '&date=' + date, function(json) {
        var times = json[0] || [], temps = json[1] || [], humis = json[2] || [], press = json[3] || [];

        var deg    = imperial ? '°F'   : '°C';
        var p_unit = imperial ? 'inHg' : 'hPa';

        if (imperial) {
            temps = temps.map(function(v) { return v !== null ? Math.round((v * 1.8 + 32) * 100) / 100 : null; });
            press = press.map(function(v) { return v !== null ? Math.round((v / 33.86389) * 100) / 100 : null; });
        }

        var series = [];
        if (temps.length) series.push({ name: 'Temperature', yAxis: 0, data: temps });
        if (humis.length) series.push({ name: 'Humidity',    yAxis: 1, data: humis });
        if (press.length) series.push({ name: 'Pressure',    yAxis: 2, data: press });

        new Highcharts.Chart({
            chart: { renderTo: 'chart_bug_id_' + bugId, zoomType: 'x',
                     marginRight: 45, marginTop: 30, marginBottom: 90 },
            colors: ['#AA4643', '#3b6290', '#728a41'],
            credits: { enabled: true },
            title:  { text: null },
            xAxis:  { categories: times, labels: { rotation: -45, align: 'right', y: 8 } },
            yAxis: [
                { min: -20, title: { text: deg } },
                { min: -20, title: { text: '%' }, opposite: true },
                { min: -20, title: { text: p_unit }, labels: { enabled: false }, opposite: true }
            ],
            tooltip: {
                shared: true,
                crosshairs: { width: 30, color: '#eee', zIndex: 0.5 },
                formatter: function() {
                    var s = '<b>' + this.x + '</b>';
                    $.each(this.points, function(i, p) {
                        s += '<br><span style="color:' + p.series.color + '">' + p.series.name + '</span>: ' + p.y;
                        if (p.series.name === 'Temperature') s += ' ' + deg;
                        if (p.series.name === 'Humidity')    s += ' %';
                        if (p.series.name === 'Pressure')    s += ' ' + p_unit;
                    });
                    return s;
                }
            },
            legend: { align: 'right', verticalAlign: 'top', y: -15, floating: false, borderWidth: 0 },
            navigation: { buttonOptions: { verticalAlign: 'bottom', y: 0 } },
            series: series
        });

        // Last-reading summary
        if (times.length) {
            var cols = [true, humis.length > 0, press.length > 0].filter(Boolean).length;
            var w = cols >= 3 ? 3 : 4;
            var html = '<div class="col-lg-' + w + '"><div style="padding:10px"><b style="font-size:1.2em">Last measurement</b><br>' + times[times.length - 1] + '</div></div>';

            var lt = temps[temps.length - 1];
            var tIcon = lt < 18 ? 'temperature_low' : (lt > 24 ? 'temperature_high' : 'temperature_middle');
            html += '<div class="col-lg-' + w + '"><div style="padding:10px"><img src="./static/images/' + tIcon + '.svg" style="height:28px;vertical-align:middle"> <span style="font-size:1.4em">' + lt + ' ' + deg + '</span></div></div>';

            if (humis.length) {
                var lh = humis[humis.length - 1];
                var hIcon = lh < 30 ? 'humidity_low' : (lh > 50 ? 'humidity_high' : 'humidity_middle');
                html += '<div class="col-lg-' + w + '"><div style="padding:10px"><img src="./static/images/' + hIcon + '.svg" style="height:28px;vertical-align:middle"> <span style="font-size:1.4em">' + lh + ' %</span></div></div>';
            }
            if (press.length) {
                var lp = press[press.length - 1];
                html += '<div class="col-lg-' + w + '"><div style="padding:10px"><img src="./static/images/pressure.svg" style="height:28px;vertical-align:middle"> <span style="font-size:1.4em">' + lp + ' ' + p_unit + '</span></div></div>';
            }
            $('#bug_id_' + bugId + ' .last_data').html(html);
        }
    });
}

// ── Add dialog ────────────────────────────────────────────────────────────────
function openAddDialog() {
    $('#add-key').val('');
    $('#add-title').val('');
    $('input[name=add-system][value=metric]').prop('checked', true);
    $('#add-submit-btn').prop('disabled', false);
    $('#add-modal').modal('show');
}

function submitAdd() {
    $('#add-submit-btn').prop('disabled', true);
    $.ajax({
        type: 'POST', url: './index.php', dataType: 'json',
        data: {
            action: 'add_tehybug',
            bug_key: $('#add-key').val(),
            bug_title: $('#add-title').val(),
            bug_settings_system: $('input[name=add-system]:checked').val(),
            csrf_token: CSRF_TOKEN
        },
        success: function() { location.reload(); },
        error:   function() { alert('Error adding TeHyBug'); $('#add-submit-btn').prop('disabled', false); }
    });
}

// ── Settings dialog ───────────────────────────────────────────────────────────
function openSettingsDialog(bugId, title, system) {
    $('#settings-bug-id').val(bugId);
    $('#settings-title').val(title);
    $('input[name=settings-system][value=' + (system || 'metric') + ']').prop('checked', true);
    $('#settings-save-btn, #settings-delete-btn').prop('disabled', false);
    $('#settings-modal').modal('show');
}

function submitSettings() {
    $('#settings-save-btn').prop('disabled', true);
    $.ajax({
        type: 'POST', url: './index.php', dataType: 'json',
        data: {
            action: 'update_tehybug',
            bug_id: $('#settings-bug-id').val(),
            bug_title: $('#settings-title').val(),
            bug_settings_system: $('input[name=settings-system]:checked').val(),
            csrf_token: CSRF_TOKEN
        },
        success: function() { location.reload(); },
        error:   function() { alert('Error saving settings'); $('#settings-save-btn').prop('disabled', false); }
    });
}

function deleteBug() {
    var id    = $('#settings-bug-id').val();
    var title = $('#settings-title').val();
    if (!confirm('Delete "' + title + '" and all its data?')) return;
    $('#settings-delete-btn').prop('disabled', true);
    $.ajax({
        type: 'POST', url: './index.php', dataType: 'json',
        data: { action: 'delete_tehybug', bug_id: id, csrf_token: CSRF_TOKEN },
        success: function() { $('#bug_id_' + id).closest('.panel').parent().remove(); $('#settings-modal').modal('hide'); },
        error:   function() { alert('Error deleting TeHyBug'); $('#settings-delete-btn').prop('disabled', false); }
    });
}

// ── Config dialog ─────────────────────────────────────────────────────────────
function openConfigDialog() {
    var html = $('#how_to_configure').html();
    var $m = $('<div class="modal fade" tabindex="-1" role="dialog">'
        + '<div class="modal-dialog modal-lg" role="document"><div class="modal-content">'
        + '<div class="modal-header"><button class="close" data-dismiss="modal">&times;</button>'
        + '<h4 class="modal-title"><i class="fa fa-question-circle"></i> How to configure a TeHyBug</h4></div>'
        + '<div class="modal-body">' + html + '</div>'
        + '<div class="modal-footer"><button class="btn btn-default" data-dismiss="modal">Close</button></div>'
        + '</div></div></div>');
    $('body').append($m);
    $m.modal('show').on('hidden.bs.modal', function() { $m.remove(); });
}

// ── Init ──────────────────────────────────────────────────────────────────────
$(document).ready(function() {
    // Load charts for all bugs
    <?php foreach ($tehybugs as $bug): ?>
    loadChart(<?php echo (int)$bug['bug_id']; ?>);
    <?php endforeach; ?>

    // Date picker
    $('.stats_date').datepicker({
        maxDate: 0,
        dateFormat: 'yy-mm-dd',
        changeMonth: true,
        changeYear: true,
        onSelect: function(date) {
            var id = $(this).attr('id').replace('stats_date_', '');
            loadChart(parseInt(id, 10));
        }
    });

    // Fix jQuery UI "Go Today" also selecting the date
    if ($.datepicker._gotoTodayOriginal === undefined) {
        $.datepicker._gotoTodayOriginal = $.datepicker._gotoToday;
        $.datepicker._gotoToday = function(id) {
            $.datepicker._gotoTodayOriginal.apply(this, [id]);
            $.datepicker._selectDate.apply(this, [id]);
        };
    }

    // Sortable panels
    $('.sortable').sortable({
        items: '.panel-sortable',
        cancel: '.chart,.stats_date',
        update: function() {
            var order = $(this).sortable('toArray').toString();
            $.post('./index.php', { action: 'order_tehybugs', order: order, csrf_token: CSRF_TOKEN });
        }
    });
});
</script>

</body>
</html>
