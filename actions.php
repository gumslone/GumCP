<?php
if (!function_exists('ssh2_connect')) {
    echo "<b>php-ssh2</b> is not installed, this page will only work with installed php-ssh2.<br />\n";
    exit();
}

$active_page = 'actions';

include_once('./include/config.php');
	
switch ($_REQUEST['action']) {
	case 'kill_pid':
		if($_REQUEST['pid']>0)
		{
			$cmd = 'sudo kill -9 '.$_REQUEST['pid'];
			$message = 'Command "'.$cmd.'" executed';
		}
		else
		{
			$message = 'Process ID should be an integer';
		}
	break;
	case 'kill_pname':
		if(!empty($_REQUEST['pname']))
		{
			$cmd = 'sudo killall '.$_REQUEST['pname'];
			$message = 'Command "'.$cmd.'" executed';
		}
		else
		{
			$message = 'Process Name shouldn\'t be an empty value';
		}
	break;
	case 'start_sname':
		if(!empty($_REQUEST['sname']))
		{
			$cmd = 'sudo service '.$_REQUEST['sname'].' start';
			$message = 'Command "'.$cmd.'" executed';
		}
		else
		{
			$message = 'Service Name shouldn\'t be an empty value';
		}
	break;
	case 'stop_sname':
		if(!empty($_REQUEST['sname']))
		{
			$cmd = 'sudo service '.$_REQUEST['sname'].' stop';
			$message = 'Command "'.$cmd.'" executed';
		}
		else
		{
			$message = 'Service Name shouldn\'t be an empty value';
		}
	break;
	/*case 'update_sources':
		$cmd = 'sudo apt-get update';
		$message = 'Command "'.$cmd.'" executed';

	break;
	case 'update_firmware':
		$cmd = 'sudo rpi-update';
		$message = 'Command "'.$cmd.'" executed';
		
	break;*/
	case 'reboot':
		$cmd = 'sudo reboot';
		$message = 'Command "'.$cmd.'" executed';
	break;
	case 'cmd':
		if(!empty($_REQUEST['cmd']))
		{
			$cmd = $_REQUEST['cmd'];
			$message = 'Command "'.$cmd.'" executed';
		}
		else
		{
			$message = 'Command shouldn\'t be an empty value';
		}
		
	break;
}
?>
<?php
	
	if(!file_exists(dirname(__FILE__).'/command_logs'))
	{
		$cmd = "sudo mkdir -m 777 ".dirname(__FILE__)."/command_logs && sudo chmod -R 777 ".dirname(__FILE__)."/command_logs";

	}
	else if(!is_writable ( dirname(__FILE__).'/command_logs' ))
	{
		$cmd = "sudo chmod -R 777 ".dirname(__FILE__)."/command_logs";
	}
	
	
	if(!empty($cmd))
	{
		$connection = ssh2_connect('localhost', SSH_PORT);
		ssh2_auth_password($connection, SSH_USER, SSH_PASS);
		$stream = ssh2_exec($connection, $cmd);
		stream_set_blocking($stream, true);
		$stream_out = ssh2_fetch_stream($stream, SSH2_STREAM_STDIO);
		$message .= '<br/><b>Command output:</b><br/>'.nl2br(stream_get_contents($stream_out));
		
		ssh2_exec($connection, 'exit');
	}
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
	<title>GumCP Actions</title>
	<link href="./static/css.php" rel="stylesheet" type="text/css">
	<script src="./static/js.php" type="text/javascript"></script>
	<script>
		
$( document ).ready(function() {
	
	$("#advanced_command").submit(function( event ) {
		
		if(confirm("Are you sure you want to execute this command?"))
		{
			if($("#background_command").is(':checked'))
			{
				event.preventDefault();
				$.post( "execute_command.php", $( "#advanced_command" ).serialize() )
				.done(function( data ) {
					alert("command sent!");
					$('#cmd').val('');
				});
				
				
				
				
				return false;
			}
			else
			{
				return true;
			}
		}
		else
		{
			event.preventDefault();
			return false;
		}
		
		
		
		
		
	});
	
	
	
	
	
});


