/* GumCP — shared JavaScript
 * Requires: jQuery (bundled), Bootstrap 3 (bundled)
 * Each page sets globals before this runs:
 *   var CSRF_TOKEN        — session CSRF token (all pages)
 *   var BUTTON_API_ENABLED — true/false (buttons.php only)
 */

/* ── Dashboard stats (index.php) ─────────────────────────────────────────── */

function barColor(pct) {
    return pct >= 90 ? 'danger' : (pct >= 70 ? 'warning' : 'success');
}

function setBar(id, pct, label) {
    var c  = barColor(pct);
    var $b = $('#' + id);
    $b.css('width', Math.min(pct, 100) + '%')
      .attr('aria-valuenow', pct)
      .text(label)
      .removeClass('progress-bar-success progress-bar-warning progress-bar-danger')
      .addClass('progress-bar-' + c);
}

function setStat(id, text, pct) {
    var c = barColor(pct);
    $('#' + id)
      .text(text)
      .removeClass('text-success text-warning text-danger')
      .addClass('text-' + c);
}

function fmtKB(kb) {
    var units = ['KB', 'MB', 'GB', 'TB'], i = 0, v = kb;
    while (v >= 1024 && i < units.length - 1) { v /= 1024; i++; }
    return v.toFixed(2) + ' ' + units[i];
}

function refreshStats() {
    $.ajax({
        type: 'POST',
        url: 'ajax.php',
        data: {
            action: 'server_info',
            csrf_token: (window.CSRF_TOKEN || ''),
            // Polling is not user activity: it must not hold the idle timeout open.
            gumcp_background: 1
        },
        dataType: 'json',
        success: function(d) {
            if (!d || d.type === 'error') return;

            var tempColor = d.temp >= 80 ? 'danger' : (d.temp >= 70 ? 'warning' : 'success');
            setStat('stat-cpu',  d.cpuusage + '%',          d.cpuusage);
            setStat('stat-mem',  d.memory_percentage + '%', d.memory_percentage);
            setStat('stat-disk', d.disk_percentage + '%',   d.disk_percentage);
            $('#stat-temp')
                .text(d.temp + '°C')
                .removeClass('text-success text-warning text-danger')
                .addClass('text-' + tempColor);

            setBar('bar-cpu',  d.cpuusage, d.cpuusage + '%');
            var memLabel = d.memory_percentage + '% ('
                + fmtKB(d.memory_used) + ' / ' + fmtKB(d.memory_total) + ')';
            setBar('bar-mem',  d.memory_percentage, memLabel);
            setBar('bar-disk', d.disk_percentage,
                d.disk_percentage + '% (' + d.disk_used + ' / ' + d.disk_total + ')');
            setBar('bar-temp', Math.min(d.temp, 100), d.temp + '°C');

            $('#mem-total').text(fmtKB(d.memory_total));
            $('#mem-used').text(fmtKB(d.memory_used));
            $('#mem-buffers').text(fmtKB(d.memory_buffers));
            $('#mem-cached').text(fmtKB(d.memory_cached));

            $('#info-uptime').text(d.uptime);
            $('#info-date').text(d.date);
            $('#info-processes').text(d.processes);
            $('#info-load').text(d.load0 + ', ' + d.load1 + ', ' + d.load2);

            function esc(s) { return $('<div>').text(s || '').html(); }
            $('#info-top').html(esc(d.top));
            $('#info-users').html(esc(d.users));
            $('#info-disks').html(esc(d.disks));

            if (d.usb && d.usb.trim() !== '') {
                $('#info-usb').removeClass('text-muted').html(esc(d.usb));
            }
            if (d.blk && d.blk.trim() !== '') {
                $('#info-blk').removeClass('text-muted').html(esc(d.blk));
            }

            // Swap bar
            if (typeof d.swap_percentage !== 'undefined') {
                if (d.swap_total > 0) {
                    setBar('bar-swap', d.swap_percentage,
                        d.swap_percentage + '% (' + fmtKB(d.swap_used) + ' / ' + fmtKB(d.swap_total) + ')');
                } else {
                    setBar('bar-swap', 0, (window.GUMCP_I18N && window.GUMCP_I18N.no_swap) || 'No swap');
                }
            }

            // Service badges
            if (d.services_status) updateServiceBadges(d.services_status);

            // Power / throttling status
            if (d.throttled) updateThrottleStatus(d.throttled);

            // Network table
            if (d.network) updateNetworkTable(d.network);
        }
    });
}

