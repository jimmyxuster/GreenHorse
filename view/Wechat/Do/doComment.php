<?php
$projectName = "GreenHorse";
$commentDBurl = $_SERVER['DOCUMENT_ROOT'].$projectName."/database/CommentDB.php";
require_once($commentDBurl);
date_default_timezone_set('PRC');

	header("Content-Type: text/html; charset=utf-8");
	$courseId = $_POST['courseId'];
	$userId = $_POST['userId'];
	$content = $_POST['content'];
	$teacher = $_POST['teacher'];
	$harvest = $_POST['harvest'];
	$commentwords = $_POST['comment'];
	
	$comment = array();
	$comment['courseId'] = $courseId;
	$comment['studentId'] = $userId;
	$comment['rating1'] = $content;
	$comment['rating2'] = $teacher;
	$comment['rating3'] = $harvest;
	$comment['comment'] = $commentwords;
	
	$commentDB = new CommentDB();
	$commentDB->insertComment($comment);
	echo"<script>alert('评价成功！');location.href='../finishedCourse_Comment.php';</script>"; 
?>
