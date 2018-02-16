<?php
$active_page = 'processes';

	include_once('./include/config.php');
	
	$processes = shell_exec('ps aux | sort -rk 3,3 | less');
	$rows_arr = preg_split("/\\r\\n|\\r|\\n/", $processes);
	$process_rows = array();
	for($i=0;$i<count($rows_arr);$i++)
	{
		$rows_arr[$i] = preg_replace('/\s+/', ' ', $rows_arr[$i]);
		$cells_arr = explode(' ', $rows_arr[$i],11);
		$process_rows[] = $cells_arr;
	}
	#print_r($process_rows);
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
	<title>GumCP Processes</title>
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
						<h3 class="panel-title">System Processes<a href="?updated" target="_top" data-refresh="system-status" class="btn btn-success pull-right" style="margin:-6px -11px; color: white;"><i class="fa fa-refresh"></i></a></h3>
					</div>
					<div class="panel-body">

						
						<table class="table table-bordered">
							<tbody>
								
								<?php 
									if(is_array($process_rows))
									{
										for($k=0;$k<count($process_rows);$k++)
										{
											echo '<tr>';
											
											for($i=0;$i<count($process_rows[$k]);$i++)
											{
												if($i>3 && $i<9)
												{
													echo '<td class="hidden-xs hidden-sm">';
												}
												else
												{
													echo '<td>';
												}
												if($k==0)
												{
													echo '<b>'.$process_rows[$k][$i].'</b>';
												}
												else
												{
													echo $process_rows[$k][$i];
												}
												echo '</td>';
											}
											if($process_rows[$k][1]>0)
											{
												echo '<td><form method="post" action="./actions.php" style="display:inline-block;"><input type="hidden" name="pid" value="'.$process_rows[$k][1].'"><input type="hidden" class="form-control" name="action" value="kill_pid"><button type="submit" class="btn btn-xs btn-danger" onclick="return confirm(\'Are you sure to kill process pid '.$process_rows[$k][1].'?\')">Kill</button></form></td>';
											}
											else
											{
												echo '<td></td>';
											}
											echo '</tr>';
										}
									}
								?>
							</tbody>
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