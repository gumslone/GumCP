<?php
$active_page = 'dashboard';

include_once('./include/config.php');

$temp = shell_exec('cat /sys/class/thermal/thermal_zone*/temp');
$temp = round($temp / 1000, 1);

$cpuusage = 100 - shell_exec("vmstat | tail -1 | awk '{print $15}'");

$clock = '';
/*$clock = shell_exec('cat /sys/devices/system/cpu/cpu0/cpufreq/scaling_cur_freq');
	$clock = round($clock / 1000);*/



//disk usage
$bytes = disk_free_space(".");
$si_prefix = array( 'B', 'KB', 'MB', 'GB', 'TB', 'EB', 'ZB', 'YB' );
$base = 1024;
$class = min((int)log($bytes , $base) , count($si_prefix) - 1);
$disk_free =  sprintf('%1.2f' , $bytes / pow($base,$class));
$bytes = disk_total_space(".");
$si_prefix = array( 'B', 'KB', 'MB', 'GB', 'TB', 'EB', 'ZB', 'YB' );
$base = 1024;
$class = min((int)log($bytes , $base) , count($si_prefix) - 1);
$disk_total = sprintf('%1.2f' , $bytes / pow($base,$class));

$disk_used = $disk_total - $disk_free;
$disk_percentage = round($disk_used / $disk_total * 100);


$operating_system = shell_exec('uname -a');

$cpu_info = shell_exec('lscpu');
$cpu_info = str_replace("\n", '. ', $cpu_info);


$uptime = shell_exec('uptime -p');

$load = sys_getloadavg();

$processes = shell_exec("ps aux | wc -l");

$top = shell_exec("top -b -n 1 | head -n 30  | tail -n 30");

$users = shell_exec("w");
$users = preg_replace('/^.+\n/', '', $users);

$disks = shell_exec("df");

$date = shell_exec("date");





//memory usage
if(MEMORY_CALCULATION_METHOD==1)
{
	$out = shell_exec('free -m');
	preg_match_all('/\s+([0-9]+)/', $out, $matches);
	list($memory_total, $memory_used, $memory_free, $memory_shared, $memory_buffers, $memory_cached) = $matches[1];

}
else
{
	$top_lines = preg_split("/\\r\\n|\\r|\\n/", $top);
	preg_match_all('/\s+([0-9]+)\s+([A-z]+)/', $top_lines[3], $matches);
	//list($memory_total, $memory_used, $memory_free, $memory_buffers) = $matches[1];
	//previous version didnt work properly on different linux versions
	for($i=0;$i<count($matches[1]);$i++)
	{
		if(strtolower($matches[2][$i])=='total')
		{
			$memory_total = $matches[1][$i];
		}
		else if(strtolower($matches[2][$i])=='free')
			{
				$memory_free = $matches[1][$i];
			}
		else if(strtolower($matches[2][$i])=='used')
			{
				$memory_used = $matches[1][$i];
			}
		else if(stristr($matches[2][$i], 'buff'))
			{
				$memory_buffers = $matches[1][$i];
			}
	}

	preg_match_all('/\s+([0-9]+)\s+([A-z]+)/', $top_lines[4], $matches);
	//list($swap_total, $swap_used, $swap_free, $memory_cached) = $matches[1];
	//previous version didnt work properly on different linux versions
	for($i=0;$i<count($matches[1]);$i++)
	{
		if(strtolower($matches[2][$i])=='total')
		{
			$swap_total = $matches[1][$i];
		}
		else if(strtolower($matches[2][$i])=='free')
			{
				$swap_free = $matches[1][$i];
			}
		else if(strtolower($matches[2][$i])=='used')
			{
				$swap_used = $matches[1][$i];
			}
		else
		{
			$memory_cached = $matches[1][$i];
		}
	}
}
$memory_percentage = round(($memory_used) / $memory_total * 100);
//$memory_percentage = round(($memory_total-$memory_free) / $memory_total * 100);
//https://unix.stackexchange.com/questions/152299/how-to-get-memory-usedram-used-using-linux-command
//$memory_percentage = round(shell_exec("free | awk 'FNR == 3 {print $3/($3+$4)*100}'"));

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">
	<link rel="shortcut icon" href="./static/images/raspberry.png" type="image/png" />
	<link rel="icon" href="./static/images/raspberry.png" type="image/png" />
	<title>GumCP Dashboard</title>
	<link href="./static/css.php" rel="stylesheet" type="text/css">
	<script src="./static/js.php" type="text/javascript">
