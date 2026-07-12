<?php
declare(strict_types=1);

$active_page = 'packages';

require_once('./include/init.php');

$page_title = 'Package Updates';
require_once('./include/header.php');
?>

<script>
    var CSRF_TOKEN = <?php echo json_encode($_SESSION['csrf_token']); ?>;
    var T_UPTODATE = <?php echo json_encode(t('pkg.uptodate', 'Everything is up to date.')); ?>;
    </script>
    <div class="page-header">
        <h1><i class="fa fa-cubes"></i> <?php echo htmlspecialchars(t('pkg.title', 'Package Updates'), ENT_QUOTES, 'UTF-8'); ?>
            <small id="pkg-count-label">…</small>
        </h1>
    </div>

    <div class="alert alert-info" id="pkg-index-note" style="display:none">
        <i class="fa fa-info-circle"></i> <span id="pkg-index-text"></span>
    </div>

    <p>
        <button class="btn btn-default" id="pkg-check-btn" onclick="pkgCheck()">
            <i class="fa fa-refresh"></i> <?php echo htmlspecialchars(t('pkg.check', 'Check for updates'), ENT_QUOTES, 'UTF-8'); ?>
        </button>
        <button class="btn btn-warning" id="pkg-upgrade-btn" onclick="pkgUpgrade()">
            <i class="fa fa-arrow-circle-up"></i> <?php echo htmlspecialchars(t('pkg.upgrade', 'Upgrade all'), ENT_QUOTES, 'UTF-8'); ?>
        </button>
        <span class="text-muted" style="margin-left:8px; font-size:12px">
            <code>apt-get update</code> / <code>apt-get upgrade</code> run over SSH.
        </span>
    </p>

    <div class="alert alert-danger" id="pkg-error" style="display:none">
        <i class="fa fa-exclamation-triangle"></i> <span id="pkg-error-text"></span>
    </div>

    <div id="pkg-output-wrap" style="display:none; margin-bottom:15px">
        <pre id="pkg-output" style="max-height:300px; overflow:auto"></pre>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading"><i class="fa fa-list"></i> <?php echo htmlspecialchars(t('pkg.upgradable', 'Upgradable Packages'), ENT_QUOTES, 'UTF-8'); ?></div>
        <table class="table table-condensed table-striped" style="margin-bottom:0">
            <thead>
                <tr><th style="padding-left:15px"><?php echo htmlspecialchars(t('pkg.package', 'Package'), ENT_QUOTES, 'UTF-8'); ?></th><th><?php echo htmlspecialchars(t('pkg.installed', 'Installed'), ENT_QUOTES, 'UTF-8'); ?></th><th><?php echo htmlspecialchars(t('pkg.available', 'Available'), ENT_QUOTES, 'UTF-8'); ?></th></tr>
            </thead>
            <tbody id="pkg-tbody">
                <tr><td colspan="3" class="text-muted" style="padding-left:15px">Loading…</td></tr>
            </tbody>
        </table>
    </div>

</div>

<script>
function pkgLoadList() {
    $.ajax({
        type: 'POST', url: 'ajax.php', dataType: 'json',
        data: { action: 'pkg_list', csrf_token: CSRF_TOKEN },
        success: function(d) {
            var pkgs = (d && d.packages) || [];
            var esc = function(s) { return $('<div>').text(s == null ? '' : s).html(); };
            $('#pkg-count-label').text(pkgs.length + ' update' + (pkgs.length !== 1 ? 's' : '') + ' available');
            pkgShowIndexAge((d && d.index_mtime) || 0, pkgs.length);
            if (!pkgs.length) {
                $('#pkg-tbody').html('<tr><td colspan="3" class="text-success" style="padding-left:15px">'
                    + '<i class="fa fa-check"></i> ' + $('<span>').text(T_UPTODATE).html() + '</td></tr>');
                return;
            }
            var html = '';
            pkgs.forEach(function(p) {
                html += '<tr><td style="padding-left:15px"><strong>' + esc(p.name) + '</strong></td>'
                     + '<td class="text-muted">' + esc(p.current) + '</td>'
                     + '<td class="text-success">' + esc(p.new) + '</td></tr>';
            });
            $('#pkg-tbody').html(html);
        },
        error: function() {
            $('#pkg-count-label').text('error');
            $('#pkg-tbody').html('<tr><td colspan="3" class="text-danger" style="padding-left:15px">Failed to load package list.</td></tr>');
        }
    });
}

