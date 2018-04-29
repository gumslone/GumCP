<?php
	
include_once('../../include/config.php');
	
$db = new SQLite3('tehybug.sqlite');

$type = $_GET['type'];

$start_date = $_GET['start_date'];
$end_date = $_GET['end_date'];
$days = $_GET['days'];
$act = $_GET['act'];
$tehy_bug_id = $_GET['tehy_bug_id'];
$supports_gzip = strpos($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip') !== false;
$date = $_REQUEST['date'];

if($act == 'by_date')
{

	
	list($year,$month,$day) = explode('-', $date);
	
	$startTime = mktime(0, 0, 0, $month, $day, $year);
	$endTime = $startTime + 24*3600;
	$q = "SELECT A.* FROM tehybug_data A WHERE A.data_bug_id IN (".intval($tehy_bug_id).") AND A.data_time BETWEEN ".$startTime." AND ".$endTime." ORDER BY A.data_time ASC ";
	
	$statement = $db->prepare($q);
	$result = $statement->execute();
	while($bug = $result->fetchArray(SQLITE3_ASSOC))
	{
		$arr[] = $bug;
	}
	#$arr = array_reverse($arr);
	//print_r($arr);
	$out = array();
	//$arr = array_reverse($arr);
	foreach($arr as $a)
	{
		$a['date'] = date('Y-m-d / H:i');
		$out[0][] = date('Y-m-d / H:i',$a['data_time']);
		$json_arr = json_decode($a['data_details'],true);
		$out[1][] = (int)$json_arr['t'];
		if(isset($json_arr['h']))
			$out[2][] = (int)$json_arr['h'];
		
		if(isset($json_arr['p']))
			$out[3][] = (int)$json_arr['p'];
		//$out[] = $a;
	}
	
	if(!isset($out[2]))
		$out[2] = array();
	if(!isset($out[3]))
		$out[3] = array();
	
	header('Cache-Control: max-age=300');
	header('Content-type: application/json; charset=UTF-8'); 
	if($supports_gzip)
	{
		header('Content-Encoding: gzip');
		ob_start("ob_gzhandler");
	}
	echo json_encode($out);
	exit();
}	
	
?>