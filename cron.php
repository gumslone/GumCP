<?php
declare(strict_types=1);

$active_page = 'cron';

require_once('./include/init.php');

$page_title = 'Cron Jobs';
require_once('./include/header.php');
?>

<script>
    var CSRF_TOKEN = <?php echo json_encode($_SESSION['csrf_token']); ?>;
    var T_CRON_NONE    = <?php echo json_encode(t('cron.none', 'No cron jobs for this user.')); ?>;
    var T_CRON_CUSTOM  = <?php echo json_encode(t('cron.custom', 'Custom schedule')); ?>;
    var T_CRON_INVALID = <?php echo json_encode(t('cron.invalid', 'Invalid schedule expression.')); ?>;
    </script>
    <div class="page-header">
        <h1><i class="fa fa-clock-o"></i> <?php echo htmlspecialchars(t('cron.title', 'Cron Jobs'), ENT_QUOTES, 'UTF-8'); ?></h1>
    </div>

    <!-- Add new job -->
    <div class="panel panel-success">
        <div class="panel-heading"><i class="fa fa-plus"></i> <?php echo htmlspecialchars(t('cron.add', 'Add Cron Job'), ENT_QUOTES, 'UTF-8'); ?></div>
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-4 form-group">
                    <label for="cron-preset"><?php echo htmlspecialchars(t('cron.when', 'When'), ENT_QUOTES, 'UTF-8'); ?></label>
                    <select class="form-control" id="cron-preset" onchange="cronPreset()">
                        <option value="">Custom…</option>
                        <option value="* * * * *">Every minute</option>
                        <option value="*/5 * * * *">Every 5 minutes</option>
                        <option value="*/15 * * * *">Every 15 minutes</option>
                        <option value="*/30 * * * *">Every 30 minutes</option>
                        <option value="0 * * * *">Every hour</option>
                        <option value="@daily">Every day (midnight)</option>
                        <option value="0 4 * * *">Every day at 04:00</option>
                        <option value="0 0 * * 0">Every week (Sunday)</option>
                        <option value="0 0 1 * *">Every month (1st)</option>
                        <option value="@reboot">At boot</option>
                    </select>
                </div>
                <div class="col-sm-3 form-group">
                    <label for="cron-schedule"><?php echo htmlspecialchars(t('cron.expr', 'Schedule expression'), ENT_QUOTES, 'UTF-8'); ?></label>
                    <input type="text" class="form-control" id="cron-schedule"
                           placeholder="0 4 * * *" oninput="cronDescribe()">
                </div>
                <div class="col-sm-5 form-group">
                    <label for="cron-command"><?php echo htmlspecialchars(t('cron.command', 'Command to run'), ENT_QUOTES, 'UTF-8'); ?></label>
                    <input type="text" class="form-control" id="cron-command"
                           placeholder="/usr/bin/backup.sh">
                </div>
            </div>
            <p id="cron-desc" class="text-info" style="margin:0 0 8px"></p>
            <button class="btn btn-success" id="cron-add-btn" onclick="cronAdd()">
                <i class="fa fa-plus"></i> <?php echo htmlspecialchars(t('cron.add', 'Add Cron Job'), ENT_QUOTES, 'UTF-8'); ?>
            </button>
            <small class="help-block">
                Pick a preset or type a <code>minute hour day month weekday</code> expression.
                Need something specific? <a href="https://crontab.guru/" target="_blank" rel="noopener">crontab.guru</a> helps.
            </small>
        </div>
    </div>

    <!-- User crontab -->
    <div class="panel panel-default">
        <div class="panel-heading"><i class="fa fa-user"></i> <?php echo htmlspecialchars(t('cron.user_crontab', 'User Crontab'), ENT_QUOTES, 'UTF-8'); ?></div>
        <table class="table table-condensed" style="margin-bottom:0">
            <tbody id="cron-user-tbody">
                <tr><td class="text-muted" style="padding-left:15px">Loading…</td></tr>
            </tbody>
        </table>
    </div>

    <!-- System crontab (read-only) -->
    <div class="panel panel-default">
        <div class="panel-heading"><i class="fa fa-cogs"></i> /etc/crontab <small>(read-only)</small></div>
        <div class="panel-body">
            <pre id="cron-system" style="margin:0; max-height:300px; overflow:auto">Loading…</pre>
        </div>
    </div>

