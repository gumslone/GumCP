<?php
declare(strict_types=1);

$active_page = 'services';

require_once('./include/config.php');

if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// 'service --status-all' writes to stderr on many Pi OS versions, so redirect stderr→stdout.
$raw = @shell_exec('/usr/sbin/service --status-all 2>&1');

$active   = [];
$inactive = [];
$unknown  = [];

foreach (preg_split('/\r\n|\r|\n/', (string)$raw) as $line) {
    if (strpos($line, '[ + ]') !== false) {
        $name = trim(str_replace('[ + ]', '', $line));
        if ($name !== '') $active[] = $name;
    } elseif (strpos($line, '[ - ]') !== false) {
        $name = trim(str_replace('[ - ]', '', $line));
        if ($name !== '') $inactive[] = $name;
    } elseif (strpos($line, '[ ? ]') !== false) {
        $name = trim(str_replace('[ ? ]', '', $line));
        if ($name !== '') $unknown[] = $name;
    }
}

$service_failed = ($raw === null || ($active === [] && $inactive === [] && $unknown === []));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="GumCP Services">
    <link rel="shortcut icon" href="./static/images/raspberry.png" type="image/png">
    <link rel="icon"          href="./static/images/raspberry.png" type="image/png">
    <title>GumCP Services</title>
    <link href="./static/css.php" rel="stylesheet" type="text/css">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <script src="./static/js.php" type="text/javascript"></script>
</head>

<body>
<div class="container">

    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="./index.php">
                    <img src="./static/images/raspberry.png" alt="Logo"> GumCP
                </a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav navbar-right">
                    <?php require_once('./include/menu.php'); ?>
                </ul>
            </div>
        </div>
    </nav>

    <?php if ($service_failed): ?>
        <div class="alert alert-danger" role="alert">
            <i class="fa fa-times-circle"></i>
            Unable to retrieve service list. Ensure <code>/usr/sbin/service</code> is available and
            the web server user has permission to run it.
        </div>
    <?php else: ?>

        <!-- Active services -->
        <div class="panel panel-success" style="margin-bottom:5px">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <i class="fa fa-check-circle"></i> Active Services
                    <span class="badge pull-right"><?php echo count($active); ?></span>
                </h3>
            </div>
            <div class="panel-body">
                <?php if (empty($active)): ?>
                    <p class="text-muted">No active services.</p>
                <?php else: ?>
                    <table class="table table-hover" style="margin-bottom:0">
                        <tbody>
                            <?php foreach ($active as $svc):
                                $svc_esc = htmlspecialchars($svc, ENT_QUOTES, 'UTF-8');
                            ?>
                                <tr>
                                    <td><i class="fa fa-circle text-success"></i> <?php echo $svc_esc; ?></td>
                                    <td class="text-right">
                                        <form method="post" action="./actions.php" style="display:inline-block">
                                            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8'); ?>">
                                            <input type="hidden" name="sname"      value="<?php echo $svc_esc; ?>">
                                            <input type="hidden" name="action"     value="stop_sname">
                                            <button type="submit" class="btn btn-xs btn-danger"
                                                    onclick="return confirm('Stop <?php echo $svc_esc; ?>?')">
                                                <i class="fa fa-stop"></i> Stop
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </div>

        <!-- Inactive services -->
        <div class="panel panel-default" style="margin-bottom:5px">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <i class="fa fa-minus-circle"></i> Inactive Services
                    <span class="badge pull-right"><?php echo count($inactive); ?></span>
                </h3>
            </div>
            <div class="panel-body">
                <?php if (empty($inactive)): ?>
                    <p class="text-muted">No inactive services.</p>
                <?php else: ?>
                    <table class="table table-hover" style="margin-bottom:0">
                        <tbody>
                            <?php foreach ($inactive as $svc):
                                $svc_esc = htmlspecialchars($svc, ENT_QUOTES, 'UTF-8');
                            ?>
                                <tr>
                                    <td><i class="fa fa-circle text-muted"></i> <?php echo $svc_esc; ?></td>
                                    <td class="text-right">
                                        <form method="post" action="./actions.php" style="display:inline-block">
                                            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8'); ?>">
                                            <input type="hidden" name="sname"      value="<?php echo $svc_esc; ?>">
                                            <input type="hidden" name="action"     value="start_sname">
                                            <button type="submit" class="btn btn-xs btn-success"
                                                    onclick="return confirm('Start <?php echo $svc_esc; ?>?')">
                                                <i class="fa fa-play"></i> Start
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </div>

        <!-- Unknown-status services (no SysV init support) -->
        <?php if (!empty($unknown)): ?>
            <div class="panel panel-warning" style="margin-bottom:5px">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <i class="fa fa-question-circle"></i> Unknown Status
                        <span class="badge pull-right"><?php echo count($unknown); ?></span>
                    </h3>
                </div>
                <div class="panel-body">
                    <p class="text-muted" style="margin-bottom:8px">
                        These services do not support <code>service --status-all</code> status reporting.
                    </p>
                    <table class="table table-hover" style="margin-bottom:0">
                        <tbody>
                            <?php foreach ($unknown as $svc): ?>
                                <tr>
                                    <td><i class="fa fa-question-circle text-warning"></i>
                                        <?php echo htmlspecialchars($svc, ENT_QUOTES, 'UTF-8'); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php endif; ?>

    <?php endif; ?>

</div>

<footer class="footer">
    <div class="container">
        <p class="text-muted">
            GumCP <a href="https://github.com/gumslone/GumCP" target="_blank" rel="noopener">GitHub</a>.
            <a href="https://www.paypal.com/donate/?hosted_button_id=VCWHQPACTXV5N"
               target="_blank" rel="noopener">
                <img src="./static/images/Donate-PayPal-green.svg" alt="Donate">
            </a>
        </p>
    </div>
</footer>

</body>
</html>
