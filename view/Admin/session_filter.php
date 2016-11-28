<?php
$projectName = "GreenHorse";
$Userurl = $_SERVER['DOCUMENT_ROOT'].$projectName."/model/User.php";
require_once($Userurl);

	$admin = new User();
	session_start();
	$admin = $_SESSION['admin'];
	if($admin == null){
		header("Location:login.php");
	}
?>