</div>

<script>
function esc(s) { return $('<div>').text(s == null ? '' : s).html(); }

/* ── schedule helpers ── */
function cronPreset() {
    var v = $('#cron-preset').val();
    if (v !== '') { $('#cron-schedule').val(v); }
    cronDescribe();
}

function pad2(n) { return (n < 10 ? '0' : '') + n; }

function describeCron(expr) {
    expr = (expr || '').trim();
    if (expr === '') return '';
    var keywords = {
        '@reboot':  'at every system boot',
        '@hourly':  'every hour, on the hour',
        '@daily':   'every day at midnight',
        '@midnight':'every day at midnight',
        '@weekly':  'every week (Sunday at midnight)',
        '@monthly': 'every month (1st at midnight)',
        '@yearly':  'every year (Jan 1 at midnight)',
        '@annually':'every year (Jan 1 at midnight)'
    };
    if (keywords[expr]) return keywords[expr];

    var p = expr.split(/\s+/);
    if (p.length < 5) return null; // incomplete
    var min = p[0], hr = p[1], dom = p[2], mon = p[3], dow = p[4];
    var days = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];

    function everyN(field) { var m = /^\*\/(\d+)$/.exec(field); return m ? parseInt(m[1], 10) : null; }
    var allRest = (dom === '*' && mon === '*' && dow === '*');

    if (min === '*' && hr === '*' && allRest) return 'every minute';
    var n = everyN(min);
    if (n && hr === '*' && allRest) return 'every ' + n + ' minutes';
    if (/^\d+$/.test(min) && hr === '*' && allRest) return 'at minute ' + min + ' of every hour';
    if (min === '0' && hr === '*' && allRest) return 'every hour, on the hour';

    if (/^\d+$/.test(min) && /^\d+$/.test(hr)) {
        var time = 'at ' + pad2(+hr) + ':' + pad2(+min);
        if (allRest) return time + ' every day';
        if (dom === '*' && mon === '*' && /^[0-6]$/.test(dow)) return time + ' every ' + days[+dow];
        if (/^\d+$/.test(dom) && mon === '*' && dow === '*') return time + ' on day ' + dom + ' of every month';
    }
    return null; // valid-ish but not recognised
}

/* ── validation (mirrors cron_validate_schedule in ajax.php) ── */
function cronTokenValue(t, min, max, names) {
    t = t.toLowerCase();
    var v;
    if (names && names.hasOwnProperty(t)) v = names[t];
    else if (/^\d+$/.test(t)) v = parseInt(t, 10);
    else return null;
    return (v < min || v > max) ? null : v;
}

function cronFieldValid(field, min, max, names) {
    if (field === '') return false;
    var items = field.split(',');
    for (var i = 0; i < items.length; i++) {
        var item = items[i];
        if (item === '') return false;
        var range = item;
        if (item.indexOf('/') !== -1) {
            var bits = item.split('/');
            range = bits[0];
            if (!/^\d+$/.test(bits[1]) || parseInt(bits[1], 10) < 1) return false;
        }
        if (range === '*') continue;
        if (range.indexOf('-') !== -1) {
            var ab = range.split('-');
            var a = cronTokenValue(ab[0], min, max, names);
            var b = cronTokenValue(ab[1], min, max, names);
            if (a === null || b === null || a > b) return false;
        } else {
            if (cronTokenValue(range, min, max, names) === null) return false;
        }
    }
    return true;
}

function cronValidate(expr) {
    expr = (expr || '').trim();
    if (expr === '') return false;
    if (expr.charAt(0) === '@') {
        return ['@reboot','@yearly','@annually','@monthly','@weekly','@daily','@midnight','@hourly']
            .indexOf(expr.toLowerCase()) !== -1;
    }
    var p = expr.split(/\s+/);
    if (p.length !== 5) return false;
    var months = {jan:1,feb:2,mar:3,apr:4,may:5,jun:6,jul:7,aug:8,sep:9,oct:10,nov:11,dec:12};
    var dows   = {sun:0,mon:1,tue:2,wed:3,thu:4,fri:5,sat:6};
    return cronFieldValid(p[0], 0, 59, null)
        && cronFieldValid(p[1], 0, 23, null)
        && cronFieldValid(p[2], 1, 31, null)
        && cronFieldValid(p[3], 1, 12, months)
        && cronFieldValid(p[4], 0, 7,  dows);
}

