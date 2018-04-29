<?php

	include_once('../../include/config.php');
	if($gumcp_modules['tehybug']['module_active']!=1)
	{
		header("HTTP/1.0 404 Not Found");
		exit();
	}
	#error_reporting(E_ALL);
	#ini_set('display_errors', 1);
	
	$db = new SQLite3('tehybug.sqlite');
	
	$sql = <<<SQL
CREATE TABLE IF NOT EXISTS tehybugs (
    bug_id INTEGER PRIMARY KEY AUTOINCREMENT,
    bug_key CHAR(50),
    bug_title CHAR(50),
    bug_description TEXT,
    bug_details TEXT,
    bug_type CHAR(10),
    bug_settings TEXT,
    bug_position INTEGER,
    bug_last_active INTEGER,
    bug_time INTEGER
)
SQL;
    $db->exec($sql);
    
    $sql = <<<SQL
CREATE TABLE IF NOT EXISTS tehybug_data (
    data_id INTEGER PRIMARY KEY AUTOINCREMENT,
    data_bug_id INTEGER,
    data_bug_key CHAR(50),
    data_details TEXT,
    data_time INTEGER
)
SQL;

	$db->exec($sql);


	$action = $_REQUEST['action'];
	
	if($action=='add_tehybug')
	{
		if(create_tehybug($_REQUEST))
			echo json_encode(array('success'=>1));
		else
			echo json_encode(array('danger'=>1));
		exit();
	}
	elseif($action=='update_tehybug')
	{
		if(update_tehybug($_REQUEST))
			echo json_encode(array('success'=>1));
		else
			echo json_encode(array('danger'=>1));
		exit();
	}
	elseif($action=='delete_tehybug')
	{
		if(delete_tehybug($_REQUEST))
			echo json_encode(array('success'=>1));
		else
			echo json_encode(array('danger'=>1));
		exit();
	}
	elseif($action=='order_tehybugs')
	{
		if(order_tehybugs($_REQUEST))
			echo json_encode(array('success'=>1));
		else
			echo json_encode(array('danger'=>1));
		exit();
	}
	
	
	
		
	function create_tehybug($vars)
	{
		global $db;
		
		$statement = $db->prepare('SELECT * FROM tehybugs WHERE bug_key = :bug_key LIMIT 1;');
		$statement->bindValue(':bug_key', $vars['bug_key']);
		$result = $statement->execute();
		#print_r($result);
		$bug = $result->fetchArray(SQLITE3_ASSOC);
		#print_r($bug);
		if(empty($bug['bug_id']))
		{
			
			$settings = array();
			$settings['system'] = $vars['bug_settings_system'];
			$data = array(
				'bug_key' => trim($vars['bug_key']),
				'bug_title' => $vars['bug_title'],
				'bug_settings' => json_encode($settings),
				'bug_time' => time()
			);
			#print_r($data);
			$sql = $db->prepare("INSERT INTO tehybugs (bug_key, bug_title, bug_settings, bug_time) VALUES (:bug_key, :bug_title, :bug_settings, :bug_time)");
			foreach ($data as $key => $value) {
				#$sql->bindParam(':'.$key, $value);
				$sql->bindValue(':'.$key, $value);
			}
			$sql->execute();
			#var_dump($result->fetchArray());
			
			$sql = $db->prepare("UPDATE tehybug_data SET data_bug_id= :data_bug_id WHERE data_bug_key=:data_bug_key");
			$last_id = $db->lastInsertRowID();
			$sql->bindParam(':data_bug_id', $last_id);
			$sql->bindParam(':data_bug_key', $vars['bug_key']);
			$sql->execute();
			return true;

		}
		else
		{
			return false;
		}
	}
	
	function update_tehybug($vars)
	{
		global $db;
		
		$statement = $db->prepare('SELECT * FROM tehybugs WHERE bug_id = :bug_id LIMIT 1;');
		$statement->bindValue(':bug_id', $vars['bug_id']);
		$result = $statement->execute();
		#print_r($result);
		$bug = $result->fetchArray(SQLITE3_ASSOC);
		#print_r($bug);
		
		if($bug['bug_id']>0)
		{
			#print_r($vars);
			$settings = (array)json_decode($bug['bug_settings'],true);
			$settings['system'] = $vars['bug_settings_system'];
			$data = array(
				'bug_id' => $bug['bug_id'],
				'bug_title' => $vars['bug_title'],
				'bug_description' => $vars['bug_description'],
				'bug_settings' => json_encode($settings),
				
				'bug_time' => time()
			);
			$sql = $db->prepare("UPDATE tehybugs SET bug_key=:bug_key, bug_title=:bug_title, bug_settings=:bug_settings, bug_description=:bug_description, bug_time=:bug_time WHERE bug_id=:bug_id");
			foreach ($data as $key => $value) {
				#$sql->bindParam(':'.$key, $value);
				$sql->bindValue(':'.$key, $value);
			}
			$sql->execute();
			return true;
		}
		else
		{
			return false;
		}
	}
	
	function delete_tehybug($vars)
	{
		global $db;
		
			
			$sql = "DELETE FROM tehybugs WHERE bug_id=".intval($vars['bug_id'])."";
			$db->exec($sql);
			
			$sql = "DELETE FROM tehybug_data WHERE data_bug_id=".intval($vars['bug_id'])."";
			$db->exec($sql);
			return true;
	}
	
	function order_tehybugs($vars)
	{
		global $db;
		
		$ids = explode(',', $vars['order']);
		#echo $vars['order'];
		for($i=0;$i<count($ids);$i++)
		{
			$ids[$i] = str_replace('bug_id_', '', $ids[$i]);
			$sql = "UPDATE tehybugs SET bug_position=>".$i." WHERE bug_id=".intval($ids[$i])."";
			$db->exec($sql);
		}
		return true;

	}
	
	$statement = $db->prepare('SELECT * FROM tehybugs ORDER BY bug_position LIMIT 100;');
	$result = $statement->execute();
	while($bug = $result->fetchArray(SQLITE3_ASSOC))
	{
		$bug['bug_settings'] = json_decode($bug['bug_settings'],TRUE);
		$tehybugs_arr[] = $bug;
		$tehybugs_json_arr[$bug['bug_id']] = $bug;
	}
	#print_r($tehybugs_arr);
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta http-equiv="cache-control" content="max-age=0" />
<meta http-equiv="cache-control" content="no-cache" />
<meta http-equiv="expires" content="0" />
<meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
<meta http-equiv="pragma" content="no-cache" />

