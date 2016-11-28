<?php
$projectName = "GreenHorse";
$CourseDBurl = $_SERVER['DOCUMENT_ROOT'].$projectName."/database/CourseDB.php";
$session_filter = $_SERVER['DOCUMENT_ROOT'].$projectName."/view/Admin/session_filter.php";

require_once($session_filter);
require($CourseDBurl);

	header("Content-Type: text/html; charset=utf-8");
	
	if(!$_POST['courseId']){
		header("Location:".$errorUrl."?error_code=101");
		exit;
	}
	$courseId = $_POST['courseId'];	

	$json = json_decode($_POST['studentAttendance']);
	
	$courseDB = new CourseDB();	
	$takecourse = array();
	$takecourse['courseId'] = $courseId;
	while ($elem = each($json)) {
		$takecourse['studentId'] = $elem['key'];
		$takecourse['attendance'] = $elem['value'];
		$courseDB->updateTakecourse($takecourse);
	}
	echo "<script>alert('保存成功！');location.href='../attendance.php?courseId=".$courseId."';</script>";
?>
