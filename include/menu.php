<?php
if($active_page=='dashboard')
{
	echo '<li class="active"><a href="./index.php">Dashboard</a></li>';
}
else
{
	echo '<li><a href="./index.php">Dashboard</a></li>';
}
foreach($gumcp_modules as $key => $module)
{

	if($module['module_active']==1)
	{
		if($module['module_show_in_iframe']==1)
		{
			if($active_page==$key)
			{
				echo '<li class="active"><a href="./iframe.php?module='.$key.'">'.$module['module_title'].'</a></li>';
			}
			else
			{
				echo '<li><a href="./iframe.php?module='.$key.'">'.$module['module_title'].'</a></li>';
			}
		}
		else
		{
			if($active_page==$key)
			{
				echo '<li class="active"><a href="'.$module['module_index_file_relative_path'].'">'.$module['module_title'].'</a></li>';
			}
			else
			{
				echo '<li><a href="'.$module['module_index_file_relative_path'].'">'.$module['module_title'].'</a></li>';
			}
		}
	}
}


if(LOGIN_REQUIRED==true)
{
	echo '<li><a href="./logout.php">Logout</a></li>';
}	


?>