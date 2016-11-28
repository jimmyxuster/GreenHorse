<?php
$projectName = "GreenHorse";
$CourseDBurl = $_SERVER['DOCUMENT_ROOT'].$projectName."/database/CourseDB.php";
$CreditDBurl = $_SERVER['DOCUMENT_ROOT'].$projectName."/database/CreditDB.php";
$sessionFilterUrl = $_SERVER['DOCUMENT_ROOT'].$projectName."/view/session_filter.php";
$Userurl = $_SERVER['DOCUMENT_ROOT'].$projectName."/model/User.php";
require_once($Userurl);
require($CourseDBurl);
require($CreditDBurl);
date_default_timezone_set('PRC');
/*
 * 检查session 只有通过正常方法通过过session_filter的用户才能看到当前页面
 */
require($sessionFilterUrl);
session_start();
$user = new User();
$user = $_SESSION['user'];
$userId = $user->id;
//$userId = 1;

$courseDB = new CourseDB();
$allCourses = $courseDB->selectAllUserTakenCourses($userId);
$courses = array();

$creditDB = new CreditDB();
$allCredits = mysql_fetch_array($creditDB->selectAllCreditsNeeded())[0];
$userCredits= mysql_fetch_array($creditDB->selectAllUserFinishedCredits($userId))[0];

$myWidth = $userCredits / $allCredits * 100;
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
    <title>我的课程表</title>
    <link rel="stylesheet" href="../../static/style/weui.css"/>
    <link rel="stylesheet" href="../../static/example/example.css"/>
    <link rel="stylesheet" href="../../static/style/myStyle.css"/>
    <link rel="stylesheet" href="../../static/style/progressBar.css"/>
   	<script type="text/javascript" src="../../static/js/myjs.js"></script>
</head>
<body onload='initCourses()'>
<p class="page_desc">已完成学分/所需学分</p>
<div id="graphbox">
    <div class="graph"><span class="green" style="width: <?php echo $myWidth;?>%;"><?php echo ($userCredits!=0?$userCredits:0).'/'.$allCredits?></span></div>
</div>
<h1 class = "page_title">我的课程表</h1>
<table class = "zebra" style="table-layout:fixed">
    <tr>
    <?php
        $i = 0;
        while($line = mysql_fetch_array($allCourses))
        {
            $courseId = $line['courseId'];
            $courseResult = $courseDB->selectCoursesInfoFromCourseId($courseId);
            $courses[$i] = mysql_fetch_array($courseResult);
            $myDate = date("m-d", strtotime($courses[$i]['datetime']));
            $myTime = date("H:i", strtotime($courses[$i]['datetime']));
            $location = $courses[$i]['location'];
            if(!$location){
            	$location = "";
            }
            if(strtotime($courses[$i]['datetime']) > time())
            {
    ?>
    			<input type='hidden' name='courseIds' value='<?php echo $courseId?>'/>
                <td style='width:50%'><?php echo $courses[$i]['name'] ?></td>
                <td style='width:20%'><?php echo $myDate.'</br>'.$myTime ?></td>
                <td style='width:30%' name="locationOrQuit"><?php echo $location?></td>
    </tr>
    <?php
            }
        $i++;
        }
    ?>
    <tr><td>&nbsp;</td></tr>
</table>
<div class="side-bar">  
    <a href="javascript:clickQuitCourse()" id='float'>退</br>课</a>  
</div>
<button type = "button" class="weui_btn weui_btn_default" onclick="clickfinishedcourses()">查看已结束课程</button>
</body>
<script>
	var courses = new Array();
	function initCourses(){
		var locationOrQuits = document.getElementsByName("locationOrQuit");
		var courseIds = document.getElementsByName("courseIds");
		for(var j=0;j<courseIds.length;j++){
			courses[j] = new Array();
			courses[j][0] = courseIds[j].value;
		}
		for(j=0;j<locationOrQuits.length;j++){
			courses[j][1] = locationOrQuits[j].innerHTML;
		}
	}
	function clickfinishedcourses()
    {
		location.href="finishedCourse_Comment.php";
	}
	function clickQuitCourse(){
		var locationOrQuits = document.getElementsByName("locationOrQuit");
		for(var i=0;i<locationOrQuits.length;i++){
			locationOrQuits[i].innerHTML = "<a href='javascript:;' class='weui_btn weui_btn_mini weui_btn_default' onclick=quitCourse('"+i+"','<?php echo $userId?>')>退课</a>";
	    }
	    document.getElementById('float').innerHTML = "<a href='javascript:clickBack()' id='float'>返</br>回</a>";
	}
	function clickBack(){
		var locationOrQuits = document.getElementsByName("locationOrQuit");
		for(var i=0;i<locationOrQuits.length;i++){
			locationOrQuits[i].innerHTML = courses[i][1];
	    }
	    document.getElementById('float').innerHTML = "<a href='javascript:clickQuitCourse()' id='float'>退</br>课</a>";
	}
	function quitCourse(courseIndex,userId){
		jsPost('Do/doQuitCourse.php', {
	    'userId' : userId,
	    'courseId' : courses[courseIndex][0]
	});
	}
</script>
</html?>