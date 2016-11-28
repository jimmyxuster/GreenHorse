<?php
$projectName = "GreenHorse";
$courseDBurl = $_SERVER['DOCUMENT_ROOT'].$projectName."/database/courseDB.php";
require_once($courseDBurl);
date_default_timezone_set('PRC');
	
	header("Content-Type: text/html; charset=utf-8");
	
	$courseId = $_POST['courseId'];
	$userId = $_POST['userId'];
	session_start();
	$_SESSION['courseId'] = $courseId;
    $_SESSION['userId'] = $userId;
?>
<script>
	function input_reason()
	{
		var reason = window.prompt('请输入退课理由：', '');
		if(reason == null){
			alert('你取消了输入，退课失败。');
			location.href='../courseSchedule.php';
		}else if(reason == ''){
			alert('理由输入为空，请重新输入。');
			input_reason();
		}else{
			location.href="../Do/doAddQuitReason.php?reason=" + reason;
		}

	}
</script>
<?php
	$courseDB = new CourseDB();
	$course = mysql_fetch_array($courseDB->selectCoursesInfoFromCourseId($courseId));


	//如果已经过了课程时间，就不能退课了
	if(strtotime($course['datetime']) <= time())
	{
		echo"<script>alert('课程已经开始，不能退课！');location.href='../courseSchedule.php';</script>"; 
		exit;
	}
	else if(strtotime($course['datetime'])-43200 <= time())
	{
		echo"<script>alert('十二小时内即将开始的课程不能退课！');location.href='../courseSchedule.php';</script>";
		exit;
	}
	else
	{
		echo "<script>input_reason()</script>";
	}
	//header("Location:../courseSchedule.php");
?>
