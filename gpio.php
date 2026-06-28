<?php
declare(strict_types=1);

$active_page = 'gpio';

require_once('./include/init.php');

if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// ── GPIO data source detection ────────────────────────────────────────────────
// WiringPi works on Pi 1–4. Pi 5 uses the RP1 GPIO chip which WiringPi does
// not support; fall back to raspi-gpio (built into Pi OS since Buster).

$gpio_source  = 'none'; // 'wiringpi' | 'raspi-gpio' | 'none'
$gpio_raw     = '';
$message      = '';
$message_type = 'danger';

$wiringpi_out = shell_exec('gpio readall 2>/dev/null');
if (!empty($wiringpi_out)) {
    $gpio_source  = 'wiringpi';
    $gpio_raw     = $wiringpi_out;
} else {
    $raspi_out = shell_exec('raspi-gpio get 2>/dev/null');
    if (!empty($raspi_out)) {
        $gpio_source  = 'raspi-gpio';
        $gpio_raw     = $raspi_out;
        $message      = 'WiringPi is not available on this model (Pi 5 uses the RP1 chip). '
                      . 'Displaying raw raspi-gpio output. GPIO switching is not supported in this mode.';
        $message_type = 'warning';
    } else {
        $message = 'Unable to read GPIO data. '
                 . 'Install WiringPi (Pi 1–4) or ensure raspi-gpio is available (Pi 5).';
    }
}

// ── Parse WiringPi table ──────────────────────────────────────────────────────
// gpio readall produces a '|'-delimited table. Each row is split on ' | ' and
// the leading empty element is discarded. Only rows with more than one cell
// after stripping are kept (skips the decorative +---+ lines).

$gpio_rows = [];

if ($gpio_source === 'wiringpi') {
    foreach (preg_split('/\r\n|\r|\n/', $gpio_raw) as $line) {
        $parts = explode(' | ', $line);
        $cells = [];
        for ($i = 1; $i < count($parts); $i++) {
            $cells[] = trim(str_replace([' |', ' '], '', $parts[$i]));
        }
        if (count($cells) > 1) {
            $gpio_rows[] = $cells;
        }
    }
}

// ── Identify controllable GPIO pins ──────────────────────────────────────────
// In `gpio readall` the leftmost cell of a row is the left side's BCM number and
// the rightmost cell is the right side's BCM number. Power and ground pins
// (Name = 3.3v / 5v / 0v) have an EMPTY BCM cell — only pins with a numeric BCM
// can be switched. This avoids rendering dead toggles on power/ground pins.

$physical_col = -1; // column index of the Physical cell
if (!empty($gpio_rows[0])) {
    foreach ($gpio_rows[0] as $i => $header) {
        if (stripos(trim($header), 'physical') !== false) {
            $physical_col = $i;
            break;
        }
    }
}

// Per-row flags: a side is controllable only when its BCM cell is numeric.
$row_meta = [];
foreach ($gpio_rows as $k => $row) {
    $last  = count($row) - 1;
    $bcm_l = $row[0]     ?? '';
    $bcm_r = $row[$last] ?? '';
    $row_meta[$k] = [
        'is_left'   => ctype_digit($bcm_l),
        'is_right'  => ctype_digit($bcm_r),
        'bcm_left'  => $bcm_l,
        'bcm_right' => $bcm_r,
    ];
}

