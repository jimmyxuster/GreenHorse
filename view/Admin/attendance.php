<?php
$projectName = "GreenHorse";
$CourseDBurl = $_SERVER['DOCUMENT_ROOT'].$projectName."/database/CourseDB.php";
$session_filter = $_SERVER['DOCUMENT_ROOT'].$projectName."/view/Admin/session_filter.php";

require_once($session_filter);
require($CourseDBurl);
require_once('head.php');
header("Content-Type: text/html; charset=utf-8");	

	$courseDB = new CourseDB();	
	$courseId = $_GET['courseId'];
	$course = mysql_fetch_array($courseDB->selectCoursesInfoFromCourseId($courseId));
	$students = $courseDB->selectStudentsInCourse($courseId);
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>考勤管理</title>
	<link rel="stylesheet" href="../../static/style/weui.css"/>
	<link rel="stylesheet" href="../../static/example/example.css"/>
	<link rel="stylesheet" href="../../static/style/myStyle.css"/>
    <script type="text/javascript" src="../../static/js/myjs.js"></script>
</head>
<body>
<h1 class = "page_title"><?php echo $course['name']?>考勤</h1>
<table class = "zebra">
    <thead>
    <tr>
        <th>学号</th>
        <th>姓名</th>
        <th>出勤情况&nbsp;</th>
    </tr>
    </thead>
    <?php while($student = mysql_fetch_array($students)){
    		$present = '';
    		$ill = '';
    		$absent = '';
    		$takecourse = mysql_fetch_array($courseDB->selectTakecourse($student['id'],$courseId));
    		if($takecourse['attendance'] == '出席'){
    			$present = 'checked';
    		}else if($takecourse['attendance'] == '请假'){
    			$ill = 'checked';
    		}else if($takecourse['attendance'] == '缺席'){
    			$absent = 'checked';
    		}
    	?>
    <tr>
        <td><?php echo $student['id']?></td>
        <td><?php echo $student['name']?></td>
        <td>
            <input type = "radio" value = "出席" name = "attendance<?php echo $student['id']?>" onclick="onChangeAttendance('<?php echo $student['id']?>',this.value)" <?php echo $present?>/>出席
            <input type = "radio" value = "请假" name = "attendance<?php echo $student['id']?>" onclick="onChangeAttendance('<?php echo $student['id']?>',this.value)"<?php echo $ill?>/>请假
            <input type = "radio" value = "缺席" name = "attendance<?php echo $student['id']?>" onclick="onChangeAttendance('<?php echo $student['id']?>',this.value)"<?php echo $absent?>/>缺席
        </td>
    </tr>
    <?php }?>
</table>
<form name='form' id='form' method='post' action='Do/saveAttendance.php'>
<input type='hidden' name='studentAttendance' id='studentAttendance'>
<input type='hidden' name='courseId' value='<?php echo $courseId?>'>

	<br>
<button class="weui_btn weui_btn_default" style = "position: relative" onclick = 'onSave()'>保存</button>
</form>
<button class="weui_btn weui_btn_default" style = "position: relative" type = "button" onclick="clickExport('<?php echo $courseId?>')">导出签到表</button>
</body>
<script>
	var attendance = {};
	function clickExport(courseId){
		location.href='Do/attendanceTable.php?courseId='+courseId;
	}
	function onSave(){
		document.getElementById('studentAttendance').value = JSON.stringify(attendance);
		document.form.submit();
	}
	function onChangeAttendance(studentId,value){
		attendance[studentId] = value;
	}
</script>
</html>