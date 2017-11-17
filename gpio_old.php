<?php
	include_once('./include/config.php');
	

switch ($_REQUEST['action']) {
	case 'mode_in':
		$cmd = 'gpio -g mode '.intval($_REQUEST['bcm']).' in';
		$message = 'Command "'.$cmd.'" executed';
		
	break;
	case 'mode_out':
		$cmd = 'gpio -g mode '.intval($_REQUEST['bcm']).' out';
		$message = 'Command "'.$cmd.'" executed';
		
	break;
	case 'v_high':
		$cmd = 'gpio -g write '.intval($_REQUEST['bcm']).' 1';
		$message = 'Command "'.$cmd.'" executed';
		
	break;
	case 'v_low':
		$cmd = 'gpio -g write '.intval($_REQUEST['bcm']).' 0';
		$message = 'Command "'.$cmd.'" executed';
		
	break;
	
}
	
	

	if(!empty($cmd))
	{
		$connection = ssh2_connect('localhost', SSH_PORT);
		ssh2_auth_password($connection, SSH_USER, SSH_PASS);
		$stream = ssh2_exec($connection, $cmd);
		ssh2_exec($connection, 'exit');
	}

	
	
	$gpio = shell_exec('gpio readall');
	$rows_arr = preg_split("/\\r\\n|\\r|\\n/", $gpio);
	$gpio_rows = array();
	if(is_array($rows_arr))	{
		for($k=0;$k<count($rows_arr);$k++)
		{
			$cells_arr = explode(' | ', $rows_arr[$k]);
			$gpio_cells = array();
			for($i=1;$i<count($cells_arr);$i++)
			{
				$gpio_cells[] = trim(str_replace(array(' |',' '), '', $cells_arr[$i]));
			}
			if(count($gpio_cells)>1)
			{
				$gpio_rows[] = $gpio_cells;
			}
		}
	}
	
	
	
	//get real gpio pins
	$real_gpio_pins = array();
	$real_gpio_bcm = array();
	$real_gpio_pins_full = array();
	$real_gpio_data = array();
	$left_bcm = array();
	$right_bcm = array();
	for($k=0;$k<count($gpio_rows);$k++)
	{
		$is_gpio = false;
		$data = array();
		for($i=0;$i<count($gpio_rows[$k]);$i++)
		{
			if($i==0)$left_bcm[] = $gpio_rows[$k][0];
			$data[''.strtolower($gpio_rows[0][$i]).''] = strtolower($gpio_rows[$k][$i]);
			if(stristr($gpio_rows[$k][$i], 'gpio'))
			{
				$is_gpio = true;
			}
			if(stristr($gpio_rows[$k][$i], '|'))
			{
				if($is_gpio == true)
				{
					$expl = explode('|', $gpio_rows[$k][$i]);
					$real_gpio_pins[] = $expl[0];
					$real_gpio_bcm[] = $gpio_rows[$k][0];
					$data['physical'] = $expl[0];
					$real_gpio_data[] = $data;
				}
				break;
			}
		}
		
	}
	
	for($k=count($gpio_rows)-1;$k>=0;$k--)
	{
		$is_gpio = false;
		$data = array();
		for($i=count($gpio_rows[$k])-1;$i>=0;$i--)
		{
			if($i==count($gpio_rows[$k])-1)$right_bcm[] = $gpio_rows[$k][count($gpio_rows[$k])-1];
			$data[''.strtolower($gpio_rows[0][$i]).''] = strtolower($gpio_rows[$k][$i]);
			if(stristr($gpio_rows[$k][$i], 'gpio'))
			{
				$is_gpio = true;
			}
			if(stristr($gpio_rows[$k][$i], '|'))
			{
				if($is_gpio == true)
				{
					$expl = explode('|', $gpio_rows[$k][$i]);
					$real_gpio_pins[] = $expl[1];
					$real_gpio_bcm[] = $gpio_rows[$k][count($gpio_rows[$k])-1];
					$data['physical'] = $expl[1];
					$real_gpio_data[] = $data;
				}
				break;
			}
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

	<title>GumCP GPIO</title>
	<link href="./static/css.php" rel="stylesheet" type="text/css">
	<script src="./static/js.php" type="text/javascript"></script>
	<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();   
});

    $(function(argument) {
      $('[type="checkbox"]').bootstrapSwitch();
    })

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
					<li class="active"><a href="./gpio.php">GPIO</a></li>
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
						<h3 class="panel-title">GPIO Control</h3>
					</div>
					<div class="panel-body">

						<?php
							if(!empty($message))
							{
								echo '<div class="alert alert-info" role="alert" style="margin-bottom:20px;">'.$message.'</div>';
							}	
						?>
						
						
						<table class="table table-bordered">
							<tbody>
								
								<?php 
									if(is_array($gpio_rows))
									{
										for($k=0;$k<count($gpio_rows);$k++)
										{
											echo '<tr>';
											
											$style_color_left = '';
											$style_color_right = '';
											for($i=0;$i<count($gpio_rows[$k]);$i++)
											{
													if(in_array($gpio_rows[$k][0], $real_gpio_bcm) && $i==0)
													{
														$style_color_left = ' style="background-color:#e8fbe8"';
													}
													
													if(stristr($gpio_rows[$k][$i], 'Physical'))
													{
														echo '<td colspan="2" style="text-align:center;">';
													}
													else
													{
														echo '<td '.$style_color_left.$style_color_right.'>';
													}
													
													if(stristr($gpio_rows[$k][$i], '|'))
													{
														$expl = explode('|', $gpio_rows[$k][$i]);
														
														if(in_array($expl[0], $real_gpio_pins))
														{
															$key = array_search($expl[0], $real_gpio_pins);
															
															echo '<div style="text-align:right;">'.$expl[0].' <i class="fa fa-dot-circle-o" aria-hidden="true" style="color:green;"></i><br/>';
															
															if($real_gpio_data[$key]['mode']=='in')
															{
																
																echo '<form method="post" action="./gpio.php" style="display:inline-block;"><input type="hidden" name="bcm" value="'.$real_gpio_data[$key]['bcm'].'"><input type="hidden" class="form-control" name="action" value="mode_out"><button type="submit" data-toggle="tooltip" title="Set Mode to OUT" class="btn btn-xs btn-primary" onclick="return confirm(\'Set Mode to OUT of the PIN '.$expl[0].'?\')">out</button></form> ';
																
															}
															else
															{
																echo '<form method="post" action="./gpio.php" style="display:inline-block;"><input type="hidden" name="bcm" value="'.$real_gpio_data[$key]['bcm'].'"><input type="hidden" class="form-control" name="action" value="mode_in"><button type="submit" class="btn btn-xs btn-primary" data-toggle="tooltip" title="Set Mode to IN" onclick="return confirm(\'Set Mode to IN of the PIN '.$expl[0].'?\')">in</button></form> ';
																
																if($real_gpio_data[$key]['v']=='1')
																{
																	echo '<form method="post" action="./gpio.php" style="display:inline-block;"><input type="hidden" name="bcm" value="'.$real_gpio_data[$key]['bcm'].'"><input type="hidden" class="form-control" name="action" value="v_low"><button type="submit" data-toggle="tooltip" title="Set V to 0" class="btn btn-xs btn-primary" onclick="return confirm(\'Set V to 0 of the PIN '.$expl[0].'?\')">low</button></form> ';
																}
																else
																{
																	echo '<form method="post" action="./gpio.php" style="display:inline-block;"><input type="hidden" name="bcm" value="'.$real_gpio_data[$key]['bcm'].'"><input type="hidden" class="form-control" name="action" value="v_high"><button type="submit" data-toggle="tooltip" title="Set V to 1" class="btn btn-xs btn-primary" onclick="return confirm(\'Set V to 1 of the PIN '.$expl[0].'?\')">high</button></form> ';
																}
																
																
															}
															
															
															
															
															
															
															
															echo '</div></td>';
														}
														else
														{
															echo '<div style="text-align:right;">'.$expl[0].' <i class="fa fa-dot-circle-o" aria-hidden="true"></i></div></td>';
														}
														
														if(in_array($expl[1], $real_gpio_pins))
														{
															$key = array_search($expl[1], $real_gpio_pins);
															$style_color_left = '';
															$style_color_right = ' style="background-color:#e8fbe8"';
															echo '<td '.$style_color_left.$style_color_right.'><div style="text-align:left;"><i class="fa fa-dot-circle-o" aria-hidden="true" style="color:green;"></i> '.$expl[1].'<br/>';
															
															if($real_gpio_data[$key]['mode']=='in')
															{
																
																echo '<form method="post" action="./gpio.php" style="display:inline-block;"><input type="hidden" name="bcm" value="'.$real_gpio_data[$key]['bcm'].'"><input type="hidden" class="form-control" name="action" value="mode_out"><button type="submit" data-toggle="tooltip" title="Set Mode to OUT" class="btn btn-xs btn-primary" onclick="return confirm(\'Set Mode to OUT of the PIN '.$expl[1].'?\')">out</button></form> ';
															}
															else
															{
																echo '<form method="post" action="./gpio.php" style="display:inline-block;"><input type="hidden" name="bcm" value="'.$real_gpio_data[$key]['bcm'].'"><input type="hidden" class="form-control" name="action" value="mode_in"><button type="submit" class="btn btn-xs btn-primary" data-toggle="tooltip" title="Set Mode to IN" onclick="return confirm(\'Set Mode to IN of the PIN '.$expl[1].'?\')">in</button></form> ';
																
																
																
																if($real_gpio_data[$key]['v']=='1')
																{
																	echo '<form method="post" action="./gpio.php" style="display:inline-block;"><input type="hidden" name="bcm" value="'.$real_gpio_data[$key]['bcm'].'"><input type="hidden" class="form-control" name="action" value="v_low"><button type="submit" data-toggle="tooltip" title="Set V to 0" class="btn btn-xs btn-primary" onclick="return confirm(\'Set V to 0 of the PIN '.$expl[1].'?\')">low</button></form> ';
																}
																else
																{
																	echo '<form method="post" action="./gpio.php" style="display:inline-block;"><input type="hidden" name="bcm" value="'.$real_gpio_data[$key]['bcm'].'"><input type="hidden" class="form-control" name="action" value="v_high"><button type="submit" data-toggle="tooltip" title="Set V to 1" class="btn btn-xs btn-primary" onclick="return confirm(\'Set V to 1 of the PIN '.$expl[1].'?\')">high</button></form> ';
																}
																
																
															}
															
															
															
															
															
															
															echo'</div>';
														}
														else
														{
															$style_color_left = '';
															$style_color_right = '';
															echo '<td><div style="text-align:left;"><i class="fa fa-dot-circle-o" aria-hidden="true"></i> '.$expl[1].'</div>';
														}
													}
													else
													{
														echo $gpio_rows[$k][$i];
													}
													echo '</td>';
											}
											
											echo '</tr>';
										}
									}
								?>
							</tbody>
						</table>
						
					</div>
				
				
				</div>
				
				
				<div id="system-status" class="panel panel-default" style="margin-bottom: 5px">
					<div class="panel-heading">
						<h3 class="panel-title">GPIO pins</h3>
					</div>
					<div class="panel-body">

						<pre><?php echo $gpio; ?></pre>
						

								
								
								
					</div>
				
				
				</div>
				
				<div id="system-status" class="panel panel-default" style="margin-bottom: 5px">
					<div class="panel-heading">
						<h3 class="panel-title">40 Pin connector pinout</h3>
					</div>
					<div class="panel-body">

						<img src="./static/images/Pi-GPIO-header.png"/>
						<br/>
						In order to use this page you have to install the libraries, install the 'git' source code management system. Make sure your Pi can access the internet. You can install git by opening a terminal and typing these commands:
<pre>
$ sudo apt-get install git-core
$ sudo apt-get update
$ sudo apt-get upgrade
</pre>
Get the wiringPi project using this command:
<pre>
$ git clone git://git.drogon.net/wiringPi
</pre>
Change to the new directory, and get the code from the repository at drogon.net:
<pre>
$ cd wiringPi
$ git pull origin
</pre>
Build the code:
<pre>
$ ./build
</pre>
Test wiringPi by typing this command:

<pre>
$ gpio readall
</pre>
as described at http://raspberrywebserver.com/gpio/
								
								
								
					</div>
				
				
				</div>
				
				
		
</div>
<footer class="footer">
	<div class="container">
		<p class="text-muted">GumCP <a href="https://github.com/gumslone/GumCP">GitHub</a>. <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=VCWHQPACTXV5N"><img src="./static/images/Donate-PayPal-green.svg"/></a></p>
	</div>
</footer>

</body>
</html>