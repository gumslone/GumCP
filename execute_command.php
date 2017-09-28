<?php

include_once('./include/config.php');
	
$cmd = $_REQUEST['cmd'];

	if(!empty($cmd))
	{
		$connection = ssh2_connect('localhost', SSH_PORT);
		ssh2_auth_password($connection, SSH_USER, SSH_PASS);
		$stream = ssh2_exec($connection, $cmd . ' > '.dirname(__FILE__).'/command_logs/'.md5($cmd).'.txt 2>&1 &');
		stream_set_blocking($stream, true);
		$stream_out = ssh2_fetch_stream($stream, SSH2_STREAM_STDIO);
		$message .= ''.nl2br(stream_get_contents($stream_out));
		ssh2_exec($connection, 'exit');
		echo './command_logs/'.md5($cmd).'.txt';
	}

?>