<?php
$projectName = "GreenHorse";
$CourseDBurl = $_SERVER['DOCUMENT_ROOT'].$projectName."/database/CourseDB.php";
$errorUrl = 'http://'.$_SERVER['HTTP_HOST'].'/'.$projectName."/view/error.php";
require_once($CourseDBurl);

header("Content-Type: text/html; charset=utf-8");
date_default_timezone_set('PRC');

$courseName = $_POST['courseName'];
$credit = $_POST['credit'];
$year = $_POST['year'];
$month = $_POST['month'];
$day = $_POST['day'];
$hour = $_POST['hour'];
$minute = $_POST['minute'];
$location = $_POST['location'];
$duration = $_POST['duration'];
$maxNumber = $_POST['maxNumber'];
//$restriction = $_POST['restriction'];
$module = $_POST['module'];
$datetime = $year.'-'.$month.'-'.$day.' '.$hour.':'.$minute.':00';

if(!$courseName || !$datetime || !$location || !$module)
{
    echo "<script>alert('内容输入有误！请检查！');history.go(-1);</script>";
}

if(!$_POST['duration'])
{
    $duration = 120;
}
if(!$_POST['maxNumber'])
{
    $maxNumber = 999;
}

$courseDB = new CourseDB();
if($courseDB->courseNotExists($courseName)) {
    $courseDB->insertCourse($courseName, $credit, $datetime, $location, $duration, $maxNumber, $module);
    echo"<script>alert('导入成功！'); location.href='../importCourse.php';</script>";
}
else{
    echo "<script>alert('该课程名已存在，导入失败。'); location.href='../importCourse.php';</script>";
}