<meta name="theme-color" content="#ffffff">
<title>TeHyBug - Low Power Temperature and Humidity WiFi tracker for your SmartHome</title>
<script src="//code.jquery.com/jquery-2.1.3.min.js"></script>

<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="../../static/css.php">
<script src="https://code.highcharts.com/highcharts.js"></script>



<script src="../../static/js.php"></script>

<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>

<script
  src="http://code.jquery.com/ui/1.12.1/jquery-ui.min.js"
  integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU="
  crossorigin="anonymous"></script>
  
<script>new WOW().init();</script>
<style>

.ui-datepicker {
	background-color: #fff;
	border: 1px solid #66AFE9;
	border-radius: 4px;
	box-shadow: 0 0 8px rgba(102,175,233,.6);
	display: none;
	margin-top: 10px;
	padding: 10px;
	width: 240px;
}
.ui-datepicker a,
.ui-datepicker a:hover {
	text-decoration: none;
}
.ui-datepicker a:hover,
.ui-datepicker td:hover a {
	color: #2A6496;
	-webkit-transition: color 0.1s ease-in-out;
	   -moz-transition: color 0.1s ease-in-out;
	     -o-transition: color 0.1s ease-in-out;
	        transition: color 0.1s ease-in-out;
}
.ui-datepicker .ui-datepicker-header {
	margin-bottom: 4px;
	text-align: center;
}
.ui-datepicker .ui-datepicker-title {
	font-weight: 700;
}
.ui-datepicker .ui-datepicker-prev,
.ui-datepicker .ui-datepicker-next {
	cursor: default;
	font-family: 'Glyphicons Halflings';
	-webkit-font-smoothing: antialiased;
	font-style: normal;
	font-weight: normal;
	height: 20px;
	line-height: 1;
	margin-top: 2px;
	width: 30px;
}
.ui-datepicker .ui-datepicker-prev {
	float: left;
	text-align: left;
}
.ui-datepicker .ui-datepicker-next {
	float: right;
	text-align: right;
}
.ui-datepicker .ui-datepicker-prev:before {
	content: "\e079";
}
.ui-datepicker .ui-datepicker-next:before {
	content: "\e080";
}
.ui-datepicker .ui-icon {
	display: none;
}
.ui-datepicker .ui-datepicker-calendar {
  table-layout: fixed;
	width: 100%;
}
.ui-datepicker .ui-datepicker-calendar th,
.ui-datepicker .ui-datepicker-calendar td {
	text-align: center;
	padding: 4px 0;
}
.ui-datepicker .ui-datepicker-calendar td {
	border-radius: 4px;
	-webkit-transition: background-color 0.1s ease-in-out, color 0.1s ease-in-out;
	   -moz-transition: background-color 0.1s ease-in-out, color 0.1s ease-in-out;
	     -o-transition: background-color 0.1s ease-in-out, color 0.1s ease-in-out;
	        transition: background-color 0.1s ease-in-out, color 0.1s ease-in-out;
}
.ui-datepicker .ui-datepicker-calendar td:hover {
	background-color: #eee;
	cursor: pointer;
}
.ui-datepicker .ui-datepicker-calendar td a {
	text-decoration: none;
}
.ui-datepicker .ui-datepicker-current-day {
	background-color: #4289cc;
}
.ui-datepicker .ui-datepicker-current-day a {
	color: #fff
}
.ui-datepicker .ui-datepicker-calendar .ui-datepicker-unselectable:hover {
	background-color: #fff;
	cursor: default;
}