function pkgShowOutput(text) {
    $('#pkg-output').text(text || '');
    $('#pkg-output-wrap').show();
}

function pkgShowError(msg) {
    if (msg) {
        $('#pkg-error-text').text(msg);
        $('#pkg-error').show();
    } else {
        $('#pkg-error').hide();
    }
}

function pkgAgo(secs) {
    if (secs < 90) return 'just now';
    var m = Math.round(secs / 60);
    if (m < 90) return m + ' minute' + (m !== 1 ? 's' : '') + ' ago';
    var h = Math.round(m / 60);
    if (h < 36) return h + ' hour' + (h !== 1 ? 's' : '') + ' ago';
    var dys = Math.round(h / 24);
    return dys + ' day' + (dys !== 1 ? 's' : '') + ' ago';
}

function pkgShowIndexAge(mtime, count) {
    var $note = $('#pkg-index-note'), $txt = $('#pkg-index-text');
    if (!mtime) {
        $note.removeClass('alert-info alert-warning').addClass('alert-warning').show();
        $txt.html('The apt index age is unknown. Click <strong>Check for updates</strong> to refresh it.');
        return;
    }
    var age = Math.max(0, Math.floor(Date.now() / 1000) - mtime);
    var stale = age > 86400; // older than a day
    $note.removeClass('alert-info alert-warning').addClass(stale ? 'alert-warning' : 'alert-info').show();
    var msg = 'Package index last refreshed <strong>' + pkgAgo(age) + '</strong>.';
    if (count === 0) {
        msg += stale
            ? ' That\'s a while ago — click <strong>Check for updates</strong> to be sure the list is current.'
            : ' Your system is up to date.';
    }
    $txt.html(msg);
}

function pkgCheck() {
    var $b = $('#pkg-check-btn');
    pkgShowError('');
    $b.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Checking…');
    $.ajax({
        type: 'POST', url: 'ajax.php', dataType: 'json',
        data: { action: 'pkg_check', csrf_token: CSRF_TOKEN },
        success: function(d) {
            pkgShowError(d && d.type === 'error' ? (d.message || 'apt update failed') : '');
            pkgShowOutput((d && (d.output || d.message)) || '');
            pkgLoadList();
        },
        error: function() {
            pkgShowError('Request failed — check SSH settings.');
        },
        complete: function() { $b.prop('disabled', false).html('<i class="fa fa-refresh"></i> Check for updates'); }
    });
}

function pkgUpgrade() {
    if (!confirm('Upgrade all packages now? This runs apt-get upgrade and may take a while.')) return;
    var $b = $('#pkg-upgrade-btn');
    $b.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Upgrading…');
    pkgShowOutput('Running apt-get upgrade… this can take several minutes.');
    $.ajax({
        type: 'POST', url: 'ajax.php', dataType: 'json',
        data: { action: 'pkg_upgrade', csrf_token: CSRF_TOKEN },
        success: function(d) {
            pkgShowOutput((d && (d.output || d.message)) || '');
            pkgLoadList();
        },
        error: function() { pkgShowOutput('Request failed or timed out — the upgrade may still be running.'); },
        complete: function() { $b.prop('disabled', false).html('<i class="fa fa-arrow-circle-up"></i> Upgrade all'); }
    });
}

$(pkgLoadList);
</script>

<?php require_once('./include/footer.php'); ?>
