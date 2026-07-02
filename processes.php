<?php
declare(strict_types=1);

$active_page = 'processes';

require_once('./include/init.php');

if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Sort by CPU descending; 'ps aux' columns: USER PID %CPU %MEM VSZ RSS TTY STAT START TIME COMMAND
$raw  = @shell_exec('ps aux | sort -rk 3,3');
$rows = [];

foreach (preg_split('/\r\n|\r|\n/', (string)$raw) as $line) {
    $line = trim($line);
    if ($line === '') continue;
    $rows[] = explode(' ', preg_replace('/\s+/', ' ', $line), 11);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="GumCP Processes">
    <link rel="shortcut icon" href="./static/images/raspberry.png" type="image/png">
    <link rel="icon"          href="./static/images/raspberry.png" type="image/png">
    <title>GumCP Processes</title>
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

    <div class="panel panel-default" style="margin-bottom:5px">
        <div class="panel-heading">
            <h3 class="panel-title">
                <?php echo htmlspecialchars(t('proc.title', 'System Processes'), ENT_QUOTES, 'UTF-8'); ?>
                <a href="?" class="btn btn-success pull-right" style="margin:-6px -11px; color:#fff;">
                    <i class="fa fa-refresh"></i>
                </a>
            </h3>
        </div>
        <div class="panel-body">

            <?php if (empty($rows)): ?>
                <div class="alert alert-warning" role="alert">
                    <i class="fa fa-exclamation-triangle"></i> Unable to retrieve process list.
                </div>
            <?php else: ?>
                <table class="table table-bordered table-condensed">
                    <tbody>
                        <?php foreach ($rows as $row):
                            // ps aux header row has "PID" as its second token
                            $is_header = (($row[1] ?? '') === 'PID');
                            $pid       = $is_header ? 0 : (int)($row[1] ?? 0);
                        ?>
                            <tr>
                                <?php foreach ($row as $i => $cell): ?>
                                    <td<?php echo ($i > 3 && $i < 9) ? ' class="hidden-xs hidden-sm"' : ''; ?>>
                                        <?php if ($is_header): ?>
                                            <b><?php echo htmlspecialchars($cell, ENT_QUOTES, 'UTF-8'); ?></b>
                                        <?php else: ?>
                                            <?php echo htmlspecialchars($cell, ENT_QUOTES, 'UTF-8'); ?>
                                        <?php endif; ?>
                                    </td>
                                <?php endforeach; ?>
                                <td>
                                    <?php if (!$is_header && $pid > 0): ?>
                                        <form method="post" action="./actions.php" style="display:inline-block">
                                            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8'); ?>">
                                            <input type="hidden" name="pid"        value="<?php echo $pid; ?>">
                                            <input type="hidden" name="action"     value="kill_pid">
                                            <button type="submit" class="btn btn-xs btn-danger"
                                                    onclick="return confirm('Kill process <?php echo $pid; ?>?')">
                                                Kill
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>

        </div>
    </div>

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
