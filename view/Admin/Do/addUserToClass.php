<?php
$projectName = "GreenHorse";
$ClassDBurl = $_SERVER['DOCUMENT_ROOT'].$projectName."/database/ClassDB.php";
$errorUrl = 'http://'.$_SERVER['HTTP_HOST'].'/'.$projectName."/view/error.php";
$session_filter = $_SERVER['DOCUMENT_ROOT'].$projectName."/view/Admin/session_filter.php";
require_once($ClassDBurl);
header("Content-Type: text/html; charset=utf-8");

	$userId = $_GET['userId'];
	$classId = $_GET['classId'];
	
	if(!$_GET['userId'] || !$_GET['classId']){
		header("Location:".$errorUrl."?error_code=101");
    	exit;
	}
	
	$classDB = new ClassDB();
	if(mysql_fetch_array($classDB->selectUserInClass($userId, $classId))){
		echo "<script>alert('学生已在该班级中！');history.go(-1);</script>";
		exit;
	}
	if(mysql_fetch_array($classDB->selectUserNotInClass($userId, $classId))){
		echo "<script>alert('添加失败，学生在其他班级中！');history.go(-1);</script>";
		exit;
	}
	$userinclass = array();
	$userinclass['userId'] = $userId;
	$userinclass['classId'] = $classId;
	$classDB->insertUserInClass($userinclass);
	header("Location:../importClassLeft.php?refresh=true&classId=".$classId);
?>
