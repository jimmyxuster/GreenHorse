<?php
$projectName = "GreenHorse";
$TakeCourseDBurl = $_SERVER['DOCUMENT_ROOT'].$projectName."/database/TakeCourseDB.php";
$errorUrl = 'http://'.$_SERVER['HTTP_HOST'].'/'.$projectName."/view/error.php";
require_once($TakeCourseDBurl);

header("Content-Type: text/html; charset=utf-8");
date_default_timezone_set('PRC');

$courseId = $_POST['courseId'];
$studentId = $_POST['studentId'];

if(!$studentId)
{
    header("Location:".$errorUrl."?error_code=108");
    exit;
}

$takecourseDB = new TakeCourseDB();
$takecourseDB->addCourseForStudent($studentId, $courseId);
echo"<script>alert('添加成功！'); location.href='../selectCourse.php';</script>";

?>