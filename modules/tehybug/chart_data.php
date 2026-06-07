<?php
declare(strict_types=1);

require_once('../../include/init.php');

header('Content-Type: application/json; charset=UTF-8');

$act        = (string)($_GET['act']         ?? '');
$bug_id     = (int)   ($_GET['tehy_bug_id'] ?? 0);
$date_param = (string)($_GET['date']        ?? date('Y-m-d'));

if ($act !== 'by_date' || $bug_id <= 0) {
    echo json_encode([[], [], [], []]);
    exit();
}

$parts = explode('-', $date_param);
if (count($parts) !== 3) {
    echo json_encode([[], [], [], []]);
    exit();
}
[$year, $month, $day] = $parts;
$start = mktime(0, 0, 0, (int)$month, (int)$day, (int)$year);
$end   = $start + 86400;

$db = new SQLite3(__DIR__ . '/tehybug.sqlite');
$db->busyTimeout(3000);

$stmt = $db->prepare(
    'SELECT data_details, data_time
     FROM tehybug_data
     WHERE data_bug_id = :id
       AND data_time BETWEEN :start AND :end
     ORDER BY data_time ASC'
);
$stmt->bindValue(':id',    $bug_id, SQLITE3_INTEGER);
$stmt->bindValue(':start', $start,  SQLITE3_INTEGER);
$stmt->bindValue(':end',   $end,    SQLITE3_INTEGER);
$result = $stmt->execute();

$times  = [];
$temps  = [];
$humis  = [];
$press  = [];

while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
    $d = json_decode($row['data_details'], true);
    if (!is_array($d)) continue;

    $times[] = date('Y-m-d / H:i', (int)$row['data_time']);

    $temps[] = isset($d['t']) ? (float)$d['t'] : null;

    if (isset($d['h'])) $humis[] = (float)$d['h'];
    if (isset($d['p'])) $press[] = (float)$d['p'];
}

$out = [$times, $temps, $humis, $press];

header('Cache-Control: max-age=300');

$accept = (string)($_SERVER['HTTP_ACCEPT_ENCODING'] ?? '');
if (strpos($accept, 'gzip') !== false && function_exists('ob_gzhandler')) {
    header('Content-Encoding: gzip');
    ob_start('ob_gzhandler');
}

echo json_encode($out);
