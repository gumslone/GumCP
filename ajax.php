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
