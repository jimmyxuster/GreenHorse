<?php
$projectName = "GreenHorse";
$CourseDBurl = $_SERVER['DOCUMENT_ROOT'].$projectName."/database/CourseDB.php";
$CommentDBurl = $_SERVER['DOCUMENT_ROOT'].$projectName."/database/CommentDB.php";
$session_filter = $_SERVER['DOCUMENT_ROOT'].$projectName."/view/Admin/session_filter.php";
require_once('head.php');
require_once($session_filter);
require_once($CourseDBurl);
require_once($CommentDBurl);
header("Content-Type: text/html; charset=utf-8");	

$courseId = $_GET['courseId'];
$courseDB = new CourseDB();
$course = mysql_fetch_array($courseDB->selectCoursesInfoFromCourseId($courseId));
$commentDB = new CommentDB();
$comments = $commentDB->selectCommentsByCourseId($courseId);
?>
<html>
<head>
	<title>评语</title>
	<link rel="stylesheet" href="../../static/style/weui.css"/>
	<link rel="stylesheet" href="../../static/example/example.css"/>
	<link rel="stylesheet" href="../../static/style/myStyle.css"/>
</head>
<body>
<a href = "rating.php">返回</a>

<h1 class = "page_title"><?php echo $course['name'].' 收到的评语'?></h1>
<table class='zebra'>
	<tr>
		<th width="5%">编号</th>
		<th>评语</th>
	</tr>
	<?php
		$i = 0;
		$line = mysql_fetch_array($comments);
		while($line != null){
			//没写评语的comment不显示
			if($line['comment'] != '' && $line['comment'] != null){
				$i++;			
	?>
	<tr>
		<td><?php echo $i?></td>
		<td><?php echo $line['comment']?></td>
	</tr>
	<?php
			}
			$line = mysql_fetch_array($comments);
		}
	?>
</table>
</body>
</html>
