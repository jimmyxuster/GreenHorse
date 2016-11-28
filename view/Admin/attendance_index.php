<?php
$projectName = "GreenHorse";
$CourseDBurl = $_SERVER['DOCUMENT_ROOT'].$projectName."/database/CourseDB.php";
$session_filter = $_SERVER['DOCUMENT_ROOT'].$projectName."/view/Admin/session_filter.php";

require_once($session_filter);
require_once($CourseDBurl);
require_once('head.php');
$courseDB = new CourseDB();
$page = $_GET['page'];
$status = $_GET['status'];
if(!$_GET['page'])
{
	$page = 1;
}
$pagesize = 10;
$maxPage = ceil($courseDB->selectCoursesAfterDurationCount()/$pagesize);
	$ingSelected = 'selected';
	if($_GET['status'] == 'ed'){
		$edSelected = 'selected';
		$ingSelected = '';
		$todoSelected = '';
		$courses = $courseDB->selectCoursesAfterDuration(($page-1)*$pagesize, $pagesize);
	}else if($_GET['status'] == 'ing'){
		$edSelected = '';
		$ingSelected = 'selected';
		$todoSelected = '';
		$courses = $courseDB->selectOngoingCourses();
	}else if($_GET['status'] == 'todo'){
		$edSelected = '';
		$ingSelected = '';
		$todoSelected = 'selected';
		$courses = $courseDB->selectAllFutureCourses();
	}
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>考勤管理</title>
	<link rel="stylesheet" href="../../static/style/weui.css"/>
	<link rel="stylesheet" href="../../static/example/example.css"/>
	<link rel="stylesheet" href="../../static/style/myStyle.css"/>
</head>
<body>
<h1 class = "page_title">考勤</h1>
<select id='status' onchange='selectCourseStatus(this.value)'>
<option value='todo'<?php echo $ingSelected?>>未开始的课程</option>
<option value='ing'<?php echo $ingSelected?>>正在进行的课程</option>
<option value='ed' <?php echo $edSelected?>>已结束课程</option>
</select>
<table class='zebra'>
	<tr>
		<th>课程</th>
		<th>时间</th>
		<th>操作</th>
	</tr>
	<?php while($course = mysql_fetch_array($courses)){
			$time = date("m-d H:i",strtotime($course['datetime']));
		?>
	<tr>
		<td><?php echo $course['name']?></td>
		<td><?php echo $time?></td>
		<td>
			<button class="weui_btn weui_btn_mini weui_btn_default" style = "position: relative" onclick="onQRCode('<?php echo $course['id']?>')">二维码签到</button>
			<button class="weui_btn weui_btn_mini weui_btn_default" style = "position: relative" onclick="onAttendance('<?PHP echo $course['id']?>')">出席统计</button>
			<button class="weui_btn weui_btn_mini weui_btn_default" style = "position: relative" onclick="onTable('<?php echo $course['id']?>')">导出签到表</button>
		</td>
	</tr>
	<?php }?>
</table>
<?php
if($status == 'ed')
{
?>
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
<?php
}
?>
</body>
<script>
	function onQRCode(id){
		location.href="qrcodeSignin.php?courseId="+id;
	}

	function selectCourseStatus(status){
		location.href = 'attendance_index.php?status='+status;
	}
	function onAttendance(courseId){
		location.href = 'attendance.php?courseId='+courseId;
	}
	function onTable(courseId){
		location.href = 'do/attendanceTable.php?courseId='+courseId;
	}
	function onPreviousPage(page){
		if(page>=2)
			page--;
		location.href = 'attendance_index.php?status=ed&page='+page;
	}
	function onNextPage(page, maxPage){
		if(page<maxPage)
			page++;
		location.href = 'attendance_index.php?status=ed&page='+page;
	}
</script>
</html>