</style>

<script>


</script>
</head>
<body>


<script>
var chart;

	
var tehy_bugs = <?php echo json_encode($tehybugs_json_arr);?>;


jQuery(document).ready(function() {
	
	for (var k in tehy_bugs) {
		create_chart(''+tehy_bugs[k].bug_id+'','chart_bug_id_'+tehy_bugs[k].bug_id+'','<?php echo date("Y-m-d");?>');
	}
	
			//override the existing _goToToday functionality
	$.datepicker._gotoTodayOriginal = $.datepicker._gotoToday;
	$.datepicker._gotoToday = function(id) {
		// now, optionally, call the original handler, making sure
		//  you use .apply() so the context reference will be correct
		$.datepicker._gotoTodayOriginal.apply(this, [id]);
		$.datepicker._selectDate.apply(this, [id]);
		
		
	};
			//override the existing _goToToday functionality
	$.datepicker._gotoTodayOriginal = $.datepicker._gotoToday;
	$.datepicker._gotoToday = function(id) {
		// now, optionally, call the original handler, making sure
		//  you use .apply() so the context reference will be correct
		$.datepicker._gotoTodayOriginal.apply(this, [id]);
		$.datepicker._selectDate.apply(this, [id]);
		
		
	};
	
	
	jQuery(".sortable").sortable({
		items: ".panel-sortable",
		cancel: ".chart,.collapse,.stats_date",
		//helper: fixHelper,
		start: function( event, ui ) {

		},
		update: function(event, ui) {
			var order = jQuery(this).sortable('toArray').toString();
			jQuery.ajax({ 
				type: 'POST', 
				url: './index.php', 
				data: { action: 'order_tehybugs', 'order': order},
				dataType:'json',
				success: function (data) { 
				}
			});
		},
		stop: function(event, ui) {

		}
	});
	
	
	var dates = jQuery('.stats_date').datepicker({
		//minDate: new Date(2015, 6, 1), 
		maxDate: 0,
		dateFormat: "yy-mm-dd",
		changeMonth: true,
		changeYear: true,
		onSelect: function (selectedDate)
		{
			var id = $(this).attr('id');
			var tehy_bug_id = id.replace(/stats_date_/g, "");
			create_chart(tehy_bug_id,'chart_bug_id_'+tehy_bug_id,jQuery(this).val());
		}
	});	
	


	
	
	
	
});

