<?php
	
//make sure that php ssh in installed (sudo apt-get install php5-ssh2)
define('SSH_PORT', '22'); //your ssh port, defailt is "22"
define('SSH_USER', 'pi'); //your ssh username, default is "pi"
define('SSH_PASS', 'raspberry'); //your ssh password, default is "raspberry"

define('LOGIN_REQUIRED', false); //set to "true" if you want to enable a login system, or "false" to disable it
define('LOGIN_USER', 'pi'); //set username for login
define('LOGIN_PASS', 'raspberry'); //set password for login

define('GUMCP_DEBUG', false); //change to true to show PHP errors, or false to hide errors

define('MEMORY_CALCULATION_METHOD', 2); //change to 1 to use the free -mo command, which may not work with all raspberrys



$gumcp_modules = array(
	'services' => array(
		'module_title' => 'Services',
		'module_index_file_relative_path' => './services.php',
		'module_active' => 1, //change to 1 to enable file manager, and 0 to disable it.
	),
	'processes' => array(
		'module_title' => 'Processes',
		'module_index_file_relative_path' => './processes.php',
		'module_active' => 1, //change to 1 to enable file manager, and 0 to disable it.
	),
	'phpinfo' => array(
		'module_title' => 'PHP Info',
		'module_index_file_relative_path' => './phpinfo.php',
		'module_active' => 1, //change to 1 to enable file manager, and 0 to disable it.
	),
	'actions' => array(
		'module_title' => 'Actions',
		'module_index_file_relative_path' => './actions.php',
		'module_active' => 1, //change to 1 to enable file manager, and 0 to disable it.
	),
	'gpio' => array(
		'module_title' => 'GPIO',
		'module_index_file_relative_path' => './gpio.php',
		'module_active' => 1, //change to 1 to enable file manager, and 0 to disable it.
	),
	'buttons' => array(
		'module_title' => 'Buttons',
		'module_index_file_relative_path' => './buttons.php',
		'module_active' => 1, //change to 1 to enable file manager, and 0 to disable it.
	),
	
	//third party modules with different licenses
	'tinyfilemanager' => array(
		'module_title' => 'File Manager',
		'module_index_file_relative_path' => './modules/tinyfilemanager/tinyfilemanager.php',
		'module_active' => 0, //change to 1 to enable file manager, and 0 to disable it.
		'module_show_in_iframe' => 1 //change to 0 show module directly, and 1 to show it in iframe.
	),
	'adminer' => array(
		'module_title' => 'Database Manager',
		'module_index_file_relative_path' => './modules/adminer/adminer.php',
		'module_active' => 0, //change to 1 to enable file manager, and 0 to disable it.
		'module_show_in_iframe' => 1 //change to 0 show module directly, and 1 to show it in iframe.
	),
);


if(GUMCP_DEBUG == true)
{
	error_reporting(E_ALL);
}
else
{
	error_reporting(0);
}

//dont touch from this line
session_start();
session_regenerate_id();

if(!empty($_REQUEST['login_user']) && !empty($_REQUEST['login_pass']) && $_REQUEST['login_user'] == LOGIN_USER && $_REQUEST['login_pass'] == LOGIN_PASS)
{
	$_SESSION['LOGIN_USER'] = md5(LOGIN_USER);
	$_SESSION['LOGIN_PASS'] = md5(LOGIN_PASS);
}
elseif(!empty($_REQUEST['login_user']) && !empty($_REQUEST['login_pass']))
{
	header("Location: ./login.php?action=incorrect_login");
	exit();
}



if(LOGIN_REQUIRED==true)
{
	if(isset($_SESSION['LOGIN_USER']) && $_SESSION['LOGIN_USER']==md5(LOGIN_USER) && isset($_SESSION['LOGIN_PASS']) && $_SESSION['LOGIN_PASS'] == md5(LOGIN_PASS))
	{
		
	}
	else
	{
		header("Location: ./login.php");
		exit();
	}
}




?>