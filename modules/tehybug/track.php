<?php
header("Cache-Control: no-cache, must-revalidate");
$db = new SQLite3('tehybug.sqlite');


if(empty($_REQUEST['bug_key']))
{
	$_REQUEST['bug_key'] = ($_REQUEST['sensor']);
}
		
$statement = $db->prepare('SELECT bug_id,bug_key FROM tehybugs WHERE bug_key = :bug_key LIMIT 1;');
$statement->bindValue(':bug_key', trim($_REQUEST['bug_key']));
$result = $statement->execute();
$bug = $result->fetchArray(SQLITE3_ASSOC);
#print_r($bug);
#file_put_contents('./static/db/'.$_REQUEST['bug_key'].date("Y-m-d").'_sensor_data.txt', 'time='.time().'&'.$_SERVER['QUERY_STRING']."\n", FILE_APPEND | LOCK_EX);

if($bug['bug_id']>0)
{

	$sql = $db->prepare("INSERT INTO tehybug_data (data_bug_id, data_bug_key, data_details, data_time) VALUES (:data_bug_id, :data_bug_key, :data_details, :data_time)");
	$data = array(
					'data_bug_id' => $bug['bug_id'],
					'data_bug_key' => $bug['bug_key'],
					'data_details' => json_encode($_REQUEST),
					'data_time' => time()
				);
	foreach ($data as $key => $value) {
		$sql->bindValue(':'.$key, $value);
	}
	$sql->execute();
}

echo 'OK';
?>