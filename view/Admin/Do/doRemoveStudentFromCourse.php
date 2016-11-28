<?php
$projectName = "GreenHorse";
$TakeCourseDBurl = $_SERVER['DOCUMENT_ROOT'].$projectName."/database/TakeCourseDB.php";
$errorUrl = 'http://'.$_SERVER['HTTP_HOST'].'/'.$projectName."/view/error.php";
require_once($TakeCourseDBurl);

header("Content-Type: text/html; charset=utf-8");
date_default_timezone_set('PRC');

$studentId = $_GET['studentId'];
$courseId = $_GET['courseId'];

if(!$studentId || !$courseId)
{
    header("Location:".$errorUrl."?error_code=103");
    exit;
}

$takecourseDB = new TakeCourseDB();
$takecourseDB->removeStudentFromCourse($studentId, $courseId);
echo"<script>location.href='../selectCourse_Table.php?courseId='+$courseId;</script>";
?>