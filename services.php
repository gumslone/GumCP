<?php
$active_page = 'services';

	include_once('./include/config.php');
	
	$services = shell_exec('/usr/sbin/service --status-all');
	$service_arr = preg_split("/\\r\\n|\\r|\\n/", $services);

	$active_services_arr = array();
	$inactive_services_arr = array();
	foreach($service_arr AS $a)
	{
		if(stristr($a, '[ + ]'))
		{
			$a = str_replace("[ + ]", '', $a);
			if(!empty($a))$active_services_arr[] = trim($a);
		}
		else
		{
			$a = str_replace("[ - ]", '', $a);
			if(!empty($a))$inactive_services_arr[] = trim($a);
			
		}
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
	<title>GumCP Services</title>
	<link href="./static/css.php" rel="stylesheet" type="text/css">
	<script src="./static/js.php" type="text/javascript">
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
						<h3 class="panel-title">Active System Services</h3>
					</div>
					<div class="panel-body">

						<table class="table table-hover">
						<?php
							
							foreach($active_services_arr AS $a)
							{
								echo '<tr><td>'.$a.'</td><td><form method="post" action="./actions.php" style="display:inline-block;"><input type="hidden" name="sname" value="'.$a.'"><input type="hidden" class="form-control" name="action" value="stop_sname"><button type="submit" class="btn btn-xs btn-danger" onclick="return confirm(\'Are you sure to stop '.$a.'?\')">Stop</button></form></td></tr>';
							}
						?>
						</table>

					</div>
				
				
				</div>
				
				
				
				<div id="system-status" class="panel panel-default" style="margin-bottom: 5px">
					<div class="panel-heading">
						<h3 class="panel-title">Inactive System Services</h3>
					</div>
					<div class="panel-body">

						<table class="table table-hover">
						<?php
							
							foreach($inactive_services_arr AS $a)
							{
								echo '<tr><td>'.$a.'</td><td><form method="post" action="./actions.php" style="display:inline-block;"><input type="hidden" name="sname" value="'.$a.'"><input type="hidden" class="form-control" name="action" value="start_sname"><button type="submit" class="btn btn-xs btn-success" onclick="return confirm(\'Are you sure to start '.$a.'?\')">Start</button></form></td></tr>';
							}
						?>
						</table>
						
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