jQuery( window ).load(function() {
	

	
	
});

function create_chart(tehy_bug_id,container,date)
{

//F = °C × 1,8 + 32
//var chart;
// define the options
var options = {
	chart: {
		zoomType: 'x',
		renderTo: container,
		defaultSeriesType: 'line',
		marginRight: 45,
		marginTop: 30,
		marginBottom: 90
	},
	colors: ['#AA4643', '#3b6290',  '#728a41', '#80699B', '#3D96AE', 
   '#DB843D', '#92A8CD', '#A47D7C', '#B5CA92'],
	credits: {
		enabled: true
	},
	title: {
		text: null,
		x: -20 //center
	},
	subtitle: {
		text: '',
		x: -20
	},
	xAxis: {
		categories: [],
		labels: {
			rotation: -45,
			align: 'right',
			y:8
		}
	},
	yAxis: [{
		min: -20,
		title: {
			text: ''
		},
		plotLines: [{
			value: 0,
			width: 1,
		}]
	}, { // Secondary yAxis
		min: -20,
		title: {
			text: '',
			style: {
			}
		},
		labels: {
			
			formatter: function() {
				//return '$'+this.value;
				return this.value;
			},
			style: {
			}
		},
		opposite: true
	},
	{ // Third yAxis
		min: -20,
		title: {
			text: '',
			style: {
			}
		},
		labels: {
			enabled: false,
			formatter: function() {
				return this.value;
			},
			style: {
			}
		},
		opposite: true
	}],
	tooltip: {
		formatter: function() {
			//var s = '<b>'+ Highcharts.dateFormat('%Y-%m-%d (%H:%M)',this.x) +'</b>';
			var s = '<b>'+ this.x +'</b>';
			var imp = 1;
			var clk = 0;
			$.each(this.points, function(i, point) {
				s += '<br/><span style="color:'+point.series.color+';">'+ point.series.name +'</span>: ';
				
				s += point.y +'';
				if(point.series.name == 'Temperature')
				{
					if(tehy_bugs[tehy_bug_id].bug_settings.system=='imperial')
					{
						s += ' °F';
					}
					else
					{
						 s += ' °C';
					}
				}
				if(point.series.name=='Humidity') s += ' %';
				if(point.series.name=='Pressure')
				{
					
					if(tehy_bugs[tehy_bug_id].bug_settings.system=='imperial')
					{
						s += ' inHg';
					}
					else
					{
						 s += ' hPa';
					}
					 
				}
			});
			return s;
		},
		crosshairs: {
				width: 30,
				color: '#eeeeee',
				zIndex: 0.5
		},
		shared: true
	},
	legend: {
		align: 'right',
		verticalAlign: 'top',
		y: -15,
		floating: false,
		borderWidth: 0
	},
	series: [

	],
	navigation: {
	buttonOptions: {
		verticalAlign: 'bottom',
		y: 0
		}
	}
	
	
}

jQuery.getJSON('./chart_data.php?act=by_date&tehy_bug_id='+tehy_bug_id+'&date='+date+'', function(json) {
	
		var deg;
		var p_unit;
		//alert(tehy_bugs[tehy_bug_id].settings);
		if(tehy_bugs[tehy_bug_id].bug_settings.system=='imperial')
		{
			//F = °C × 1,8 + 32
			deg = ' °F';
			for(var i=0;i<json[1].length;i++)
			{
				json[1][i]= Math.round((json[1][i] * 1.8 + 32) * 100) / 100;
			}
			
			//Pressure(hPa) = Pressure (inHg) × 33.86389
			p_unit = ' inHg';
			for(var i=0;i<json[3].length;i++)
			{
				json[3][i]= Math.round((json[3][i] / 33.86389) * 100) / 100;
			}
		}
		else
		{
			 deg = ' °C';
			 p_unit = ' hPa';
		}
		
		//jQuery('#bug_id_'+tehy_bug_id+' .count-entries').text(json[0].length);
		options.xAxis.categories = json[0];
		//options.series[0].data = json[1];
		if(json[1].length > 0)
		{
			
			var obj = new Object();
			obj.name = 'Temperature';
			obj.yAxis = 0;
			obj.data = json[1];
			options.series.push(obj);
		}
		if(json[2].length > 0)
		{
			var obj = new Object();
			obj.name = 'Humidity';
			obj.yAxis = 1;
			obj.data = json[2];
			options.series.push(obj);
		}
		if(json[3].length > 0)
		{
			var obj = new Object();
			obj.name = 'Pressure';
			obj.yAxis = 2;
			obj.data = json[3];
			options.series.push(obj);
		}
		chart = new Highcharts.Chart(options);
		
		
		if(json[0]!=null)
		{
			var col_width = 3;
			if(json[1].length >0 && json[2].length==0 && json[3].length > 0)
				col_width = 4;
			if(json[1].length >0 && json[2].length>0 && json[3].length == 0)
				col_width = 4;
				
			var last_data_html = '<div class="col-lg-'+col_width+'"><div style="padding: 10px;"><b style="font-size:1.5em;">Last measurement</b><br/>'+json[0][json[0].length-1]+'</div></div>';
			var last_temp = json[1][json[1].length-1];
			last_data_html += '<div class="col-lg-'+col_width+'"><div style="padding: 10px;"><span style="font-size:30px">'; 
			if(last_temp < 18)
			{
				last_data_html += '<img src="./static/images/temperature_low.svg" data-toggle="tooltip" title="Low!" style="height:30px;vertical-align: middle"/> ';
			}
			else if (last_temp > 24)
			{
				last_data_html += '<img src="./static/images/temperature_high.svg" data-toggle="tooltip" title="High!" style="height:30px;vertical-align: middle"/> ';
			}
			else
			{
				last_data_html += '<img src="./static/images/temperature_middle.svg" data-toggle="tooltip" title="Normal" style="height:30px;vertical-align: middle"/> ';
			}
			last_data_html += ''+ last_temp +' '+deg+'</span></div></div>';
			//$('#bug_id_'+tehy_bug_id+' .last_temperature').html(last_temp_html);
			
			if(json[2].length > 0)
			{
				var last_humi = json[2][json[2].length-1];
				last_data_html += '<div class="col-lg-'+col_width+'"><div style="padding: 10px;"><span style="font-size:30px">';
				if(last_humi < 30)
				{
					last_data_html += '<img src="./static/images/humidity_low.svg" data-toggle="tooltip" title="Low!" style="height:30px;vertical-align: middle"/> ';
				}
				else if (last_humi > 50)
				{
					last_data_html += '<img src="./static/images/humidity_high.svg" data-toggle="tooltip" title="High!" style="height:30px;vertical-align: middle"/> ';
				}
				else
				{
					last_data_html += '<img src="./static/images/humidity_middle.svg" data-toggle="tooltip" title="Normal" style="height:30px;vertical-align: middle"/> ';
				}
				last_data_html += ''+ last_humi +' %</span></div></div>';
				//$('#bug_id_'+tehy_bug_id+' .last_humidity').html(last_humi_html);
			}
			
			if(json[3].length > 0)
			{
				var last_press = json[3][json[3].length-1];
				last_data_html += '<div class="col-lg-'+col_width+'"><div style="padding: 10px;"><span style="font-size:30px">';
				last_data_html += '<img src="./static/images/pressure.svg" data-toggle="tooltip" title="Normal" style="height:30px;vertical-align: middle"/> ';
				
				last_data_html += ''+ last_press +' '+p_unit+'</span></div></div>';
				
			}
			$('#bug_id_'+tehy_bug_id+' .last_data').html(last_data_html);
			
		}
		
		
		
		
		
});

	chart = new Highcharts.Chart(options);
}