function serviceLabelClass(state) {
    switch (state) {
        case 'active':   return 'label-success';
        case 'inactive': return 'label-default';
        case 'failed':   return 'label-danger';
        default:         return 'label-warning';
    }
}

function updateServiceBadges(services) {
    var $box = $('#service-badges');
    if (!$box.length || !services.length) return;
    var html = '';
    services.forEach(function(s) {
        html += '<span class="label ' + serviceLabelClass(s.state) + '"'
              + ' style="display:inline-block; margin:3px; padding:6px 10px; font-size:13px"'
              + ' title="' + $('<div>').text(s.state).html() + '">'
              + '<i class="fa fa-circle"></i> ' + $('<div>').text(s.name).html()
              + '</span>';
    });
    $box.html(html);
}

function updateThrottleStatus(t) {
    var $box = $('#throttle-status');
    if (!$box.length) return;
    var html;
    var i18n = window.GUMCP_I18N || {};
    if (!t.available) {
        var reason = t.reason ? $('<div>').text(t.reason).html() : (i18n.power_na || 'Not available');
        html = '<span class="text-muted"><i class="fa fa-question-circle"></i> ' + reason + '</span>';
    } else if (t.healthy) {
        html = '<span class="text-success"><i class="fa fa-check-circle"></i> '
             + $('<div>').text(i18n.healthy || 'Healthy — no under-voltage or throttling.').html() + '</span>';
    } else {
        html = '';
        (t.messages || []).forEach(function(m) {
            html += '<div class="text-danger"><i class="fa fa-exclamation-triangle"></i> '
                  + $('<div>').text(m).html() + '</div>';
        });
    }
    $box.html(html);
}

function signalQuality(dbm) {
    if (dbm === null || typeof dbm === 'undefined') return '';
    if (dbm >= -50) return 'excellent';
    if (dbm >= -60) return 'good';
    if (dbm >= -70) return 'fair';
    return 'weak';
}

function updateNetworkTable(network) {
    var $tbody = $('#network-table tbody');
    if (!$tbody.length) return;
    var esc = function(s) { return $('<div>').text(s == null ? '' : s).html(); };
    if (!network.length) {
        $tbody.html('<tr><td colspan="6" class="text-muted" style="padding-left:15px">'
            + 'No network interfaces found.</td></tr>');
        return;
    }
    var html = '';
    network.forEach(function(n) {
        var up = n.state === 'up';
        var sig = n.signal !== null && typeof n.signal !== 'undefined'
            ? n.signal + ' dBm (' + signalQuality(n.signal) + ')'
            : (n.wireless ? '—' : '');
        html += '<tr>'
            + '<td style="padding-left:15px"><i class="fa ' + (n.wireless ? 'fa-wifi' : 'fa-exchange')
            + ' text-muted"></i> <strong>' + esc(n.iface) + '</strong></td>'
            + '<td>' + (n.ip ? esc(n.ip) : '<span class="text-muted">—</span>') + '</td>'
            + '<td><span class="label ' + (up ? 'label-success' : 'label-default') + '">'
            + esc(n.state) + '</span></td>'
            + '<td>' + esc(sig) + '</td>'
            + '<td class="text-right">' + fmtBytes(n.rx) + '</td>'
            + '<td class="text-right" style="padding-right:15px">' + fmtBytes(n.tx) + '</td>'
            + '</tr>';
    });
    $tbody.html(html);
}