// Display label for a pin Name cell: 0v → GND, tidy power-rail casing.
function gpio_name_label(string $name): string {
    $n = strtolower(trim($name));
    if ($n === '0v')   return 'GND';
    if ($n === '3.3v') return '3.3V';
    if ($n === '5v')   return '5V';
    return $name;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="GumCP GPIO Control">
    <link rel="shortcut icon" href="./static/images/raspberry.png" type="image/png" />
    <link rel="icon" href="./static/images/raspberry.png" type="image/png" />
    <title>GumCP GPIO</title>
    <link href="./static/css.php" rel="stylesheet" type="text/css">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <script src="./static/js.php" type="text/javascript"></script>
    <script>
    var CSRF_TOKEN  = <?php echo json_encode($_SESSION['csrf_token']); ?>;
    var gpioChanged = false;

    // Single AJAX helper shared by all three switch types.
    function gpioRequest(action, extraData) {
        var data = { action: action, csrf_token: CSRF_TOKEN };
        $.extend(data, extraData);
        $.ajax({
            type: 'POST',
            url: 'ajax.php',
            data: data,
            dataType: 'json',
            success: function(resp) {
                gpioChanged = true;
                alert(resp.message || (resp.type === 'success' ? 'Done' : 'Error'));
                location.reload();
            },
            error: function() {
                alert('Error communicating with server');
                location.reload();
            }
        });
    }

    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();

        $('.switch-mode').bootstrapSwitch();
        $('.switch-v').bootstrapSwitch();
        $('.switch-pullup').bootstrapSwitch();

        $('.switch-mode').on('switchChange.bootstrapSwitch', function(e, state) {
            gpioRequest('change_mode', { bcm: $(this).data('bcm'), mode: state ? 'out' : 'in' });
        });

        $('.switch-v').on('switchChange.bootstrapSwitch', function(e, state) {
            gpioRequest('change_v', { bcm: $(this).data('bcm'), v: state ? 1 : 0 });
        });

        $('.switch-pullup').on('switchChange.bootstrapSwitch', function(e, state) {
            gpioRequest('change_mode', { bcm: $(this).data('bcm'), mode: state ? 'up' : 'down' });
        });

        window.onbeforeunload = function() {
            if (gpioChanged) {
                return 'You have changed GPIO settings. Are you sure you want to leave?';
            }
        };
    });
    </script>
</head>

