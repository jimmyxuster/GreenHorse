<?php
$projectName = "GreenHorse";
$ClassDBurl = $_SERVER['DOCUMENT_ROOT'].$projectName."/database/ClassDB.php";
$session_filter = $_SERVER['DOCUMENT_ROOT'].$projectName."/view/Admin/session_filter.php";

require_once($ClassDBurl);
header("Content-Type: text/html; charset=utf-8");	

	$classDB = new ClassDB();
	$students = $classDB->selectStudentsNotInClass();
	
	$classId = $_GET['classId'];
	if(!$classId){
		exit;
	}
	
	$refresh = $_GET['refresh'];
	if($refresh == 'true'){
		echo "<script>window.parent.right_frame.location.href='importClassRight.php?classId=".$classId."';</script>";
	}
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
	<h3>向班级导入学生</h3>
	<p>按学号导入(多个用逗号隔开)</p>
	<form action='Do/addSeveralUsersToClass.php' method='get'>
		<input type='hidden' name='classId' value='<?php echo $classId?>'>
	    <textarea cols="30" rows="1" name = "inputIds"/></textarea>
	    <input class="weui_btn weui_btn_mini weui_btn_default" style = "position: relative" type='submit'value='添加'/>
	</form>
	<br>
	<p>点击人名导入</p>
<?php
	while($student = mysql_fetch_array($students)) {
		if ($student['permission'] != 'superadmin') {
			?>
			<a href='Do/addUserToClass.php?userId=<?php echo $student['id'] ?>&classId=<?php echo $classId ?>'><?php echo $student['id'] . ' ' . $student['name'] ?></a>
			<?php
		}
	}
?>
	<br>
</center>
</body>
</html>