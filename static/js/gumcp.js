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
        type: 'GET',
        url: 'ajax.php',
        data: { action: 'server_info' },
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
        }
    });
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
    $('#button-modal').modal('show');
}

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
