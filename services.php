<?php
declare(strict_types=1);

$active_page = 'services';

require_once('./include/init.php');

if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$page_title = 'Services';
require_once('./include/header.php');
?>

<script>
    var CSRF_TOKEN = <?php echo json_encode($_SESSION['csrf_token']); ?>;
    var T_START = <?php echo json_encode(t('svc.start', 'Start')); ?>;
    var T_STOP  = <?php echo json_encode(t('svc.stop',  'Stop')); ?>;

    function escHtml(s) {
        return $('<span>').text(String(s)).html();
    }

    function buildServiceRow(svc, action, btnClass, btnIcon, btnLabel) {
        var csrf = escHtml(CSRF_TOKEN);
        return '<tr>'
            + '<td><i class="fa fa-circle ' + (action === 'stop_sname' ? 'text-success' : 'text-muted') + '"></i> ' + escHtml(svc) + '</td>'
            + '<td class="text-right">'
            + '<form method="post" action="./actions.php" style="display:inline-block">'
            + '<input type="hidden" name="csrf_token" value="' + csrf + '">'
            + '<input type="hidden" name="sname" value="' + escHtml(svc) + '">'
            + '<input type="hidden" name="action" value="' + action + '">'
            + '<button type="submit" class="btn btn-xs ' + btnClass + '" '
            + 'onclick="return confirm(\'' + (action === 'stop_sname' ? T_STOP : T_START) + ' ' + escHtml(svc).replace(/'/g, "\\'") + '?\')">'
            + '<i class="fa ' + btnIcon + '"></i> ' + btnLabel
            + '</button>'
            + '</form>'
            + '</td></tr>';
    }

    function loadServices() {
        $('#services-loading').show();
        $('#services-content').hide();
        $('#services-error').hide();

        $.ajax({
            type: 'POST',
            url: 'ajax.php',
            data: { action: 'services', csrf_token: CSRF_TOKEN },
            dataType: 'json',
            success: function(data) {
                $('#services-loading').hide();

                if (data.type === 'error') {
                    $('#services-error').text(data.message).show();
                    return;
                }

                // Active
                $('#badge-active').text(data.active.length);
                var $active = $('#tbody-active').empty();
                if (data.active.length === 0) {
                    $active.closest('.panel-body').html('<p class="text-muted">No active services.</p>');
                } else {
                    $.each(data.active, function(i, svc) {
                        $active.append(buildServiceRow(svc, 'stop_sname', 'btn-danger', 'fa-stop', T_STOP));
                    });
                }

                // Inactive
                $('#badge-inactive').text(data.inactive.length);
                var $inactive = $('#tbody-inactive').empty();
                if (data.inactive.length === 0) {
                    $inactive.closest('.panel-body').html('<p class="text-muted">No inactive services.</p>');
                } else {
                    $.each(data.inactive, function(i, svc) {
                        $inactive.append(buildServiceRow(svc, 'start_sname', 'btn-success', 'fa-play', T_START));
                    });
                }

                // Unknown
                var $unknownPanel = $('#panel-unknown');
                if (data.unknown.length === 0) {
                    $unknownPanel.hide();
                } else {
                    $('#badge-unknown').text(data.unknown.length);
                    var $unknown = $('#tbody-unknown').empty();
                    $.each(data.unknown, function(i, svc) {
                        $unknown.append('<tr><td><i class="fa fa-question-circle text-warning"></i> ' + escHtml(svc) + '</td></tr>');
                    });
                    $unknownPanel.show();
                }

                $('#services-content').show();
            },
            error: function() {
                $('#services-loading').hide();
                $('#services-error').text('Failed to load service list — check server connectivity.').show();
            }
        });
    }

    $(document).ready(function() {
        loadServices();
    });
    </script>
    <!-- Loading spinner — visible until AJAX returns -->
    <div id="services-loading" class="text-center" style="padding:40px 0">
        <i class="fa fa-spinner fa-spin fa-2x text-muted"></i>
        <p class="text-muted" style="margin-top:10px"><?php echo htmlspecialchars(t('svc.loading', 'Loading services…'), ENT_QUOTES, 'UTF-8'); ?></p>
    </div>

    <!-- Error banner -->
    <div id="services-error" class="alert alert-danger" role="alert" style="display:none">
        <i class="fa fa-times-circle"></i>
        <span></span>
    </div>

    <!-- Service panels — hidden until data arrives -->
    <div id="services-content" style="display:none">

        <!-- Active -->
        <div class="panel panel-success" style="margin-bottom:5px">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <i class="fa fa-check-circle"></i> <?php echo htmlspecialchars(t('svc.active', 'Active Services'), ENT_QUOTES, 'UTF-8'); ?>
                    <span id="badge-active" class="badge pull-right">0</span>
                </h3>
            </div>
            <div class="panel-body">
                <table class="table table-hover" style="margin-bottom:0">
                    <tbody id="tbody-active"></tbody>
                </table>
            </div>
        </div>

        <!-- Inactive -->
        <div class="panel panel-default" style="margin-bottom:5px">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <i class="fa fa-minus-circle"></i> <?php echo htmlspecialchars(t('svc.inactive', 'Inactive Services'), ENT_QUOTES, 'UTF-8'); ?>
                    <span id="badge-inactive" class="badge pull-right">0</span>
                </h3>
            </div>
            <div class="panel-body">
                <table class="table table-hover" style="margin-bottom:0">
                    <tbody id="tbody-inactive"></tbody>
                </table>
            </div>
        </div>

        <!-- Unknown -->
        <div id="panel-unknown" class="panel panel-warning" style="margin-bottom:5px; display:none">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <i class="fa fa-question-circle"></i> <?php echo htmlspecialchars(t('svc.unknown', 'Unknown Status'), ENT_QUOTES, 'UTF-8'); ?>
                    <span id="badge-unknown" class="badge pull-right">0</span>
                </h3>
            </div>
            <div class="panel-body">
                <p class="text-muted" style="margin-bottom:8px">
                    These services do not support <code>service --status-all</code> status reporting.
                </p>
                <table class="table table-hover" style="margin-bottom:0">
                    <tbody id="tbody-unknown"></tbody>
                </table>
            </div>
        </div>

    </div><!-- /#services-content -->

</div>

<?php require_once('./include/footer.php'); ?>
