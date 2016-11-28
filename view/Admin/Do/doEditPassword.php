<?php
$projectName = "GreenHorse";
$Userurl = $_SERVER['DOCUMENT_ROOT'].$projectName."/model/User.php";
$session_filter = $_SERVER['DOCUMENT_ROOT'].$projectName."/view/Admin/session_filter.php";
$UserDBurl = $_SERVER['DOCUMENT_ROOT'].$projectName."/database/UserDB.php";
require($UserDBurl);
require_once($Userurl);
require_once($session_filter);
header("Content-Type: text/html; charset=utf-8");	
	
	$user = new User();
	session_start();
	$user = $_SESSION['admin'];
	$password = $_POST['password'];
	$userDB = new UserDB();
	
	$userDB->updateUserPermission($user->permission,$user->id,$password);
	echo "<script>alert('修改成功！');location.href='../main.php';</script>";
?>
