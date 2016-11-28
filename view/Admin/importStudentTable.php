<?php
require_once('head.php');
?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
<a href = "importStudent.php">返回</a>

<h1 align='center'>导入表格要求</h1>
<p>
1.表格后缀名是xls、xlsx或csv<br/>
2.表格的第一行是属性名，第二行开始是具体学生信息。属性名可以有：院系，所属支部，姓名，学号，性别，年级，宿舍，邮箱，手机号码，类别。<br/>
3.属性名可以不止于以上几种，但不会被存入数据库。<br/>
4.******学号和姓名是必填的。******<br/>
5.如果数据库中已存在该学号的学生，则表格中的信息会覆盖数据库。<br/>
</p>
<div align='center'>
	<form action="uploadStudentTable.php" method="post"
	enctype="multipart/form-data">
	<label for="file">选择文件:</label>
	<input type="file" name="file" id="file" /> 
	<br />
	<input type="submit" name="submit" value="上传" />
	</form>
</div>
<p align='center'><b>图表实例</b></p>
<img src='../../static/image/studentTableExample.bmp' width='80%'/>
</body>
</html>
