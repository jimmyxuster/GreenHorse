<?php
$projectName = "GreenHorse";
$UserDBurl = $_SERVER['DOCUMENT_ROOT'].$projectName."/database/UserDB.php";
$errorUrl = 'http://'.$_SERVER['HTTP_HOST'].'/'.$projectName."/view/error.php";
$userURL = $_SERVER['DOCUMENT_ROOT'].$projectName."/model/User.php";
require_once($userURL);
require_once($UserDBurl);
header("Content-Type: text/html; charset=utf-8");	

	$userId = $_POST['id'];
	$password = $_POST['pwd'];

	$user = new User($userId);
	//用户不是管理员
	if(!$user || ($user->permission!='admin' && $user->permission!='superadmin')){
		echo "<script>alert('您不是管理员！');history.go(-1);</script>";
		exit;
	}
	//检查用户密码
	else{
		if($user->password == $password){
			session_start();
			$_SESSION['admin'] = $user;
			header("Location:../main.php");	
		}else{
			echo "<script>alert('密码错误');history.go(-1);</script>";
		}
	}
?>