function cronDescribe() {
    var expr = $('#cron-schedule').val();
    var $el = $('#cron-desc');
    var $field = $('#cron-schedule').closest('.form-group');
    var $btn = $('#cron-add-btn');

    if (expr.trim() === '') {
        $el.text('');
        $field.removeClass('has-error has-success');
        $btn.prop('disabled', false);
        return;
    }

    if (!cronValidate(expr)) {
        $el.removeClass('text-info text-muted').addClass('text-danger')
           .html('<i class="fa fa-times-circle"></i> ' + $('<span>').text(T_CRON_INVALID).html());
        $field.addClass('has-error').removeClass('has-success');
        $btn.prop('disabled', true);
        return;
    }

    $field.addClass('has-success').removeClass('has-error');
    $btn.prop('disabled', false);

    var d = describeCron(expr);
    if (d === null) {
        $el.removeClass('text-info text-danger').addClass('text-muted').text(T_CRON_CUSTOM);
    } else {
        $el.removeClass('text-muted text-danger').addClass('text-info')
           .html('<i class="fa fa-clock-o"></i> Runs ' + esc(d) + '.');
    }
}

function cronLoad() {
    $.ajax({
        type: 'POST', url: 'ajax.php', dataType: 'json',
        data: { action: 'cron_list', csrf_token: CSRF_TOKEN },
        success: function(d) {
            var user = (d && d.user) || '';
            var lines = user.split('\n');
            var html = '';
            lines.forEach(function(line, idx) {
                if (line.trim() === '') return;
                var isComment = line.trim().charAt(0) === '#';
                html += '<tr><td style="padding-left:15px; font-family:monospace; font-size:12px"'
                     + (isComment ? ' class="text-muted"' : '') + '>' + esc(line) + '</td>'
                     + '<td style="width:60px; text-align:right; padding-right:15px">'
                     + (isComment ? '' :
                        '<button class="btn btn-xs btn-danger" onclick="cronDelete(' + idx + ')">'
                        + '<i class="fa fa-trash"></i></button>')
                     + '</td></tr>';
            });
            if (html === '') {
                html = '<tr><td class="text-muted" style="padding-left:15px">' + $('<span>').text(T_CRON_NONE).html() + '</td></tr>';
            }
            $('#cron-user-tbody').html(html);
            $('#cron-system').text(((d && d.system) || '').trim() || '(empty or not readable)');
        },
        error: function() {
            $('#cron-user-tbody').html('<tr><td class="text-danger" style="padding-left:15px">Failed to load crontab.</td></tr>');
        }
    });
}

function cronAdd() {
    var schedule = $('#cron-schedule').val().trim();
    var command  = $('#cron-command').val().trim();
    if (schedule === '' || command === '') { alert('Enter a schedule and a command.'); return; }
    var $b = $('#cron-add-btn');
    $b.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i>');
    $.ajax({
        type: 'POST', url: 'ajax.php', dataType: 'json',
        data: { action: 'cron_add', schedule: schedule, command: command, csrf_token: CSRF_TOKEN },
        success: function(d) {
            if (d && d.type === 'success') {
                $('#cron-schedule').val(''); $('#cron-command').val('');
                cronLoad();
            } else { alert((d && d.message) || 'Failed to add'); }
        },
        error: function() { alert('Request failed — check SSH settings.'); },
        complete: function() { $b.prop('disabled', false).html('<i class="fa fa-plus"></i> Add'); }
    });
}

function cronDelete(idx) {
    if (!confirm('Remove this cron job?')) return;
    $.ajax({
        type: 'POST', url: 'ajax.php', dataType: 'json',
        data: { action: 'cron_delete', index: idx, csrf_token: CSRF_TOKEN },
        success: function(d) {
            if (d && d.type === 'success') { cronLoad(); }
            else { alert((d && d.message) || 'Failed to remove'); }
        },
        error: function() { alert('Request failed — check SSH settings.'); }
    });
}

$(cronLoad);
</script>

<?php require_once('./include/footer.php'); ?>