function fmtBytes(bytes) {
    var units = ['B', 'KB', 'MB', 'GB', 'TB'], i = 0, v = bytes;
    while (v >= 1024 && i < units.length - 1) { v /= 1024; i++; }
    return v.toFixed(2) + ' ' + units[i];
}

$(function() {
    if (document.getElementById('stat-cpu')) {
        setInterval(refreshStats, 30000);
    }
});

/* ── Menu reorder (index.php modal, triggered from any page via menu.php) ── */

function openMenuReorder() {
    $('#menu-reorder-modal').modal('show');
}

(function() {
    var list, dragged;

    document.addEventListener('DOMContentLoaded', function() {
        list = document.getElementById('menu-sortable-list');
        if (!list) return;

        list.addEventListener('dragstart', function(e) {
            dragged = e.target.closest('li[data-key]');
            if (!dragged) { e.preventDefault(); return; }
            e.dataTransfer.effectAllowed = 'move';
            setTimeout(function() { dragged.style.opacity = '0.4'; }, 0);
        });

        list.addEventListener('dragend', function() {
            if (dragged) dragged.style.opacity = '';
            dragged = null;
            list.querySelectorAll('li[data-key]').forEach(function(li) {
                li.style.borderColor = '';
            });
        });

        list.addEventListener('dragover', function(e) {
            e.preventDefault();
            e.dataTransfer.dropEffect = 'move';
            var over = e.target.closest('li[data-key]');
            if (!over || over === dragged) return;
            list.querySelectorAll('li[data-key]').forEach(function(li) {
                li.style.borderColor = '';
            });
            over.style.borderColor = '#66afe9';
        });

        list.addEventListener('drop', function(e) {
            e.preventDefault();
            var over = e.target.closest('li[data-key]');
            if (!over || !dragged || over === dragged) return;
            var items = Array.from(list.querySelectorAll('li'));
            if (items.indexOf(dragged) < items.indexOf(over)) {
                list.insertBefore(dragged, over.nextSibling);
            } else {
                list.insertBefore(dragged, over);
            }
        });
    });
})();

function saveMenuOrder() {
    var btn = document.getElementById('menu-reorder-save-btn');
    btn.disabled = true;
    var order = [];
    document.querySelectorAll('#menu-sortable-list li[data-key]').forEach(function(li) {
        order.push(li.getAttribute('data-key'));
    });
    $.ajax({
        type: 'POST',
        url: './ajax.php?action=save_menu_order',
        dataType: 'json',
        data: { order: order, csrf_token: CSRF_TOKEN },
        success: function() { location.reload(); },
        error: function() {
            alert('Failed to save menu order');
            btn.disabled = false;
        }
    });
}

/* ── Button modal helpers (buttons.php) ──────────────────────────────────── */

function openButtonModal(title, buttonId) {
    $('#button-modal .modal-title').text(title);
    $('#button-modal-form')[0].reset();
    $('#modal-button-id').val(buttonId !== undefined ? buttonId : '');
    $('#modal-button-direct').prop('checked', false);
    $('#modal-api-section').hide();
    buttonLoadScriptOptions();
    $('#button-modal').modal('show');
}

/* ── Saved-script pickers (buttons.php, cron.php) ─────────────────────────
 * Fill a <select> with the runnable scripts from the Script Editor, and turn
 * a selection into the command line that runs it. */
function gumcpLoadScriptPicker(selId) {
    var $sel = $('#' + selId);
    if (!$sel.length) return;
    $.ajax({
        type: 'POST', url: 'ajax.php', dataType: 'json',
        data: { action: 'script_list', csrf_token: CSRF_TOKEN }
    }).done(function (d) {
        if (!d || d.type !== 'success') return;
        $sel.find('option:not(:first)').remove();
        (d.files || []).forEach(function (f) {
            if (!/\.(sh|py)$/.test(f.name)) return;   // .txt cannot run
            $('<option></option>').attr('value', f.name).text(f.name).appendTo($sel);
        });
    });
}

