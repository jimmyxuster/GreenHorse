<?php
$projectName = "GreenHorse";
$ClassDBurl = $_SERVER['DOCUMENT_ROOT'].$projectName."/database/ClassDB.php";
$session_filter = $_SERVER['DOCUMENT_ROOT'].$projectName."/view/Admin/session_filter.php";

require_once($ClassDBurl);
header("Content-Type: text/html; charset=utf-8");	
	
	$classId = $_GET['classId'];
	if(!$classId){
		exit;
	}
	
	if($_GET['refresh'] == 'true'){
		echo "<script>window.parent.left_frame.location.href='importClassLeft.php?classId=".$classId."';</script>";
	}
	
	$classDB = new ClassDB();
	$students = $classDB->selectUserInClassByClassId($classId);
?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" href="../../static/style/weui.css"/>
	<link rel="stylesheet" href="../../static/example/example.css"/>
	<link rel="stylesheet" href="../../static/style/myStyle.css"/>
</head>
<body>
<center>
<h3>当前成员</h3>
<table class='zebra'>
<?php
while($student = mysql_fetch_array($students)){?>
<tr>
	<td><?php echo $student['userId']?></td>
	<td><?php echo $student['name']?></td>
	<td><button class="weui_btn weui_btn_mini weui_btn_default" style = "position: relative" onclick="onRemove('<?php echo $student['userId']?>','<?php echo $classId?>')">移除</button></td>
</tr>
<?php
}?>
</table>
</center>
</body>
<script>
	function onRemove(userId, classId) {
		if (window.confirm("将要把这个学生从此班级中删除。确定吗?")) {
			location.href = 'Do/removeUserInClass.php?userId=' + userId + '&classId=' + classId;
		}
	}
</script>
</html>
