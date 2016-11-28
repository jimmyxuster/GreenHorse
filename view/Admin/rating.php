<?php
$projectName = "GreenHorse";
$CourseDBurl = $_SERVER['DOCUMENT_ROOT'].$projectName."/database/CourseDB.php";
$CommentDBurl = $_SERVER['DOCUMENT_ROOT'].$projectName."/database/CommentDB.php";
$session_filter = $_SERVER['DOCUMENT_ROOT'].$projectName."/view/Admin/session_filter.php";
require_once('head.php');
require_once($session_filter);
require_once($CourseDBurl);
require_once($CommentDBurl);

$courseDB = new CourseDB();
$commentDB = new CommentDB();
$page = $_GET['page'];
if(!$_GET['page'])
{
	$page = 1;
}
$pagesize = 10;
$maxPage = ceil($courseDB->selectCoursesCount()/$pagesize);

$courses = $courseDB->selectCourses(($page-1)*$pagesize, $pagesize);
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>评价管理</title>
	<link rel="stylesheet" href="../../static/style/weui.css"/>
	<link rel="stylesheet" href="../../static/example/example.css"/>
	<link rel="stylesheet" href="../../static/style/myStyle.css"/>
</head>
<body>
<h1 class = "page_title">评价</h1>
<table class='zebra' style='table-layout:fixed'>
<tr>
	<th style='width:30%'>课程</th>
	<th style='width:13%'>课程内容</th>
	<th style='width:13%'>教师水平</th>
	<th style='width:13%'>所得收获</th>
	<th style='width:30%'>评语</th>
	<th style='width:30%'>退课理由</th>
</tr>
<?php while($line = mysql_fetch_array($courses)){
	$courseId = $line['id'];
	$courseName = $line['name'];	
	$comment = mysql_fetch_array($commentDB->selectAvgRatingByCourseId($courseId));
	$commentWords = mysql_fetch_array($commentDB->selectCommentsByCourseId($courseId));
	$quitReasons = mysql_fetch_array($commentDB->selectQuitReasonsByCourseId($courseId));
?>
<tr>
	<td><?php echo $courseName?></td>
	<td><?php echo $comment['rating1'];?></td>
	<td><?php echo $comment['rating2'];?></td>
	<td><?php echo $comment['rating3'];?></td>
	<td><a href='comments.php?courseId=<?php echo $courseId?>'><?php echo $commentWords['comment']?></a></td>
	<td><a href='quitReasons.php?courseId=<?php echo $courseId?>'><?php echo $quitReasons['reason']?></a></td>
</tr>
<?php }?>
</table>
<br><br>
<div id="buttons" align="center">
	<?php
	if($page != 1) {
	?>
		<button class="weui_btn weui_btn_mini weui_btn_plain_default" style="position: relative"
				onclick="onPreviousPage(<?php echo $page; ?>)">上一页
		</button>&nbsp;&nbsp;&nbsp;
		<?php
	}
	?>
	<?php
	if($page != $maxPage) {
		?>
		<button class="weui_btn weui_btn_mini weui_btn_plain_default" style="position: relative"
				onclick="onNextPage(<?php echo $page; ?>,<?php echo $maxPage; ?>)">下一页
		</button>
		<?php
	}
	?>
</div><br>
<button class="weui_btn weui_btn_default" style = "position: relative" onclick="clickExport('<?php echo $courseId?>')">导出表格...</button>
<!--<button class="weui_btn weui_btn_default" style = "position: relative">导出图表...</button>-->
</body>
<script>
	function clickExport(){
		location.href='Do/ratingTable.php';
	}
	function onPreviousPage(page){
		if(page>=2)
			page--;
		location.href = 'rating.php?page='+page;
	}
	function onNextPage(page, maxPage){
		if(page<maxPage)
			page++;
		location.href = 'rating.php?page='+page;
	}
</script>
</html>