function gumcpScriptRunLine(name) {
    var interp = /\.py$/.test(name) ? 'python3' : 'bash';
    // The name is server-validated to [A-Za-z0-9._-]+, so quoting is enough.
    return interp + " '" + GUMCP_DIR + "/user_scripts/" + name + "'";
}

function gumcpInsertScript(sel, targetId) {
    if (!sel.value) return;
    $('#' + targetId).val(gumcpScriptRunLine(sel.value));
    sel.value = '';
}

function buttonLoadScriptOptions() { gumcpLoadScriptPicker('modal-button-script'); }
function buttonInsertScript(sel)   { gumcpInsertScript(sel, 'modal-button-command'); }

function addButton() {
    openButtonModal('Add Command Button');
}

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
            $('#modal-button-title').val(data.button_title    || '');
            $('#modal-button-command').val(data.button_command || '');
            $('#modal-button-icon').val(data.button_icon      || '');
            $('#modal-button-style').val(data.button_style    || 'btn-default');
            $('#modal-button-size').val(data.button_size      || 'btn-md');
            $('#modal-button-direct').prop('checked', !!data.button_direct);
            var hash = data.button_hash || '';
            if (hash && BUTTON_API_ENABLED) {
                var apiUrl = window.location.href.replace(/\/[^\/]*$/, '/api.php?hash=' + hash);
                $('#modal-api-hash').val(hash);
                $('#modal-api-url').val(apiUrl);
                $('#modal-api-section').show();
            } else {
                $('#modal-api-section').hide();
            }
        },
        error: function() {
            alert('Error loading button data');
            $('#button-modal').modal('hide');
        }
    });
}

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

/* ── Button execution (buttons.php) ──────────────────────────────────────── */

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
    $runBtn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Running…');
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
            $('#exec-modal-output')
                .removeClass('text-success text-danger')
                .addClass('text-danger')
                .text('Request failed — could not reach the server.');
            $('#exec-modal-output-wrap').show();
            $('#exec-modal-footer-run').hide();
            $('#exec-modal-footer-close').show();
        }
    });
}

function executeDirectButton(buttonId, triggerEl) {
    var $btn     = $(triggerEl);
    var $wrap    = $('#direct-output-' + buttonId);
    var $pre     = $wrap.find('pre');
    var origHtml = $btn.html();

    $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i>');
    $wrap.hide();
    $pre.removeClass('text-success text-danger').text('');

    $.ajax({
        type: 'POST',
        url: 'ajax.php',
        data: { action: 'execute_button', button_id: buttonId, csrf_token: CSRF_TOKEN },
        dataType: 'json',
        success: function(data) {
            var ok     = data.type === 'success';
            var output = (data.output || '').trim() || (ok ? '(no output)' : data.message || 'Command failed');
            $pre.addClass(ok ? 'text-success' : 'text-danger').text(output);
            $wrap.show();
            $btn.prop('disabled', false).html(origHtml);
        },
        error: function() {
            $pre.addClass('text-danger').text('Request failed — could not reach the server.');
            $wrap.show();
            $btn.prop('disabled', false).html(origHtml);
        }
    });
}

/* ── API hash helpers (buttons.php) ──────────────────────────────────────── */

function copyApiUrl() {
    var $inp = $('#modal-api-url');
    $inp[0].select();
    try {
        document.execCommand('copy');
        var $btn = $inp.closest('.input-group').find('button');
        $btn.html('<i class="fa fa-check"></i>');
        setTimeout(function() { $btn.html('<i class="fa fa-copy"></i>'); }, 1500);
    } catch(e) {}
}

function regenerateHash() {
    var btnId = $('#modal-button-id').val();
    if (!btnId) return;
    if (!confirm('Regenerate the API hash? The old URL will stop working immediately.')) return;
    $.ajax({
        type: 'POST',
        url: 'ajax.php',
        dataType: 'json',
        data: { action: 'regenerate_button_hash', button_id: btnId, csrf_token: CSRF_TOKEN },
        success: function(data) {
            if (data.type !== 'success') { alert(data.message || 'Error'); return; }
            var newUrl = window.location.href.replace(/\/[^\/]*$/, '/api.php?hash=' + data.button_hash);
            $('#modal-api-hash').val(data.button_hash);
            $('#modal-api-url').val(newUrl);
        },
        error: function() { alert('Error regenerating hash'); }
    });
}

