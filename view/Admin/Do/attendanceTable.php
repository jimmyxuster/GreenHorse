<?php
header('Content-Type:application/vnd.ms-excel');
header('Content-Disposition:attachment;filename=出勤统计表.xls');
header('Pragma:no-cache');
header('Expires:0');

$projectName = "GreenHorse";
$CourseDBurl = $_SERVER['DOCUMENT_ROOT'].$projectName."/database/CourseDB.php";
$errorUrl = 'http://'.$_SERVER['HTTP_HOST'].'/'.$projectName."/view/error.php";
$session_filter = $_SERVER['DOCUMENT_ROOT'].$projectName."/view/Admin/session_filter.php";

require_once($session_filter);
require($CourseDBurl);

if(!$_GET['courseId']){
	header("Location:".$errorUrl."?error_code=101");
	exit;
}
$courseId = $_GET['courseId'];

$courseDB = new CourseDB();
$course = mysql_fetch_array($courseDB->selectCoursesInfoFromCourseId($courseId));
$takecourses = $courseDB->selectTakecourseAndUserInfoByCourseId($courseId);
$beforeTitle = array("课程名称",$course['name'],"上课时间",date("m-d H:i",strtotime($course['datetime'])));
$blank = array('','');
$title = array('学号','姓名','出席情况');
$data = array();
for($i=0; $takecourse=mysql_fetch_array($takecourses); $i++){
	$data[$i] = array($takecourse['studentId'],$takecourse['name'],$takecourse['attendance']);
}
echo iconv('utf-8','gbk',implode("\t",$beforeTitle))."\n";
echo iconv('utf-8','gbk',implode("\t",$blank))."\n";
echo iconv('utf-8','gbk',implode("\t",$title))."\n";
foreach ($data as $value){
	echo iconv('utf-8','gbk',implode("\t",$value))."\n";
}