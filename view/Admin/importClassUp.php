<?php
$projectName = "GreenHorse";
$classDBurl = $_SERVER['DOCUMENT_ROOT'].$projectName."/database/ClassDB.php";
require($classDBurl);
$classDB = new ClassDB();
$allClasses = $classDB->selectAllClasses();
	$show = $_GET['show'];
	$classId = $_GET['classId'];
	$className = $_GET['className'];
	if($classId){
		echo "<script>window.parent.mainweb.left_frame.location.href='importClassLeft.php?classId=".$classId."';</script>";
		echo "<script>window.parent.mainweb.right_frame.location.href='importClassRight.php?classId=".$classId."';</script>";
	}
//	require_once('head.php');
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" href="../../static/style/weui.css"/>
	<link rel="stylesheet" href="../../static/example/example.css"/>
	<link rel="stylesheet" href="../../static/style/myStyle.css"/>
</head>
<body>
<button class="weui_btn weui_btn_mini weui_btn_default" style = "position: relative" onclick = "top.location.href = 'import.php'">返回</button>
 <div>
	<center>
		<h1 class = "page_title">导入或查询班级</h1>
		<p class="page_desc">
			<?php
			echo "已存在的班级： ";
			while($line = mysql_fetch_array($allClasses)) {
				$classesName = $line['name'];
				echo $classesName." ";
			}
			?>
		</p>
		班级名称
		<?php if(!$classId) {?>
		<input type = "text" name = "className" id="className" />
		<button class="weui_btn weui_btn_mini weui_btn_default" style = "position: relative" onclick='onAdd()'>查询或添加</button>
		<?php }else{ echo $className;}?>
		<?php echo ' '.$show?>
		</center>
 </div>
</body>
<script>
function onAdd(){
	location.href='Do/doImportClass.php?className='+document.getElementById('className').value;
}
</script>
</html>
