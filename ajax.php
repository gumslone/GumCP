<?php
include_once('./include/config.php');
	

switch ($_REQUEST['action']) {
	case 'change_mode':
		$_REQUEST['mode'] = preg_replace('/[^a-z]/', '', $_REQUEST['mode']);
		$cmd = 'gpio -g mode '.intval($_REQUEST['bcm']).' '.$_REQUEST['mode'];
		$message = 'Command "'.$cmd.'" executed';
		
	break;
	
	case 'change_v':
		$cmd = 'gpio -g write '.intval($_REQUEST['bcm']).' '.intval($_REQUEST['v']).'';
		$message = 'Command "'.$cmd.'" executed';
		
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