<body>
<div class="container">

    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="./index.php">
                    <img src="./static/images/raspberry.png" alt="Logo" />GumCP
                </a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav navbar-right">
                    <?php require_once('./include/menu.php'); ?>
                </ul>
            </div>
        </div>
    </nav>

    <div class="panel panel-default" style="margin-bottom: 5px">
        <div class="panel-heading">
            <h3 class="panel-title">GPIO Control</h3>
        </div>
        <div class="panel-body">

            <?php if (!empty($message)): ?>
                <div class="alert alert-<?php echo htmlspecialchars($message_type, ENT_QUOTES, 'UTF-8'); ?>" role="alert">
                    <i class="fa fa-<?php echo $message_type === 'warning' ? 'exclamation-triangle' : 'times-circle'; ?>"></i>
                    <?php echo htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?>
                </div>
            <?php endif; ?>

            <?php if ($gpio_source === 'raspi-gpio'): ?>
                <!-- raspi-gpio output: plain text, not a '|'-delimited WiringPi table -->
                <pre class="pre-scrollable" style="font-size:12px;"><?php
                    echo htmlspecialchars($gpio_raw, ENT_QUOTES, 'UTF-8');
                ?></pre>

            <?php elseif ($gpio_source === 'wiringpi' && !empty($gpio_rows)): ?>
                <div class="table-responsive">
                    <table class="table table-bordered table-condensed" style="font-size:13px;">
                        <tbody>
                            <?php foreach ($gpio_rows as $k => $row):
                                $meta     = $row_meta[$k];
                                $last_col = count($row) - 1;
                                $left_hl  = $meta['is_left']  ? ' style="background-color:#e8fbe8"' : '';
                                $right_hl = $meta['is_right'] ? ' style="background-color:#e8fbe8"' : '';
                                $bcm_l    = htmlspecialchars($meta['bcm_left'],  ENT_QUOTES, 'UTF-8');
                                $bcm_r    = htmlspecialchars($meta['bcm_right'], ENT_QUOTES, 'UTF-8');
                            ?>
                                <tr>
                                    <?php foreach ($row as $i => $cell):
                                        $col_header = strtolower(trim($gpio_rows[0][$i] ?? ''));
                                        $is_left_col    = ($physical_col >= 0) ? $i < $physical_col  : false;
                                        $is_right_col   = ($physical_col >= 0) ? $i > $physical_col  : false;
                                        $is_physical_col = $i === $physical_col;

                                        $is_gpio_cell = ($is_left_col && $meta['is_left'])
                                                     || ($is_right_col && $meta['is_right']);
                                        $hl  = $is_left_col  ? $left_hl  : ($is_right_col ? $right_hl : '');
                                        $bcm = $is_left_col  ? $bcm_l    : ($is_right_col ? $bcm_r    : '');

                                        $cell_esc = htmlspecialchars($cell, ENT_QUOTES, 'UTF-8');
                                    ?>
                                        <td<?php echo $hl; ?> <?php echo $is_physical_col ? 'style="text-align:center"' : ''; ?>>
                                            <?php if ($is_gpio_cell && $col_header === 'mode'): ?>
                                                <input class="switch-mode" type="checkbox"
                                                       <?php echo strtolower($cell) === 'out' ? 'checked' : ''; ?>
                                                       data-on-text="OUT" data-off-text="IN"
                                                       data-bcm="<?php echo $bcm; ?>">

                                            <?php elseif ($is_gpio_cell && $col_header === 'v'): ?>
                                                <input class="switch-v" type="checkbox"
                                                       <?php echo $cell === '1' ? 'checked' : ''; ?>
                                                       data-on-text="HIGH" data-off-text="LOW"
                                                       data-bcm="<?php echo $bcm; ?>">

                                            <?php elseif ($is_gpio_cell && $col_header === 'pud'): ?>
                                                <input class="switch-pullup" type="checkbox"
                                                       <?php echo strtolower($cell) === 'up' ? 'checked' : ''; ?>
                                                       data-on-text="UP" data-off-text="DOWN"
                                                       data-bcm="<?php echo $bcm; ?>">

                                            <?php elseif ($is_physical_col): ?>
                                                <strong><?php echo htmlspecialchars(
                                                    str_replace('||', ' | ', $cell),
                                                    ENT_QUOTES, 'UTF-8'
                                                ); ?></strong>

                                            <?php elseif ($col_header === 'bcm'): ?>
                                                <strong><?php echo $cell_esc; ?></strong>

                                            <?php elseif ($col_header === 'name'): ?>
                                                <?php
                                                $name_label = gpio_name_label($cell);
                                                $is_power = in_array($name_label, ['GND', '3.3V', '5V'], true);
                                                ?>
                                                <?php if ($is_power): ?>
                                                    <span class="label label-<?php echo $name_label === 'GND' ? 'default' : 'danger'; ?>"
                                                          style="font-size:14px; padding:.3em .6em"><?php
                                                        echo htmlspecialchars($name_label, ENT_QUOTES, 'UTF-8'); ?></span>
                                                <?php else: ?>
                                                    <?php echo htmlspecialchars($name_label, ENT_QUOTES, 'UTF-8'); ?>
                                                <?php endif; ?>

                                            <?php else: ?>
                                                <?php echo $cell_esc; ?>
                                            <?php endif; ?>
                                        </td>
                                    <?php endforeach; ?>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div class="alert alert-warning" role="alert" style="margin-top: 15px;">
                    <i class="fa fa-exclamation-triangle"></i>
                    <strong>Warning:</strong> Incorrect GPIO configuration can damage your Raspberry Pi or connected hardware.
                </div>

                <div class="panel panel-info" style="margin-top: 15px;">
                    <div class="panel-heading">
                        <h4 class="panel-title">Legend</h4>
                    </div>
                    <div class="panel-body">
                        <ul class="list-unstyled" style="margin-bottom:0;">
                            <li><strong>BCM</strong> — Broadcom pin number</li>
                            <li><strong>wPi</strong> — WiringPi pin number</li>
                            <li><strong>Name</strong> — Pin function</li>
                            <li><strong>Mode</strong> — IN (input) / OUT (output)</li>
                            <li><strong>V</strong> — Current voltage level (0 or 1)</li>
                            <li><strong>Physical</strong> — Physical pin number on the header</li>
                            <li><strong>PUD</strong> — Pull-up / Pull-down resistor</li>
                            <li style="margin-top:8px; background:#e8fbe8; padding:4px 6px; border-radius:3px;">
                                <strong>Green background</strong> — Controllable GPIO pin
                            </li>
                            <li style="margin-top:4px;">
                                <span class="label label-danger">3.3V</span> /
                                <span class="label label-danger">5V</span> —
                                power pins, <span class="label label-default">GND</span> — ground.
                                These are fixed and cannot be switched.
                            </li>
                        </ul>
                    </div>
                </div>

            <?php else: ?>
                <!-- gpio_source === 'none': both tools failed -->
                <div class="alert alert-danger" role="alert">
                    <i class="fa fa-times-circle"></i>
                    <?php echo htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?>
                </div>
            <?php endif; ?>

        </div>
    </div>

</div>

<footer class="footer">
    <div class="container">
        <p class="text-muted">
            GumCP <a href="https://github.com/gumslone/GumCP" target="_blank" rel="noopener">GitHub</a>.
            <a href="https://www.paypal.com/donate/?hosted_button_id=VCWHQPACTXV5N" target="_blank" rel="noopener">
                <img src="./static/images/Donate-PayPal-green.svg" alt="Donate"/>
            </a>
        </p>
    </div>
</footer>

</body>
</html>