function delete_log(file)
{
		
		if(confirm("Are you sure you want to delete this log?"))
		{
			
				event.preventDefault();
				$.post( "ajax.php", {'action':'delete_log','log_file':file} )
				.done(function( data ) {
					alert(data);
					$('div.'+file.replace(".", "_")).remove();
				});
		}
		else
		{
			
		}

}
		
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
						<h3 class="panel-title">Actions</h3>
					</div>
					<div class="panel-body">

						<?php
							if(!empty($message))
							{
								echo '<div class="alert alert-info" role="alert" style="margin-bottom:20px;">'.$message.'</div>';
							}	
						?>
						
						<form method="post">
							<div class="form-group row">
								<label class="col-sm-2 form-control-label" for="pid">Kill Process by ID</label>
								<div class="col-sm-4">
									<input type="text" class="form-control" id="pid" name="pid" placeholder="Process ID (PID)">
									<input type="hidden" class="form-control" name="action" value="kill_pid">
									<small class="text-muted">Provide the PID to kill.</small>
								</div>
								<div class="col-sm-4">
									<button type="submit" class="btn btn-primary" onclick="return confirm('Are you sure?')">Kill</button>
								</div>
							</div>
							
							
						</form>
						
						<form method="post" style="margin-top: 20px;">
							<div class="form-group row">
								<label class="col-sm-2 form-control-label" for="pname">Kill Processes by Name</label>
								<div class="col-sm-4">
									<input type="text" class="form-control" id="pname" name="pname" placeholder="Process Name">
									<input type="hidden" class="form-control" name="action" value="kill_pname">
									<small class="text-muted">Provide the process name to kill.</small>
								</div>
								<div class="col-sm-4">
									<button type="submit" class="btn btn-primary" onclick="return confirm('Are you sure?')">Kill</button>
								</div>
							</div>
							
							
						</form>
								
								
						<form method="post" style="margin-top: 20px;">
							<div class="form-group row">
								<label class="col-sm-2 form-control-label" for="sname">Start Service by Name</label>
								<div class="col-sm-4">
									<input type="text" class="form-control" id="sname" name="sname" placeholder="Service Name">
									<input type="hidden" class="form-control" name="action" value="start_sname">
									<small class="text-muted">Provide the service name to start.</small>
								</div>
								<div class="col-sm-4">
									<button type="submit" class="btn btn-primary" onclick="return confirm('Are you sure?')">Start</button>
								</div>
							</div>
							
							
						</form>
						
						
						<form method="post" style="margin-top: 20px;">
							<div class="form-group row">
								<label class="col-sm-2 form-control-label" for="sname">Stop Service by Name</label>
								<div class="col-sm-4">
									<input type="text" class="form-control" id="sname" name="sname" placeholder="Service Name">
									<input type="hidden" class="form-control" name="action" value="stop_sname">
									<small class="text-muted">Provide the service name to stop.</small>
								</div>
								<div class="col-sm-4">
									<button type="submit" class="btn btn-primary" onclick="return confirm('Are you sure?')">Stop</button>
								</div>
							</div>
							
							
						</form>
						
						<!--form method="post" style="margin-top: 20px;">
							<div class="form-group row">
								<label class="col-sm-2 form-control-label">Update Sources</label>
								<input type="hidden" class="form-control" name="action" value="update_sources">
								<div class="col-sm-4">
									<button type="submit" class="btn btn-primary" onclick="return confirm('Are you sure?')">Update</button>
								</div>
							</div>
							
							
						</form>
						
						<form method="post" style="margin-top: 20px;">
							<div class="form-group row">
								<label class="col-sm-2 form-control-label">Update Firmware</label>
								<input type="hidden" class="form-control" name="action" value="update_firmware">
								<div class="col-sm-4">
									<button type="submit" class="btn btn-primary" onclick="return confirm('Are you sure?')">Update</button>
								</div>
							</div>
							
							
						</form-->
						
						<form method="post" style="margin-top: 20px;">
							<div class="form-group row">
								<label class="col-sm-2 form-control-label">Reboot RPi System</label>
								<input type="hidden" class="form-control" name="action" value="reboot">
								<div class="col-sm-4">
									<button type="submit" class="btn btn-primary" onclick="return confirm('Are you sure to reboot RPi?')">Reboot</button>
								</div>
							</div>
							
							
						</form>
						
						<hr/>
						<form method="post" id="advanced_command" style="margin-top: 20px;">
							<div class="form-group row">
								<label class="col-sm-2 form-control-label" for="cmd">Execute command <b>(Advanced users only!)</b></label>
								<div class="col-sm-4">
									<input type="text" class="form-control" id="cmd" name="cmd" placeholder="Command">
									<input type="hidden" class="form-control" name="action" value="cmd">
									<small class="text-muted">Command usually starts with sudo .....</small>
								</div>
								<div class="col-sm-4">
									<div class="checkbox">
										<label><input type="checkbox" id="background_command" value="">Execute in background</label>
									</div>
								</div>
								<div class="col-sm-4">
									<button type="submit" class="btn btn-primary">Execute</button>
								</div>
							</div>
							
							
						</form>
						
						<hr/>
						
						<div class="well well-sm" id="command_logs"><h3>Useful commands:</h3>
							<code>sudo python /folder_path_to_file/mypython_file.py</code> to execute a python script.<br/>
							<code>sudo apt-get update</code> to update RPi sources.<br/>
							<code>sudo rpi-update</code> to update RPi firmware.<br/>
							<code>sudo reboot</code> to reboot RPi.<br/>
							<code>cd <?php echo dirname(__FILE__); ?> && sudo git pull origin</code> to update GumCP (after this you have to edit the config.php file manually).<br/>
							<code>sudo chmod 0777 <?php echo dirname(__FILE__); ?>/include/config.php</code> to make the config file writable in case you can't write any data to it.

						</div>
						
						<?php
							
							$directory = dirname(__FILE__).'/command_logs/';
							$scanned_directory = array_diff(scandir($directory), array('..', '.'));

							if(is_array($scanned_directory))
							{
							
								echo '<div class="well well-sm" id="command_logs"><h3>Background command output logs:</h3>';
								foreach($scanned_directory AS $file)
								{
									echo '<div class="'.str_replace(".", "_", $file).'"><a href="./command_logs/'.$file.'">'.$file.'</a> '. date ("F d Y H:i:s.", filemtime('./command_logs/'.$file)).' <a href="javascript:void(0);" onclick="javascript:delete_log(\''.$file.'\');" title="delete_log" style="color:red;"><i class="fa fa-trash-o" aria-hidden="true"></i></a></div>';
								}
								
								echo '</div>';
						
							}
						
						?>
						
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
</html>
