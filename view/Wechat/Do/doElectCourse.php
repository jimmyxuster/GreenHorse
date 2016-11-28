<?php
$projectName = "GreenHorse";
$courseDBurl = $_SERVER['DOCUMENT_ROOT'].$projectName."/database/CourseDB.php";
$errorUrl = 'http://'.$_SERVER['HTTP_HOST'].'/'.$projectName."/view/error.php";
require_once($courseDBurl);
header("Content-Type: text/html; charset=utf-8");
date_default_timezone_set('PRC');

	$courseId = $_POST['courseId'];
	$userId = $_POST['userId'];
	$moduleId = $_POST['moduleId'];
	//如果参数不对，转到错误页面
	if(!$courseId || !$userId){
		header("Location:".$errorUrl."?error_code=101");
		exit;
	}
	$courseDB = new CourseDB();
	$line = mysql_fetch_array($courseDB->selectTakecourse($userId,$courseId));
	if($line != null){
		header("Location:".$errorUrl."?error_code=102");
		exit;
	}
	$takecourse = array();
	$takecourse['courseId'] = $courseId;
	$takecourse['studentId'] = $userId;
	$courseDB->addTakecourse($takecourse);
	echo"<script>alert('选课成功！');location.href='../electCourse.php?moduleId=".$moduleId."';</script>";  
?>