/* ── Button delete (buttons.php) ─────────────────────────────────────────── */

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

/* ── Button drag-and-drop reorder (buttons.php) ──────────────────────────── */

(function() {
    document.addEventListener('DOMContentLoaded', function() {
        var container = document.getElementById('buttons-sortable');
        if (!container) return;

        var dragged = null;

        container.addEventListener('dragstart', function(e) {
            dragged = e.target.closest('.btn-draggable');
            if (!dragged) { e.preventDefault(); return; }
            e.dataTransfer.effectAllowed = 'move';
            setTimeout(function() { dragged.style.opacity = '0.4'; }, 0);
        });

        container.addEventListener('dragend', function() {
            if (dragged) dragged.style.opacity = '';
            dragged = null;
            container.querySelectorAll('.btn-draggable').forEach(function(el) {
                el.style.outline = '';
            });
        });

        container.addEventListener('dragover', function(e) {
            e.preventDefault();
            e.dataTransfer.dropEffect = 'move';
            var over = e.target.closest('.btn-draggable');
            container.querySelectorAll('.btn-draggable').forEach(function(el) {
                el.style.outline = '';
            });
            if (over && over !== dragged) {
                over.style.outline = '2px solid #66afe9';
            }
        });

        container.addEventListener('drop', function(e) {
            e.preventDefault();
            var over = e.target.closest('.btn-draggable');
            if (!over || !dragged || over === dragged) return;
            var items = Array.from(container.querySelectorAll('.btn-draggable'));
            if (items.indexOf(dragged) < items.indexOf(over)) {
                container.insertBefore(dragged, over.nextSibling);
            } else {
                container.insertBefore(dragged, over);
            }
            saveButtonOrder(container);
        });
    });

    function saveButtonOrder(container) {
        var order = [];
        container.querySelectorAll('.btn-draggable').forEach(function(el) {
            order.push(el.getAttribute('data-idx'));
        });
        $.post('./ajax.php?action=reorder_buttons', {
            order: order,
            csrf_token: CSRF_TOKEN
        }, null, 'json');
    }
})();

/* ── Legacy dialog helpers (kept for backward compatibility) ─────────────── */

function open_ajax_dialog(dialogTitle, ajaxUrl) {
    $.get(ajaxUrl, function(data) {
        open_dialog(dialogTitle, data);
    });
}

function open_dialog(dialogTitle, dialogContent) {
    var html = '<div id="dialog" class="modal fade" role="dialog">'
        + '<div class="modal-dialog"><div class="modal-content">'
        + '<div class="modal-header">'
        + '<button type="button" class="close" data-dismiss="modal">&times;</button>'
        + '<h4 class="modal-title">' + dialogTitle + '</h4>'
        + '</div>'
        + '<div class="modal-body">' + dialogContent + '</div>'
        + '<div class="modal-footer">'
        + '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>'
        + '</div></div></div></div>';
    $('#dialog-placeholder').html(html);
    $('#dialog').modal('show');
}

function getUrlVars() {
    var vars = {};
    window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m, key, value) {
        vars[key] = value;
    });
    return vars;
}

/* ── Script Editor (scripts.php) ─────────────────────────────────────────── */

var _scriptCurrent = '';
var _scriptSavedContent = null;   // editor content as of the last load/save

function scriptDirty() {
    return _scriptSavedContent !== null
        && typeof scriptEditor !== 'undefined'
        && scriptEditor.getValue() !== _scriptSavedContent;
}

/* Losing a half-written script to a stray click is the worst thing this page
 * can do — confirm before discarding, and warn on navigation. */
function scriptConfirmDiscard() {
    return !scriptDirty()
        || confirm((window.GUMCP_I18N && GUMCP_I18N.scripts_unsaved)
                   || 'Discard unsaved changes to this script?');
}