function change_stats_day(tehy_bug_id)
{
	create_chart(tehy_bug_id,'chart_bug_id_'+tehy_bug_id,$('#stats_date_'+tehy_bug_id+'').val());


}

function tehybug_settings(tehy_bug_id, tehy_bug_title, tehy_bug_settings_system)
{
	var html = '';
	html += '<div class="form-group">';
			html += '<label for="tehybug_title">TehyBug Title (i.e. room name):</label>';
			html += '<input type="text" class="form-control" id="tehybug_title" placeholder="Kitchen" name="tehybug_title" value="'+tehy_bug_title+'">';
		html += '</div>';
		html += '<div class="form-group">';
			html += '<label for="tehybug_title">System:</label>';
			html += '<div class="radio" style="padding-left:20px;">';
				html += '<input type="radio" name="tehybug_settings_system" id="metric" value="metric"';
				if(tehy_bug_settings_system=='metric'||tehy_bug_settings_system=='')html += ' checked="checked"';
				html += '><label for="metric">Metric (Celsius)</label>';
			html += '</div>';
			html += '<div class="radio" style="padding-left:20px;">';
				html += '<input type="radio" name="tehybug_settings_system" id="imperial" value="imperial"';
				if(tehy_bug_settings_system=='imperial')html += ' checked="checked"';
				html += '><label for="imperial">Imperial (Fahrenheit)</label>';
			html += '</div>';
		html += '</div>';
	html += '<div class="dialog-actions text-right margin-top-sm">';
	html += '<div class="form-group pull-right">';
	html += '<button type="button" class="btn btn-default" onclick="javascript:jQuery(\'#dialog\').modal(\'hide\');">Cancel</button> ';
	html += ' <button type="button" class="btn btn-default" id="update-tehybug-btn" onclick="javascript:submit_tehybug_settings('+tehy_bug_id+');jQuery(this).prop(\'disabled\', true);">Send</button>';
	html += '<br/><br/><button type="button" class="btn btn-danger" id="delete-tehybug-btn" onclick="javascript:delete_tehybug('+tehy_bug_id+',\''+tehy_bug_title+'\');jQuery(this).prop(\'disabled\', true);">Delete tehybug</button>';
	html += '</div>';
	html += '<div style="clear:both;"></div></div>';
	open_dialog('TeHy-Bug Settings', html);

}

