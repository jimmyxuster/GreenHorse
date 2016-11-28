<?php
$projectName = "GreenHorse";
$UserDBurl = $_SERVER['DOCUMENT_ROOT'].$projectName."/database/UserDB.php";
$errorUrl = 'http://'.$_SERVER['HTTP_HOST'].'/'.$projectName."/view/error.php";
require_once($UserDBurl);
header("Content-Type: text/html; charset=utf-8");

	$adminId =$_POST['adminId'];
	$userDB = new UserDB();
	/*
	 * 查看用户是否在user表中
	 */
	 $newAdmin = mysql_fetch_array($userDB->selectUserById($adminId));
	 if(!$newAdmin){//用户不在user表里
	 	echo "<script>alert('输入有误');history.go(-1);</script>";
	 	exit;
	 }else if($newAdmin['permission'] == 'admin' || $newAdmin['permission'] == 'superadmin'){//用户已经是管理员了
	 	echo "<script>alert('对方已经是管理员了！');history.go(-1);</script>";
	 	exit;
	 }else{
	 	//升级用户的permission，并且把密码修改成默认密码（之前是null）
	 	$userDB->updateUserPermission("admin",$adminId,'qingma');
	 	echo "<script>alert('添加成功');location.href='../manager.php';</script>";
	 }	
?>