function scriptAjax(data, done, btn, busyHtml) {
    var $b = btn ? $(btn) : null, orig = $b ? $b.html() : '';
    if ($b) $b.prop('disabled', true).html(busyHtml || '<i class="fa fa-spinner fa-spin"></i>');
    data.csrf_token = CSRF_TOKEN;
    $.ajax({ type: 'POST', url: 'ajax.php', dataType: 'json', data: data })
        .done(function (d) { done(d || {}); })
        .fail(function () { done({ type: 'error', message: 'Request failed — could not reach the server.' }); })
        .always(function () { if ($b) $b.prop('disabled', false).html(orig); });
}

function scriptStatus(msg, isError) {
    $('#script-status').text(msg)
        .toggleClass('text-danger', !!isError)
        .toggleClass('text-muted', !isError);
}

function scriptModeFor(name) {
    return /\.py$/.test(name) ? 'python' : 'shell';
}

function scriptRefreshList(selectName) {
    scriptAjax({ action: 'script_list' }, function (d) {
        var esc = function (s) { return $('<div>').text(s == null ? '' : s).html(); };
        var $l = $('#script-list').empty();
        if (d.type !== 'success') {
            $l.append('<span class="list-group-item text-danger">' + esc(d.message || 'Failed') + '</span>');
            return;
        }
        if (!d.files.length) {
            $l.append('<span class="list-group-item text-muted">No scripts yet — try an example below.</span>');
        }
        d.files.forEach(function (f) {
            var kb = (f.size / 1024).toFixed(1);
            $('<a class="list-group-item"></a>')
                .toggleClass('active', f.name === selectName)
                .html('<i class="fa ' + (/\.py$/.test(f.name) ? 'fa-file-code-o' : 'fa-terminal') + '"></i> '
                      + esc(f.name) + ' <small>' + kb + ' KB</small>')
                .on('click', function () { scriptLoad(f.name, 'user'); })
                .appendTo($l);
        });
        // Seventeen examples make a long sidebar, so they sit in a collapsed
        // panel, grouped by what they drive rather than alphabetically.
        var $t = $('#template-list').empty();
        var groups = [
            { label: 'GPIO',    icon: 'fa-microchip', match: /^gpio-/ },
            { label: 'Motors',  icon: 'fa-cog',       match: /^motor-/ },
            { label: 'Sensors', icon: 'fa-thermometer-half', match: /^sensor-/ },
            { label: 'System',  icon: 'fa-linux',     match: /./ }
        ];
        var templates = d.templates || [];
        var used = {};
        groups.forEach(function (g) {
            var members = templates.filter(function (n) { return !used[n] && g.match.test(n); });
            if (!members.length) return;
            members.forEach(function (n) { used[n] = true; });
            $('<span class="list-group-item disabled" style="padding:4px 12px; font-size:11px; '
              + 'text-transform:uppercase; letter-spacing:0.5px; background:#f9f9f9"></span>')
                .html('<i class="fa ' + g.icon + '"></i> ' + g.label)
                .appendTo($t);
            members.forEach(function (name) {
                $('<a class="list-group-item"></a>')
                    .html('<i class="fa fa-magic"></i> ' + esc(name))
                    .on('click', function () { scriptLoad(name, 'template'); })
                    .appendTo($t);
            });
        });
        $('#template-count').text(templates.length);
        if (d.writable === false) {
            scriptStatus('user_scripts/ is not writable by the web server — saving will fail.', true);
        }
    });
}

function scriptLoad(name, from) {
    if (!scriptConfirmDiscard()) return;
    scriptAjax({ action: 'script_load', name: name, from: from }, function (d) {
        if (d.type !== 'success') { scriptStatus(d.message || 'Load failed', true); return; }
        _scriptCurrent = from === 'user' ? name : '';
        $('#script-name').val(name);
        scriptEditor.setOption('mode', scriptModeFor(name));
        scriptEditor.setValue(d.content);
        _scriptSavedContent = d.content;
        $('#script-output-wrap').hide();
        scriptStatus(from === 'template' ? 'Loaded example — Save stores your own copy.' : '');
        scriptRefreshList(_scriptCurrent);
    });
}

