<?php
declare(strict_types=1);

header('Cache-Control: no-cache, must-revalidate');
header('Content-Type: text/plain; charset=UTF-8');

$db = new SQLite3(__DIR__ . '/tehybug.sqlite');
$db->busyTimeout(3000);

// Sensor posts either bug_key or chipid/sensor as the device identifier.
$key = trim((string)($_REQUEST['bug_key'] ?? $_REQUEST['sensor'] ?? ''));

if ($key === '') {
    http_response_code(400);
    echo 'ERR: missing key';
    exit();
}

$stmt = $db->prepare(
    'SELECT bug_id, bug_key FROM tehybugs WHERE bug_key = :key LIMIT 1'
);
$stmt->bindValue(':key', $key, SQLITE3_TEXT);
$row = $stmt->execute()->fetchArray(SQLITE3_ASSOC);

if (empty($row['bug_id'])) {
    http_response_code(404);
    echo 'ERR: unknown key';
    exit();
}

// Store only the numeric sensor fields — never dump raw $_REQUEST into the DB.
$allowed = ['t', 'h', 'p', 'chipid', 'sensor'];
$details = [];
foreach ($allowed as $field) {
    if (isset($_REQUEST[$field]) && $_REQUEST[$field] !== '') {
        $details[$field] = $_REQUEST[$field];
    }
}

$ins = $db->prepare(
    'INSERT INTO tehybug_data (data_bug_id, data_bug_key, data_details, data_time)
     VALUES (:bug_id, :bug_key, :details, :ts)'
);
$ins->bindValue(':bug_id',  (int)$row['bug_id'],  SQLITE3_INTEGER);
$ins->bindValue(':bug_key', $row['bug_key'],       SQLITE3_TEXT);
$ins->bindValue(':details', json_encode($details), SQLITE3_TEXT);
$ins->bindValue(':ts',      time(),                SQLITE3_INTEGER);
$ins->execute();

echo 'OK';