function submit_tehybug_settings(tehy_bug_id)
{
	jQuery('#update-tehybug-btn').prop('disabled', true);
	var tehybug_settings_system = jQuery('input[name=tehybug_settings_system]:checked', '.form-group').val()
	var tehybug_title = jQuery('#tehybug_title').val();
	jQuery.ajax({ 
		type: 'POST', 
		url: './index.php', 
		data: { action: 'update_tehybug', 'bug_id': tehy_bug_id, 'bug_title': tehybug_title, 'bug_settings_system': tehybug_settings_system },
		dataType:'json',
		success: function (data) { 
			
			tehy_bugs[tehy_bug_id].bug_settings.system = tehybug_settings_system;
			create_chart(''+tehy_bug_id+'','chart_bug_id_'+tehy_bug_id+'','2018-04-26');
			
			
		}
	});
	
}
function delete_tehybug(tehy_bug_id, tehy_bug_title)
{
	var answer = confirm('Delete tehybug "'+tehy_bug_title+'" with all data?');
	if (answer)
	{
		jQuery('#delete-tehybug-btn').prop('disabled', true);
		jQuery.ajax({ 
			type: 'POST', 
			url: './index.php', 
			data: { action: 'delete_tehybug', 'bug_id': tehy_bug_id, 'bug_title': tehy_bug_title },
			dataType:'json',
			success: function (data) { 

					jQuery('#bug_id_'+tehy_bug_id).remove();

			}
		});
	}
	
}

