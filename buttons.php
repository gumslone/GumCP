<?php
	include_once('./include/config.php');

	if(!file_exists(dirname(__FILE__).'/buttons'))
	{
		$cmd = "sudo mkdir -m 777 ".dirname(__FILE__)."/buttons && sudo chmod -R 777 ".dirname(__FILE__)."/buttons";

	}
	else if(!is_writable ( dirname(__FILE__).'/buttons' ))
	{
		$cmd = "sudo chmod -R 777 ".dirname(__FILE__)."/buttons";
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
	<title>GumCP Buttons</title>
	<link href="./static/css.php" rel="stylesheet" type="text/css">
	<script src="./static/js.php" type="text/javascript"></script>
	<script>
		$(document).ready(function(){
			$('[data-toggle="tooltip"]').tooltip();
			
		});
		
		function add_button()
		{
		
			var html = jQuery('#create-button-dialog').html();
		
			html += '<div class="dialog-actions text-right margin-top-sm">';
		
			html += '<div class="form-group pull-right">';
			html += '<button type="button" class="btn btn-default" onclick="javascript:jQuery(\'#dialog\').modal(\'hide\');">Cancel</button> ';
			html += ' <button type="button" class="btn btn-default" id="send-message-btn" onclick="javascript:submit_button();jQuery(this).prop(\'disabled\', true);">Send</button>';
			html += '</div>';
			
			html += '<div style="clear:both;"></div></div>';
			
			open_dialog('Add a button', html);
		
		}
		
		function submit_button()
		{
			jQuery('#send-message-btn').prop('disabled', true);
			var form_data = $('#dialog .create-button-form').serializeArray();
			jQuery.ajax({ 
				type: 'POST', 
				url: 'ajax.php', 
				data: form_data,
				dataType:'json',
				success: function (data) { 
					alert(data.message);
					if(data.type=='success')
					{
						location.reload();
					}
					else
					{
						jQuery('#send-message-btn').prop('disabled', false);
					}
				}
			});
			
		}
		function execute_button(button_id)
		{
			jQuery('#button-id-'+button_id).prop('disabled', true);
			jQuery.ajax({ 
				type: 'POST', 
				url: 'ajax.php', 
				data: {'action':'execute_button','button_id':button_id},
				dataType:'text',
				success: function (data) { 
					alert(data);
					jQuery('#button-id-'+button_id).prop('disabled', false);
				}
			});
			
		}
		function edit_button(button_id)
		{
			add_button();
			jQuery.ajax({ 
				type: 'POST', 
				url: 'ajax.php', 
				data: {'action':'edit_button','button_id':button_id},
				dataType:'json',
				success: function (data) { 
					//alert(data);
					$('#dialog .create-button-form #button_id').val(button_id);
					$('#dialog .create-button-form #button_command').val(data.button_command);
					$('#dialog .create-button-form #button_title').val(data.button_title);
					$('#dialog .create-button-form #button_icon').val(data.button_icon);
					$('#dialog .create-button-form #button_style option[value="' + data.button_style + '"]').prop('selected', true);
					$('#dialog .create-button-form #button_size option[value="' + data.button_size + '"]').prop('selected', true);
				}
			});
			
		}
		function delete_button(button_id)
		{
			if(confirm("Are you sure you want to delete this button?"))
			{
				jQuery('#button-id-'+button_id).prop('disabled', true);
				jQuery.ajax({ 
					type: 'POST', 
					url: 'ajax.php', 
					data: {'action':'delete_button','button_id':button_id},
					dataType:'json',
					success: function (data) { 
						alert(data.message);
						if(data.type=='success')
						{
							location.reload();
						}
						else
						{
							jQuery('#button-id-'+button_id).prop('disabled', false);
						}
					}
				});
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
					<li><a href="./index.php">Dashboard</a></li>
					<li><a href="./services.php">Services</a></li>
					<li><a href="./processes.php">Processes</a></li>
					<li><a href="./phpinfo.php">PHP info</a></li>
					<li><a href="./actions.php">Actions</a></li>
					<li><a href="./gpio.php">GPIO</a></li>
					<li class="active"><a href="./buttons.php">Buttons</a></li>
					<?php
						if(LOGIN_REQUIRED==true)
						{
							echo '<li><a href="./logout.php">Logout</a></li>';
						}
					?>
				</ul>
			</div><!--/.nav-collapse -->
		</div><!--/.container-fluid -->
	</nav>

	

				<button type="button" class="btn btn-default" onclick="javascript:add_button();"><i class="fa fa-plus fa-lg"></i> Add a command button</button>

				<div id="system-status" class="panel panel-default" style="margin-top: 5px">
					<div class="panel-heading">
						<h3 class="panel-title">Command buttons</h3>
					</div>
					<div class="panel-body">

						<?php
							if(!empty($message))
							{
								echo '<div class="alert alert-info" role="alert" style="margin-bottom:20px;">'.$message.'</div>';
							}	
						
						if(file_exists('./buttons/buttons.json'))
						{
							$contents = file_get_contents('./buttons/buttons.json');
							$json_arr = json_decode($contents,true);
							
								
							for($i=0;$i<count($json_arr);$i++)
							{
								echo ' <div class="btn-group" role="group" aria-label="...">';
								echo '<button onclick="javascript:execute_button(\''.$i.'\');" type="button" id="button-id-'.$i.'" class="'.$json_arr[$i]['button_style'].' '.$json_arr[$i]['button_size'].'" data-toggle="tooltip" data-original-title="'.$json_arr[$i]['button_command'].'">';
								if(!empty($json_arr[$i]['button_icon']))
								echo '<i class="fa '.$json_arr[$i]['button_icon'].'" aria-hidden="true"></i> ';
								echo $json_arr[$i]['button_title'];
								echo '</button>';
								
								echo '<div class="btn-group" role="group">
									<button type="button" class="btn btn-default dropdown-toggle '.$json_arr[$i]['button_size'].'" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="caret"></span></button>
									<ul class="dropdown-menu">
										<li><a href="javascript:void(0);" onclick="javascript:edit_button(\''.$i.'\');">Edit</a></li>
										<li><a href="javascript:void(0);" onclick="javascript:delete_button(\''.$i.'\');">Delete</a></li>
									</ul>
								</div>';
								
								
								
								echo '</div> ';
							}
								
							
						}
	
						
						
						
						?>
						
						
						
					</div>
				
				
				</div>
				
				

				
				
				
				
		
</div>

<div id="create-button-dialog" style="display: none">
	<form style="width: 100%;" class="create-button-form">
		<input type="hidden" name="action" value="submit_button">
		<input type="hidden" id="button_id" name="button_id" value="">
		<div class="form-group">
			<label for="button_title">Button title:</label>
			<input type="text" class="form-control" id="button_title" placeholder="Enter a some title text" name="button_title">
		</div>
		<div class="form-group">
			<label for="button_command">Button command:</label>
			<input type="text" class="form-control" id="button_command" placeholder="Enter a command to be executed on a button click" name="button_command">
		</div>
		<div class="form-group">
			<label for="button_icon">Button icon:</label>
			<input type="text" class="form-control" id="button_icon" placeholder="Insert icon class name from fontawesome, i.e. fa-plus" name="button_icon">
		</div>
		<div class="form-group">
			<label for="button_style">Button style:</label>
			<select class="form-control" id="button_style" name="button_style">
				<option value="btn">Basic</option>
				<option value="btn btn-default">Default</option>
				<option value="btn btn-primary">Primary</option>
				<option value="btn btn-success">Success</option>
				<option value="btn btn-info">Info</option>
				<option value="btn btn-warning">Warning</option>
				<option value="btn btn-danger">Danger</option>
				<option value="btn btn-link">Link</option>
			</select>
		</div>
		<div class="form-group">
			<label for="button_size">Button size:</label>
			<select class="form-control" id="button_size" name="button_size">
				<option value="">Default</option>
				<option value="btn-lg">Large</option>
				<option value="btn-md">Medium</option>
				<option value="btn-sm">Small</option>
				<option value="btn-xs">XSmall</option>
			</select>
		</div>
	</form>
</div>



<footer class="footer">
	<div class="container">
		<p class="text-muted">GumCP <a href="https://github.com/gumslone/GumCP">GitHub</a>. <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=VCWHQPACTXV5N"><img src="./static/images/Donate-PayPal-green.svg"/></a></p>
	</div>
</footer>
<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
<div id="dialog-placeholder"></div>


</body>
</html>