<?php
	include_once('./include/config.php');
	
	$services = shell_exec('/usr/sbin/service --status-all');
	$services = str_replace("\n", '<br/>', $services);
	$services = str_replace("[ + ]", '<span class="label label-success">on</span> ', $services);
	$services = str_replace("[ - ]", '<span class="label label-default">off</span> ', $services);

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">

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
					<li><a href="./index.php">Dashboard</a></li>
					<li class="active"><a href="./services.php">Services</a></li>
					<li><a href="./processes.php">Processes</a></li>
					<li><a href="./phpinfo.php">PHP info</a></li>
					<li><a href="./actions.php">Actions</a></li>
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

	

				<div id="system-status" class="panel panel-default" style="margin-bottom: 5px">
					<div class="panel-heading">
						<h3 class="panel-title">System Services<a href="?updated" target="_top" data-refresh="system-status" class="btn btn-success pull-right" style="margin:-6px -11px; color: white;"><i class="fa fa-refresh"></i></a></h3>
					</div>
					<div class="panel-body">

						<?php echo $services; ?>
						
						
						

								
								
								
					</div>
				
				
				</div>
				
				
		
</div>
</body>
</body>
</html>