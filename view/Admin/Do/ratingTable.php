<?php
header('Content-Type:application/vnd.ms-excel');
header('Content-Disposition:attachment;filename=课程评价表.xls');
header('Pragma:no-cache');
header('Expires:0');

$projectName = "GreenHorse";
$CourseDBurl = $_SERVER['DOCUMENT_ROOT'].$projectName."/database/CourseDB.php";
$CommentDBurl = $_SERVER['DOCUMENT_ROOT'].$projectName."/database/CommentDB.php";
$errorUrl = 'http://'.$_SERVER['HTTP_HOST'].'/'.$projectName."/view/error.php";
$session_filter = $_SERVER['DOCUMENT_ROOT'].$projectName."/view/Admin/session_filter.php";

require_once($session_filter);
require($CourseDBurl);
require($CommentDBurl);

$courseDB = new CourseDB();
$commentDB = new CommentDB();
$courses = $courseDB->selectAllFinishedCourses();
$title = array('课程','课程内容','教师水平','所得收获');
$data = array();
for($i=0; $course=mysql_fetch_array($courses); $i++){
    $courseId = $course['id'];
    $comment = mysql_fetch_array($commentDB->selectAvgRatingByCourseId($courseId));
    $data[$i] = array($course['name'],$comment['rating1'],$comment['rating2'],$comment['rating3']);
}
echo iconv('utf-8','gbk',implode("\t",$title))."\n";
foreach ($data as $value){
    echo iconv('utf-8','gbk',implode("\t",$value))."\n";
}