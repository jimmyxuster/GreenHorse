<?php
$projectName = "GreenHorse";
$courseDBurl = $_SERVER['DOCUMENT_ROOT'].$projectName."/database/courseDB.php";
require_once($courseDBurl);
date_default_timezone_set('PRC');

header("Content-Type: text/html; charset=utf-8");

session_start();
$courseId = $_SESSION['courseId'];
$userId = $_SESSION['userId'];
$reason = $_GET['reason'];

$courseDB = new CourseDB();

$courseDB->addQuitCourse($userId, $courseId, $reason);
$courseDB->deleteTakecourse($userId, $courseId);
echo "<script>alert('退课成功！');location.href='../courseSchedule.php';</script>";

?>