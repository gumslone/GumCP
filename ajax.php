<?php
include_once('./include/config.php');
	

switch ($_REQUEST['action']) {
	case 'submit_button':
		unset($_POST['action']);
		if(file_exists('./buttons/buttons.json'))
		{
			$contents = file_get_contents('./buttons/buttons.json');
			$json_arr = json_decode($contents,true);
			if($_POST['button_id']!='')
			{
				
				$json_arr[$_POST['button_id']] = $_POST;
			}
			else
			{
				$json_arr[] = $_POST;
			}
		}
		else
		{
			$json_arr[] = $_POST;
		}
		
		if(file_put_contents('./buttons/buttons.json', json_encode($json_arr)))
		{
			$out['type'] = 'success';
			if($_POST['button_id']!='')
			{
				$out['message'] = 'Button edited successfully';
			}
			else
			{
				$out['message'] = 'New button created successfully';
			}
		}
		else
		{
			$out['type'] = 'error';
			$out['message'] = 'error, make sure that php-ssh2 is installed, folder buttons exists and is writable';
		}
		echo(json_encode($out));
	break;
	case 'execute_button':
		if($_REQUEST['button_id']!='')
		{
			$contents = file_get_contents('./buttons/buttons.json');
			$json_arr = json_decode($contents,true);
			$cmd = $json_arr[$_REQUEST['button_id']]['button_command'];
		}
	break;
	case 'delete_button':
		if($_REQUEST['button_id']!='')
		{
			$contents = file_get_contents('./buttons/buttons.json');
			$json_arr = json_decode($contents,true);
			unset($json_arr[$_REQUEST['button_id']]);
			$json_arr = array_values($json_arr);

			if(file_put_contents('./buttons/buttons.json', json_encode($json_arr)))
			{
				$out['type'] = 'success';
				$out['message'] = 'Button deleted successfully';
			}
			else
			{
				$out['type'] = 'error';
				$out['message'] = 'error, make sure that php-ssh2 is installed, folder buttons exists and is writable';
			}
			echo(json_encode($out));
		}
	break;
	case 'edit_button':
		if($_REQUEST['button_id']!='')
		{
			$contents = file_get_contents('./buttons/buttons.json');
			$json_arr = json_decode($contents,true);
			$json_arr[$_REQUEST['button_id']];
			echo(json_encode($json_arr[$_REQUEST['button_id']]));
		}
	break;
	case 'change_mode':
		$_REQUEST['mode'] = preg_replace('/[^a-z]/', '', $_REQUEST['mode']);
		$cmd = 'gpio -g mode '.intval($_REQUEST['bcm']).' '.$_REQUEST['mode'];
		$message = 'Command "'.$cmd.'" executed';
		
	break;
	
	case 'change_v':
		$cmd = 'gpio -g write '.intval($_REQUEST['bcm']).' '.intval($_REQUEST['v']).'';
		$message = 'Command "'.$cmd.'" executed';
		
	break;
	
	case 'delete_log':
		$file = basename($_REQUEST['log_file']);
		if(!empty($file))
		{
			$cmd = 'sudo rm -f '.dirname(__FILE__) . DIRECTORY_SEPARATOR .'command_logs/'.$file.'';
			$message = 'Command "'.$cmd.'" executed';
		}
		else
		{
			$message = 'File not defined';
		}
		
	break;
	
	case 'server_info':
		$out = array();
		$temp = shell_exec('cat /sys/class/thermal/thermal_zone*/temp');
		$temp = round($temp / 1000, 1);
		$out['temp'] = $temp;
		
		$cpuusage = 100 - shell_exec("vmstat | tail -1 | awk '{print $15}'");
		$out['cpuusage'] = $cpuusage;
		
		$clock = '';
		/*$clock = shell_exec('cat /sys/devices/system/cpu/cpu0/cpufreq/scaling_cur_freq');
			$clock = round($clock / 1000);*/

		//disk usage
		$bytes = disk_free_space(".");
		$si_prefix = array( 'B', 'KB', 'MB', 'GB', 'TB', 'EB', 'ZB', 'YB' );
		$base = 1024;
		$class = min((int)log($bytes , $base) , count($si_prefix) - 1);
		$disk_free =  sprintf('%1.2f' , $bytes / pow($base,$class));
		$out['disk_free'] = $disk_free;
		$bytes = disk_total_space(".");
		$si_prefix = array( 'B', 'KB', 'MB', 'GB', 'TB', 'EB', 'ZB', 'YB' );
		$base = 1024;
		$class = min((int)log($bytes , $base) , count($si_prefix) - 1);
		$disk_total = sprintf('%1.2f' , $bytes / pow($base,$class));
		$out['disk_total'] = $disk_total;
		$disk_used = $disk_total - $disk_free;
		$out['disk_used'] = $disk_used;
		$disk_percentage = round($disk_used / $disk_total * 100);
		$out['disk_percentage'] = $disk_percentage;
		
		$uptime = shell_exec('uptime -p');
		$out['uptime'] = $uptime;
		
		$load = sys_getloadavg();
		$out['load'] = $load;
		$out['load0'] = $load[0];
		$out['load1'] = $load[1];
		$out['load2'] = $load[2];
		$processes = shell_exec("ps aux | wc -l");
		$out['processes'] = $processes;
		
		$top = shell_exec("top -b -n 1 | head -n 30  | tail -n 30");
		$out['top'] = $top;
		
		$users = shell_exec("w");
		$users = preg_replace('/^.+\n/', '', $users);
		$out['users'] = $users;

		$disks = shell_exec("df");
		$out['disks'] = $disks;
		
		$date = shell_exec("date");
		$out['date'] = $date;
		
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
		//$memory_total, $memory_used, $memory_free, $memory_shared, $memory_buffers, $memory_cached
		
		$out['memory_total'] = $memory_total;
		$out['memory_used'] = $memory_used;
		$out['memory_free'] = $memory_free;
		$out['memory_shared'] = $memory_shared;
		$out['memory_buffers'] = $memory_buffers;
		$out['memory_cached'] = $memory_cached;
		
		
		
		$memory_percentage = round(($memory_used) / $memory_total * 100);
		$out['memory_percentage'] = $memory_percentage;

		echo json_encode($out,true);
		exit();
		
	break;
}

if(!empty($cmd))
{
	$connection = ssh2_connect('localhost', SSH_PORT);
	ssh2_auth_password($connection, SSH_USER, SSH_PASS);
	$stream = ssh2_exec($connection, $cmd);
	
	
	stream_set_blocking($stream, true);
	$stream_out = ssh2_fetch_stream($stream, SSH2_STREAM_STDIO);
	$message .= ''.nl2br(stream_get_contents($stream_out));
	
	ssh2_exec($connection, 'exit');
}

echo $message;
?>
