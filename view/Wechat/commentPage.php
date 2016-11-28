<?php
$projectName = "GreenHorse";
$CourseDBurl = $_SERVER['DOCUMENT_ROOT'].$projectName."/database/CourseDB.php";
$CommentDBurl = $_SERVER['DOCUMENT_ROOT'].$projectName."/database/CommentDB.php";
$sessionFilterUrl = $_SERVER['DOCUMENT_ROOT'].$projectName."/view/session_filter.php";
$Userurl = $_SERVER['DOCUMENT_ROOT'].$projectName."/model/User.php";
require_once($Userurl);
require_once($CourseDBurl);
require_once($CommentDBurl);
/*
 * 检查session 只有通过正常方法通过过session_filter的用户才能看到当前页面
 */
require($sessionFilterUrl);
session_start();
$user = new User();
$user = $_SESSION['user'];
$userId = $user->id;
date_default_timezone_set('PRC');
header("Content-Type: text/html; charset=utf-8");

//$userId = 1;

//检查是否收到courseId传参，如果没有，转送到错误页面
if(!$_GET['courseId']){
	header("Location:../error.php?error_code=101");
	exit;
}
$courseId = $_GET['courseId'];

//检查comment是否已经存在，如果已经存在，则不能重复评价；返回上一页
$commentDB = new CommentDB();
$comment = mysql_fetch_array($commentDB->selectComment($userId, $courseId));
if($comment){
	echo"<script>alert('不能重复评价！');history.go(-1);</script>";  
}

$courseDB = new CourseDB();
$course = mysql_fetch_array($courseDB->selectCoursesInfoFromCourseId($courseId));
//如果courseId不存在，提示错误消息并返回上一页
if(!$course){
	echo"<script>alert('课程不存在！');history.go(-1);</script>";  
}
?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
	<title>课程评价</title>
	<link rel="stylesheet" href="../../static/style/weui.css"/>
	<link rel="stylesheet" href="../../static/example/example.css"/>
	<link rel="stylesheet" href="../../static/style/myStyle.css"/>
	<script type="text/javascript" src="../../static/js/myjs.js"></script>
</head>
<body style = "text-align: center;">
<h1 class = "page_title2" style = "font-size = 20px;"><?php echo $course['name']?></h1>
<br>
<div style = "margin:0 auto; font-size: 19px;">
<p>课程内容
	<input type = "radio" value = "1" name = "content" onclick="clickContent(1)">1
	<input type = "radio" value = "2" name = "content" onclick="clickContent(2)">2
	<input type = "radio" value = "3" name = "content" onclick="clickContent(3)">3
	<input type = "radio" value = "4" name = "content" onclick="clickContent(4)">4
	<input type = "radio" value = "5" name = "content" onclick="clickContent(5)">5
</p>
	<p class = "splitline"></p>
<p>教师水平
	<input type = "radio" value = "1" name = "teacher" onclick="clickTeacher(1)">1
	<input type = "radio" value = "2" name = "teacher" onclick="clickTeacher(2)">2
	<input type = "radio" value = "3" name = "teacher" onclick="clickTeacher(3)">3
	<input type = "radio" value = "4" name = "teacher" onclick="clickTeacher(4)">4
	<input type = "radio" value = "5" name = "teacher" onclick="clickTeacher(5)">5
</p>
	<p class = "splitline"></p>
<p>所得收获
	<input type = "radio" value = "1" name = "harvest" onclick="clickHarvest(1)">1
	<input type = "radio" value = "2" name = "harvest" onclick="clickHarvest(2)">2
	<input type = "radio" value = "3" name = "harvest" onclick="clickHarvest(3)">3
	<input type = "radio" value = "4" name = "harvest" onclick="clickHarvest(4)">4
	<input type = "radio" value = "5" name = "harvest" onclick="clickHarvest(5)">5
</p>
	<p class = "splitline"></p>
<p>评语</p>
<textarea rows = "5" cols = "30" id='comment'></textarea>
<br>
<button class="weui_btn weui_btn_default" onclick="submit('<?php echo $userId?>','<?php echo $courseId?>')">提交</button>
</div>
</body>
<script>
var content = 0;
var teacher = 0;
var harvest = 0;
function clickContent(point){
	content = point;
}
function clickTeacher(point){
	teacher = point;
}
function clickHarvest(point){
	harvest = point;
}
function submit(userId, courseId){
	if(teacher<=0 || content <=0 || harvest<=0){
		alert('评分不能为空！');
		return;
	}
	jsPost('Do/doComment.php', {
	    'content': content,
	    'teacher': teacher,
	    'harvest': harvest,
	    'comment': document.getElementById('comment').value,
	    'userId' : userId,
	    'courseId' : courseId
	});
}
</script>
</html>