</script>


<div class="container">


			<div class="row">
				
				
				<div class="hidden-xs col-sm-3">


					

<script>

function add_tehybug_dialog()
{

	var html = '';


		html += '<div class="form-group">';
			html += '<label for="tehybug_key">TeHyBug Key:</label>';
			html += '<input type="text" class="form-control" id="tehybug_key" name="tehybug_key" placeholder="xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx">';
		html += '</div>';
		html += '<div class="form-group">';
			html += '<label for="tehybug_title">TeHyBug Title (i.e. room name):</label>';
			html += '<input type="text" class="form-control" id="tehybug_title" placeholder="Kitchen" name="tehybug_title">';
		html += '</div>';
		html += '<div class="form-group">';
			html += '<label for="tehybug_title">System:</label>';
			html += '<div class="radio" style="padding-left:20px;">';
				html += '<input type="radio" name="tehybug_settings_system" id="metric" value="metric" checked="checked"><label for="metric">Metric (Celsius)</label>';
			html += '</div>';
			html += '<div class="radio" style="padding-left:20px;">';
				html += '<input type="radio" name="tehybug_settings_system" id="imperial" value="imperial"><label for="imperial">Imperial (Fahrenheit)</label>';
			html += '</div>';
		html += '</div>';



	html += '<div class="dialog-actions text-right margin-top-sm">';

	html += '<div class="form-group pull-right">';
	html += '<button type="button" class="btn btn-default" onclick="javascript:jQuery(\'#dialog\').modal(\'hide\');">Cancel</button> ';
	html += ' <button type="button" class="btn btn-default" id="add-tehybug-btn" onclick="javascript:submit_tehybug();jQuery(this).prop(\'disabled\', true);">Send</button>';
	
	html += '</div>';
	
	html += '<div style="clear:both;"></div></div>';
	
	open_dialog('Add a TeHyBug', html);

}

function submit_tehybug()
{
	jQuery('#add-tehybug-btn').prop('disabled', true);
	var tehybug_key = jQuery('#tehybug_key').val();
	var tehybug_title = jQuery('#tehybug_title').val();
	jQuery.ajax({ 
		type: 'POST', 
		url: './index.php', 
		data: { action: 'add_tehybug', 'bug_key': tehybug_key, 'bug_title': tehybug_title },
		dataType:'json',
		success: function (data) { 
			window.location.reload(true);
			
		}
	});
	
}

function configure_dialog()
{
	
	open_dialog('How to configure', jQuery('#how_to_configure').html());
}

