<html>
<?php
	$error_code = $_GET['error_code'];
	define("E100", "抱歉，您不是青马班成员！");
	define("E101", "非法路径。");
	define("E102", "重复选课！");
	define("E103", "移除失败！");
	define("E104", "导入学生失败！");
	define("E105", "导入模块失败！");
	define("E106", "导入班级失败！");
	define("E107", "导入课程失败！");
	define("E108", "添加学生失败！");
	
	if($error_code == "100"){
		$show = E100;	
	}
	if($error_code == "101"){
		$show = E101;	
	}
	if($error_code == "102"){
		$show = E102;	
	}
	if($error_code == "103"){
		$show = E103;
	}	
	if($error_code == "104"){
		$show = E104;
	}
	if($error_code == "105"){
		$show = E105;
	}
	if($error_code == "106"){
		$show = E106;
	}
	if($error_code == "107"){
		$show = E107;
	}
	if($error_code == "108"){
		$show = E108;
	}
?>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
<div style = "font-family: 'Microsoft Yahei';
 	font-size: 20px;
    text-align: center;        /*文字水平居中对齐*/
    overflow:hidden;">
	<?php echo "~~~~(>_<)~~~~"; ?>
</div>
<div style = "font-family: 'Microsoft Yahei';
 	font-size: 20px;
    text-align: center;        /*文字水平居中对齐*/
    line-height: 200px;        /*设置文字行距等于div的高度*/
    overflow:hidden;">
	<?php echo $show;?>
</div>
</body>
</html>