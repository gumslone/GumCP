<?php
if(isset($_REQUEST['action']))
{
	switch ($_REQUEST['action']) {
		case 'incorrect_login':
			$message = 'Incorrect Username/Password combination';
			
		break;
		
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
	<title>GumCP Please sign in</title>
	<link href="./static/css.php" rel="stylesheet" type="text/css">
	<script src="./static/js.php" type="text/javascript"></script>
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

		</div><!--/.container-fluid -->
	</nav>

	

				<div id="system-status" class="panel panel-default" style="margin-bottom: 5px">
					<div class="panel-heading">
						<h3 class="panel-title">Please sign in</h3>
					</div>
					<div class="panel-body">

						<?php
							if(!empty($message))
							{
								echo '<div class="alert alert-danger" role="alert" style="margin-bottom:20px;">'.$message.'</div>';
							}	
						?>
						
						

							<form method="post" action="./index.php" class="form-signin">
								<div class="form-group row">
									<label for="login_user" class="col-sm-2 form-control-label">Username</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" name="login_user" id="login_user" placeholder="Username" required autofocus>
									</div>
								</div>
								<div class="form-group row">
									<label for="login_pass" class="col-sm-2 form-control-label">Password</label>
									<div class="col-sm-10">
										<input type="password" class="form-control" name="login_pass" id="login_pass" placeholder="Password" required>
									</div>
								</div>
								<button type="submit" class="btn btn-primary">Login</button>
							</form>
							
						
								
					</div>
				
				
				</div>
				
				
		
</div>
<footer class="footer">
	<div class="container">
		<p class="text-muted">GumCP <a href="https://github.com/gumslone/GumCP">GitHub</a>. <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=VCWHQPACTXV5N"><img src="./static/images/Donate-PayPal-green.svg"/></a></p>
	</div>
</footer>
<div id="dialog-placeholder"></div>
</body>
</html>