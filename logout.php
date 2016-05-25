<?php
session_start();
session_regenerate_id();
$_SESSION['LOGIN_USER'] = 'f0000ooo';
$_SESSION['LOGIN_PASS'] = 'f0000ooo';
session_destroy();
sleep(1);
header("Location: ./login.php");
?>
