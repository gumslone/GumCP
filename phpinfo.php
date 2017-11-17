<?php
	include_once('./include/config.php');

ob_start();

phpinfo();

$html = ob_get_contents();
ob_end_clean();
preg_match('/(?:<body[^>]*>)(.*)<\/body>/isU', $html, $matches);
$phpinfo = $matches[1];

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
	<title>GumCP PHP info</title>
	<link href="./static/css.php" rel="stylesheet" type="text/css">
	<script src="./static/js.php" type="text/javascript"></script>
	<style type="text/css">
	#system-status pre {margin: 0; font-family: monospace;}
	#system-status a:link {color: #009; text-decoration: none; background-color: #fff;}
	#system-status a:hover {text-decoration: underline;}
	#system-status table {border-collapse: collapse; border: 0; width: 100%; box-shadow: 1px 2px 3px #ccc;}
	#system-status .center {text-align: center;}
	#system-status .center table {margin: 1em auto; text-align: left;}
	#system-status .center th {text-align: center !important;}
	td, th {border: 1px solid #666; font-size: 75%; vertical-align: baseline; padding: 4px 5px;}
	#system-status h1 {font-size: 150%;}
	#system-status h2 {font-size: 125%;}
	#system-status .p {text-align: left;}
	#system-status .e {background-color: #ccf; width: 300px; font-weight: bold;}
	#system-status .h {background-color: #99c; font-weight: bold;}
	#system-status .v {background-color: #ddd; max-width: 300px; overflow-x: auto;}
	#system-status .v i {color: #999;}
	#system-status img {float: right; border: 0;}
	#system-status hr {width: 934px; background-color: #ccc; border: 0; height: 1px;}
	</style>
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
				<a class="navbar-brand" href="./index.php"><img src="./static/images/raspberry.png" />RasPi GumCP</a>
			</div>
			<div id="navbar" class="navbar-collapse collapse">
				<ul class="nav navbar-nav navbar-right">
					<li><a href="./index.php">Dashboard</a></li>
					<li><a href="./services.php">Services</a></li>
					<li><a href="./processes.php">Processes</a></li>
					<li class="active"><a href="./phpinfo.php">PHP info</a></li>
					<li><a href="./actions.php">Actions</a></li>
					<li><a href="./gpio.php">GPIO</a></li>
					<li><a href="./buttons.php">Buttons</a></li>
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
						<h3 class="panel-title">PHP info</h3>
					</div>
					<div class="panel-body">

						<?php echo $phpinfo; ?>
						
						
						
						
								
								
								
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