function scriptNew() {
    if (!scriptConfirmDiscard()) return;
    _scriptCurrent = '';
    $('#script-name').val('');
    scriptEditor.setValue('#!/bin/bash\n\n');
    _scriptSavedContent = scriptEditor.getValue();
    scriptEditor.setOption('mode', 'shell');
    $('#script-output-wrap').hide();
    scriptStatus('');
    scriptRefreshList('');
}

function scriptSave(then) {
    var name = $.trim($('#script-name').val());
    scriptAjax({ action: 'script_save', name: name, content: scriptEditor.getValue() }, function (d) {
        if (d.type !== 'success') { scriptStatus(d.message || 'Save failed', true); return; }
        _scriptCurrent = name;
        _scriptSavedContent = scriptEditor.getValue();
        scriptEditor.setOption('mode', scriptModeFor(name));
        scriptStatus('Saved.');
        scriptRefreshList(name);
        if (then) then();
    }, document.getElementById('script-save-btn'));
}

function scriptRun() {
    scriptSave(function () {
        scriptAjax({ action: 'script_run', name: _scriptCurrent }, function (d) {
            var ok = d.type === 'success';
            $('#script-output')
                .css('color', ok ? '#e0e0e0' : '#f2a5a5')
                .text(ok ? ((d.output || '').trim() || '(no output)') : (d.message || 'Run failed'));
            $('#script-output-wrap').show();
        }, document.getElementById('script-run-btn'),
           '<i class="fa fa-spinner fa-spin"></i> Running…');
    });
}

/* Schedule the current script as a cron job — saves first so the file the
 * crontab points at actually exists, then reuses the cron_add action. Only
 * runnable extensions make sense here. */
function scriptScheduleOpen() {
    var name = $.trim($('#script-name').val());
    if (!/\.(sh|py)$/.test(name)) {
        scriptStatus('Only .sh and .py scripts can be scheduled.', true);
        return;
    }
    scriptSave(function () {
        $('#schedule-modal-script').text(gumcpScriptRunLine(_scriptCurrent));
        $('#schedule-error').hide();
        $('#schedule-modal').modal('show');
    });
}

function scriptScheduleAdd() {
    var expr = $.trim($('#schedule-expr').val());
    scriptAjax({
        action: 'cron_add',
        schedule: expr,
        command: gumcpScriptRunLine(_scriptCurrent)
    }, function (d) {
        if (d.type !== 'success') {
            $('#schedule-error').text(d.message || 'Failed to add the cron job').show();
            return;
        }
        $('#schedule-modal').modal('hide');
        scriptStatus('Scheduled: ' + expr + ' — manage it on the Cron page.');
    }, document.getElementById('schedule-add-btn'),
       '<i class="fa fa-spinner fa-spin"></i>');
}

function scriptDelete() {
    var name = _scriptCurrent || $.trim($('#script-name').val());
    if (!name) return;
    if (!confirm('Delete ' + name + '?')) return;
    scriptAjax({ action: 'script_delete', name: name }, function (d) {
        if (d.type !== 'success') { scriptStatus(d.message || 'Delete failed', true); return; }
        scriptNew();
    }, document.getElementById('script-delete-btn'));
}

// js.php is loaded in <head>, so the element check must wait for DOM ready.
$(function () {
    if (!document.getElementById('script-list')) return;
    scriptRefreshList('');
    _scriptSavedContent = '';

    // Ctrl+S / Cmd+S saves instead of opening the browser's save dialog.
    $(document).on('keydown', function (e) {
        if ((e.ctrlKey || e.metaKey) && String.fromCharCode(e.which).toLowerCase() === 's') {
            e.preventDefault();
            scriptSave();
        }
    });

    window.addEventListener('beforeunload', function (e) {
        if (scriptDirty()) { e.preventDefault(); e.returnValue = ''; }
    });
});