</script>


					
					
					<div style="clear: both;margin-bottom: 15px;"></div>
					<div class="ls-menu list-group">
						<a href="javascript:void(0);" onclick="javascript:add_tehybug_dialog();" style="text-shadow: white -1px 1px;" class="list-group-item"><i class="fa fa-plus fa-fw"></i>&nbsp; Add a TeHyBug</a>
						<a href="javascript:void(0);" onclick="javascript:configure_dialog();" style="text-shadow: white -1px 1px;" class="list-group-item"><i class="fa fa-plus fa-fw"></i>&nbsp; How to configure a TeHyBug</a>
				
					</div>
					
					<div class="well well-sm">Order your TeHyBug from:<br/><a href="https://www.tindie.com/stores/gumslone/?ref=offsite_badges&utm_source=sellers_gumslone&utm_medium=badges&utm_campaign=badge_large"><img src="https://d2ss6ovg47m0r5.cloudfront.net/badges/tindie-larges.png" alt="I sell on Tindie" width="200" height="104"></a><br/> or www.tehybug.com</div>
					
					
					
										
					
					





				</div>
				
				
				<div class="col-md-9 col-xs-12 col-sm-9">
					
					
					<?php
					if(is_array($tehybugs_arr))
					{
						foreach($tehybugs_arr as $bug)
						{
					?>
						<div class="row sortable">
							<div class="panel panel-default panel-sortable" id="bug_id_<?php echo $bug['bug_id']; ?>" data-bug-id="<?php echo $bug['bug_id']; ?>" >
								<div class="panel-heading">
										<h3 class="panel-title"><b><?php echo $bug['bug_title']; ?></b>											<input type="text" name="stats_date" id="stats_date_<?php echo $bug['bug_id']; ?>" class="form-control input-sm stats_date" style="width:90px;display:inline;" placeholder="Date" value="<?php echo date("Y-m-d"); ?>"> <div style="display:inline-block;max-width:300px;"></div>
												 <div style="display:inline-block;"><button type="button" onclick="javascript:change_stats_day('<?php echo $bug['bug_id']; ?>');" class="btn btn-default btn-sm"><i class="fa fa-check"></i></button></div>
												 <div style="display:inline-block;"></div>
											
											
											<button class="btn btn-default btn-sm pull-right" onclick="javascript:tehybug_settings('<?php echo $bug['bug_id']; ?>','<?php echo $bug['bug_title']; ?>','');"><i class="fa fa-cog"></i></button>
										</h3>
										
								</div>
								<div class="row last_data">
										
								</div>
								<div id="chart_bug_id_<?php echo $bug['bug_id']; ?>" class="chart margin-top-sm" style="height:350px;width: 100%;"></div>
									
								
								
								
								
								
								
							</div>
						</div><!-- /.row -->
						<?php
							}
						}
						?>	
							
							
							

					
					
					
					<div class="text-center"><ul class="pagination"></ul></div>
					
					
					
					
					
					
					
					
				</div>
				
				
				

				
			</div>

</div>

<div style="display: none" id="how_to_configure">
	TeHyBug s1 and s2 url:
	<div class="well well-sm">http://<?php echo $_SERVER['SERVER_ADDR']. dirname($_SERVER['SCRIPT_NAME']); ?>/track.php?t=%temp%&h=%humi%&chipid=%chipid%&sensor=%sensor%</div>
	TeHyBug s3 url:
	<div class="well well-sm">http://<?php echo $_SERVER['SERVER_ADDR']. dirname($_SERVER['SCRIPT_NAME']); ?>/track.php?t=%temp%&p=%qfe%&chipid=%chipid%&sensor=%sensor%</div>
	TeHyBug s4 url:
	<div class="well well-sm">http://<?php echo $_SERVER['SERVER_ADDR']. dirname($_SERVER['SCRIPT_NAME']); ?>/track.php?t=%temp%&chipid=%chipid%&sensor=%sensor%</div>
	TeHyBug s5 url:
	<div class="well well-sm">http://<?php echo $_SERVER['SERVER_ADDR']. dirname($_SERVER['SCRIPT_NAME']); ?>/track.php?t=%temp%&h=%humi%&p=%qfe%&chipid=%chipid%&sensor=%sensor%</div>
	Also don't forget to define a static IP address for Raspberry Pi in your router configuration.
	
</div>



<div id="dialog-placeholder"></div>


<footer>
<div class="container" style="margin-top: 5px;">



</div>
</footer>

</body>
</html>