</script>
	<script type="text/javascript">
var timeout = setInterval(reloadData, 10000);    
function reloadData () {
	$.getJSON( "./ajax.php?action=server_info", function( data ) {
		if(data!=null && data['top']!=null)
		{
			$.each( data, function( key, val ) {
				$('#'+key).html(val);
			});
			$( ".chart" ).each(function( index ) {
				$(this).data('easyPieChart').update($(this).closest( "span" ).text().replace(/[^0-9\.]/g,''));
				$(this).attr("data-percent",$(this).closest( "span" ).text().replace(/[^0-9\.]/g,''));
			});
		}
	});
    
}


$(function() {




		$(".chart").easyPieChart({
			barColor: function(b) {
				return (b < 50 ? "#5cb85c" : b < 85 ? "#f0ad4e" : "#cb3935")
			},
			easing: 'easeOutBounce',
			onStep: function(from, to, percent) {
				//$(this.el).find('.percent').text(Math.round(percent));
			},
			size: 160,
			scaleLength: 4,
			trackWidth: 8,
			lineWidth: (8 / 1.2),
			lineCap: "square"
		});
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
				<a class="navbar-brand" href="./index.php"><img src="./static/images/raspberry.png" />GumCP</a>
			</div>
			<div id="navbar" class="navbar-collapse collapse">
				<ul class="nav navbar-nav navbar-right">
					<?php
include_once('./include/menu.php');
?>
				</ul>
			</div><!--/.nav-collapse -->
		</div><!--/.container-fluid -->
	</nav>



				<div id="system-status" class="panel panel-default" style="margin-bottom: 5px">
					<div class="panel-heading">
						<h3 class="panel-title">System Information<!--a href="?updated" target="_top" class="btn btn-success pull-right" style="margin:-6px -11px; color: white;"><i class="fa fa-refresh"></i></a--></h3>
					</div>
					<div class="panel-body">

						<div class="row" style="margin: 0;">
							<div class="col-xs-6 col-sm-3 text-center">
								<span class="chart" data-percent="<?php echo $cpuusage; ?>">
									<span class="percent"><span id="cpuusage"><?php echo $cpuusage; ?></span><i>%</i></span>
									<span class="label">CPU Usage</span>
								</span>
							</div>

							<!--div class="col-xs-6 col-sm-3 text-center">
								<span class="chart" data-percent="<?php echo ($clock/1000)*100; ?>">
									<span class="percent"><?php echo $clock; ?><i>MHz</i></span>
									<span class="label">CPU Clock</span>
								</span>
							</div-->

							<div class="col-xs-6 col-sm-3 text-center">
								<span class="chart" data-percent="<?php echo $temp; ?>">
									<span class="percent"><span id="temp"><?php echo $temp; ?></span><i>°C</i></span>
									<span class="label">Temperature</span>
								</span>
							</div>

							<div class="col-xs-6 col-sm-3 text-center">
								<span class="chart" data-percent="<?php echo $disk_percentage; ?>">
									<span class="percent"><span id="disk_percentage"><?php echo $disk_percentage; ?></span><i>%</i></span>
									<span class="label">Local disk space</span>
								</span>
							</div>

							<div class="col-xs-6 col-sm-3 text-center">
								<span class="chart" data-percent="<?php echo $memory_percentage; ?>">
									<span class="percent"><span id="memory_percentage"><?php echo $memory_percentage; ?></span><i>%</i></span>
									<span class="label">Real Memory</span>
								</span>
							</div>


							<table class="table table-hover">
							<tbody>
								<tr>
									<td style="width:30%;vertical-align:middle; padding:8px;"><strong>System hostname</strong></td>
									<td style="width:70%; vertical-align:middle; padding:8px;"><span data-id="sysinfo_host"><?php echo gethostname(); ?> (<?php echo $_SERVER['SERVER_ADDR'];?>)</span></td>
								</tr>
								<tr>
									<td style="width:30%;vertical-align:middle; padding:8px;"><strong>Operating system</strong></td>
									<td style="width:70%; vertical-align:middle; padding:8px;"><span data-id="sysinfo_os"><?php echo $operating_system; ?></span></td>
								</tr>
								<tr>
									<td style="width:30%;vertical-align:middle; padding:8px;"><strong>Processor information</strong></td>
									<td style="width:70%; vertical-align:middle; padding:8px;"><span data-id="sysinfo_kernel_arch"><?php echo $cpu_info; ?></span></td>
								</tr>

								<tr>
									<td style="width:30%;vertical-align:middle; padding:8px;"><strong>System uptime</strong></td>
									<td style="width:70%; vertical-align:middle; padding:8px;"><span data-id="sysinfo_uptime"><span id="uptime"><?php echo $uptime; ?></span></span></td>
								</tr>
								<tr>
									<td style="width:30%;vertical-align:middle; padding:8px;"><strong>Current system time</strong></td>
									<td style="width:70%; vertical-align:middle; padding:8px;"><span data-id="sysinfo_disk_space"><span id="date"><?php echo $date; ?></span></span></td>
								</tr>
								<tr>
									<td style="width:30%;vertical-align:middle; padding:8px;"><strong>Running processes</strong></td>
									<td style="width:70%; vertical-align:middle; padding:8px;"><span data-id="sysinfo_running_proc"><a href="./processes.php" id="processes"><?php echo $processes; ?></a></span></td>
								</tr>
								<tr>
									<td style="width:30%;vertical-align:middle; padding:8px;"><strong>CPU load averages</strong></td>
									<td style="width:70%; vertical-align:middle; padding:8px;"><span data-id="sysinfo_load"><span id="load0"><?php echo $load[0]; ?></span> (1 min) <span id="load1"><?php echo $load[1]; ?></span> (5 mins) <span id="load2"><?php echo $load[2]; ?></span></span> (15 mins)</span></td>
								</tr>
								<tr>
									<td style="width:30%;vertical-align:middle; padding:8px;"><strong>Real memory</strong></td>
									<td style="width:70%; vertical-align:middle; padding:8px;"><span data-id="sysinfo_real_memory"><span id="memory_total"><?php echo $memory_total; ?></span> KiB total / <span id="memory_used"><?php /*echo ($memory_used - $memory_buffers - $memory_cached);*/ echo ($memory_used); ?></span> KiB used</span></td>
								</tr>

								<tr>
									<td style="width:30%;vertical-align:middle; padding:8px;"><strong>Local disk space</strong></td>
									<td style="width:70%; vertical-align:middle; padding:8px;"><span data-id="sysinfo_disk_space"><span id="disk_total"><?php echo $disk_total; ?></span> GB total / <span id="disk_free"><?php echo $disk_free; ?></span> GB free / <span id="disk_used"><?php echo $disk_used; ?></span> GB used</span></td>
								</tr>




</tbody></table>









						</div>



					</div>


				</div>





				<div id="top-processes" class="panel panel-default" style="margin-bottom: 5px">
					<div class="panel-heading">
						<h3 class="panel-title">Top Processes</h3>
					</div>
					<div class="panel-body">

						<pre id="top"><?php echo $top; ?></pre>






					</div>


				</div>

				<div id="active-users" class="panel panel-default" style="margin-bottom: 5px">
					<div class="panel-heading">
						<h3 class="panel-title">Users</h3>
					</div>
					<div class="panel-body">

						<pre id="users"><?php echo $users; ?></pre>

					</div>


				</div>

				<div id="active-users" class="panel panel-default" style="margin-bottom: 5px">
					<div class="panel-heading">
						<h3 class="panel-title">Disks</h3>
					</div>
					<div class="panel-body">

						<pre id="disks"><?php echo $disks; ?></pre>

					</div>


				</div>



</div>

<footer class="footer">
	<div class="container">
		<p class="text-muted">GumCP <a href="https://github.com/gumslone/GumCP">GitHub</a>. <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=VCWHQPACTXV5N"><img src="./static/images/Donate-PayPal-green.svg"/></a></p>
	</div>
</footer>
<div id="dialog-placeholder"></div>
<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

</body>
</body>
</html>
