<?php
	include_once('./include/config.php');

	
	
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
	$right_bcm = array_reverse($right_bcm);
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
	<title>GumCP GPIO</title>
	<link href="./static/css.php" rel="stylesheet" type="text/css">
	<script src="./static/js.php" type="text/javascript"></script>
	<script>
		$(document).ready(function(){
			$('[data-toggle="tooltip"]').tooltip();
			$('.switch-mode').bootstrapSwitch();
			$('.switch-v').bootstrapSwitch();
			$('.switch-pullup').bootstrapSwitch();
			$('.switch-mode').on('switchChange.bootstrapSwitch', function (event, state) {
				
				var bcm = $(this).attr("data-bcm");
				var mode = 'in'
				if(state)
				{
					mode = 'out';
				}
				else
				{
					mode = 'in';
				}
				
				$.ajax({
					type: "POST",
					url: 'ajax.php',
					data: {'action':'change_mode', 'mode':mode,'bcm':bcm},
					success: function (result) {
						alert(result);
						location.reload();
					}
				});
			}); 
			$('.switch-v').on('switchChange.bootstrapSwitch', function (event, state) {
				var bcm = $(this).attr("data-bcm");
				var v = 1;
				
				if(state)
				{
					v = 1;
				}
				else
				{
					v = 0;
				}
				
				$.ajax({
					type: "POST",
					url: 'ajax.php',
					data: {'action':'change_v', 'v':v, 'bcm':bcm},
					success: function (result) {
						alert(result);
						location.reload();
					}
				});
			});
			$('.switch-pullup').on('switchChange.bootstrapSwitch', function (event, state) {
				var bcm = $(this).attr("data-bcm");
				var v = 1;
				
				if(state)
				{
					mode = 'up';
				}
				else
				{
					mode = 'down';
				}
				
				$.ajax({
					type: "POST",
					url: 'ajax.php',
					data: {'action':'change_mode', 'mode':mode, 'bcm':bcm},
					success: function (result) {
						alert(result);
						location.reload();
					}
				});
			});

		});
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
													$bcm = '';
													if($style_color_left!='')
														$bcm = $left_bcm[$k];
													if($style_color_right!='')
														$bcm = $right_bcm[$k];
													
													if(strtolower($gpio_rows[0][$i])=='mode' && ($style_color_left!='' || $style_color_right!=''))
													{
														if(strtolower($gpio_rows[$k][$i])=='out')
															echo '<input class="switch-mode" type="checkbox" checked data-on-text="OUT" data-off-text="IN" data-off-color="primary" data-on-color="success" data-size="mini" data-bcm="'.$bcm.'">';
														else
															echo '<input class="switch-mode" type="checkbox" data-on-text="OUT" data-off-text="IN" data-off-color="primary" data-on-color="success" data-size="mini" data-bcm="'.$bcm.'">';
													}
													elseif(strtolower($gpio_rows[0][$i])=='v' && ($style_color_left!='' || $style_color_right!=''))
													{
														if(strtolower($gpio_rows[$k][$i-1])=='out'||strtolower($gpio_rows[$k][$i+1])=='out')
														{
															if($gpio_rows[$k][$i]==1)
																echo '<input class="switch-v" type="checkbox" checked data-on-text="HIGH" data-off-text="LOW" data-on-color="danger" data-size="mini" data-bcm="'.$bcm.'">';
															else
																echo '<input class="switch-v" type="checkbox" data-on-text="HIGH" data-off-text="LOW" data-on-color="danger" data-size="mini" data-bcm="'.$bcm.'">';
														}
														elseif(strtolower($gpio_rows[$k][$i-1])=='in'||strtolower($gpio_rows[$k][$i+1])=='in')
														{
															if($gpio_rows[$k][$i]==1)
																echo '<input class="switch-pullup" type="checkbox" checked data-on-text="Pull up" data-off-text="Pull down" data-on-color="dark" data-off-color="secondary" data-size="mini" data-bcm="'.$bcm.'">';
															else
																echo '<input class="switch-pullup" type="checkbox" data-on-text="Pull up" data-off-text="Pull down" data-on-color="dark" data-off-color="secondary" data-size="mini" data-bcm="'.$bcm.'">';
														}
														else
														{
															echo $gpio_rows[$k][$i];
														}
													}
													elseif(stristr($gpio_rows[$k][$i], '|'))
													{
														$expl = explode('|', $gpio_rows[$k][$i]);
														
														if(in_array($expl[0], $real_gpio_pins))
														{
															$key = array_search($expl[0], $real_gpio_pins);
															if(strtolower($gpio_rows[$k][$i-2])=='out'||strtolower($gpio_rows[$k][$i+2])=='out')
															{
																
																if($gpio_rows[$k][$i-1]==1)
																	echo '<div style="text-align:right;">'.$expl[0].' <i class="fa fa-dot-circle-o" aria-hidden="true" style="color:red;"></i></div></td>';
																else
																	echo '<div style="text-align:right;">'.$expl[0].' <i class="fa fa-dot-circle-o" aria-hidden="true" style="color:blue;"></i></div></td>';
															}
															else
															{
															
																echo '<div style="text-align:right;">'.$expl[0].' <i class="fa fa-circle-o" aria-hidden="true" style="color:green;"></i></div></td>';
															}
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
															
															if(strtolower($gpio_rows[$k][$i+2])=='out')
															{
																
																if($gpio_rows[$k][$i+1]==1)
																	echo '<td '.$style_color_left.$style_color_right.'><div style="text-align:left;"><i class="fa fa-dot-circle-o" aria-hidden="true" style="color:red;"></i> '.$expl[1].'<br/></div>';
																else
																	echo '<td '.$style_color_left.$style_color_right.'><div style="text-align:left;"><i class="fa fa-dot-circle-o" aria-hidden="true" style="color:blue;"></i> '.$expl[1].'<br/></div>';
															}
															else
															{
															
																echo '<td '.$style_color_left.$style_color_right.'><div style="text-align:left;"><i class="fa fa-circle-o" aria-hidden="true" style="color:green;"></i> '.$expl[1].'<br/></div>';
															}
															
															//echo '<td '.$style_color_left.$style_color_right.'><div style="text-align:left;"><i class="fa fa-dot-circle-o" aria-hidden="true" style="color:green;"></i> '.$expl[1].'<br/></div>';
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