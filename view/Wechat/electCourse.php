<?php
$projectName = "GreenHorse";
$CourseDBurl = $_SERVER['DOCUMENT_ROOT'].$projectName."/database/CourseDB.php";
$ModuleDBurl = $_SERVER['DOCUMENT_ROOT'].$projectName."/database/ModuleDB.php";
$CreditDBurl = $_SERVER['DOCUMENT_ROOT'].$projectName."/database/CreditDB.php";
$sessionFilterUrl = $_SERVER['DOCUMENT_ROOT'].$projectName."/view/session_filter.php";
$Userurl = $_SERVER['DOCUMENT_ROOT'].$projectName."/model/User.php";
require_once($Userurl);
require($CourseDBurl);
require($CreditDBurl);
require($ModuleDBurl);
date_default_timezone_set('PRC');
/*
 * 检查session 只有通过正常方法通过过session_filter的用户才能看到当前页面
 */	 

require($sessionFilterUrl);
session_start();
$user = new User();
$user = $_SESSION['user'];
$userId = $user->id;


	//预处理标签栏
	$moduleDB = new ModuleDB();
    $allModules = $moduleDB->selectAllModules();
	$moduleCount = mysql_num_rows($allModules);
	$tagLength = 100 / $moduleCount;
	$tagLength = $tagLength.'%';
	
	$tagLength = '33%';
	
	$getModuleId = $_GET['moduleId'];
	$line = mysql_fetch_array($allModules);
	$selectedModule = $line['id'];
	if($getModuleId){
		$selectedModule = $getModuleId;
	}
	//选出所有要显示的课程
	$courseDB = new CourseDB();
    $result = $courseDB->selectFutureCoursesNotSelectedByUserInModule($userId,$selectedModule);
	//提取当前模块下的已修学分和所需学分
	$creditDB = new CreditDB();
	$finishedCredit = mysql_fetch_array($creditDB->selectAllUserFinishedCreditsByModuleId($userId,$selectedModule))[0];
	$neededCredit = mysql_fetch_array($moduleDB->selectModuleById($selectedModule))['minCredit'];
	$creditWidth = $finishedCredit/$neededCredit*100;
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <script type="text/javascript" src="../../static/js/myjs.js"></script>
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
    <title>选课</title>
    <link rel="stylesheet" href="../../static/style/weui.css"/>
    <link rel="stylesheet" href="../../static/example/example.css"/>
    <link rel="stylesheet" href="../../static/style/myStyle.css"/>
    <link rel="stylesheet" href="../../static/style/progressBar.css"/>
</head> 
<body>
<div style="white-space:nowrap;">
<?php
	$i = 0;
	while($line){
	$class = 'weui_btn weui_btn_mini weui_btn_default';
	if($line['id'] == $selectedModule){
		$class = "weui_btn weui_btn_mini weui_btn_primary";
	}
	$i++;
?>	
	<a href="javascript:selectTag('<?php echo $line['id']?>');" class="<?php echo $class?>" style="width:<?php echo $tagLength?>;"><?php echo $line['name']?></a>
<?php 
	if($i % 3 == 0){
		echo "<br/>";
	}
	$line = mysql_fetch_array($allModules);}
?>
</div>
<p class="page_desc">当前模块已完成学分/所需学分
<div id="graphbox">
    <div class="graph"><span class="green" style="width: <?php echo $creditWidth;?>%;"><?php echo ($finishedCredit!=0?$finishedCredit:0).'/'.$neededCredit?></span></div>
</div>
<h1 class="page_title">选课</h1>
<table class='zebra' style="table-layout:fixed">
	<thead>
		<tr>
			<th style="width:18%">时间</th>
			<th style="width:19%">地点</th>
			<th style="width:32%">课程名</th>
			<th style="width:15%">人数</th>
			<th style="width:16%">&nbsp;</th>
		</tr>
	<thead>
<?php
	while($line = mysql_fetch_array($result)){	
		$selectedNumber = mysql_num_rows($courseDB->selectStudentsInCourse($line['id']));	
		$myDate = date("m-d", strtotime($line['datetime']));
        $myTime = date("H:i", strtotime($line['datetime']));
		$myLocation = $line['location'];
?>
    <tr>
        <td><?php echo $myDate.'<br/>'.$myTime;?></td>
		<td><?php echo $myLocation?></td>
        <td><?php echo $line['name']?></td>
        <td><?php echo $selectedNumber.'/'.$line['maxNumber']?></td>
 		<?php if($selectedNumber < $line['maxNumber']){?>
 		<td><a href="javascript:selectCourse('<?php echo $line['id']?>','<?php echo $userId?>','<?php echo $selectedModule?>');" class="weui_btn weui_btn_plain_default" style="padding-right :0px;padding-left :0px;">选课</a></td>
    	<?php }?>
    </tr>
<?php
	}
?>
	<tr><td>&nbsp;</td></tr>
</table>
<button type = "button" class="weui_btn weui_btn_default" onclick="clickmyschedule()">我的课程表</button>
</body>
<script>
    function clickmyschedule()
    {
        location.href="courseSchedule.php";
    }
    function selectCourse(courseId,userId,moduleId){
    	jsPost('Do/doElectCourse.php', {
		    'courseId': courseId,
		    'userId' : userId,
		    'moduleId':moduleId
		});
    }
    function selectTag(moduleId){
    	location.href = "electCourse.php?moduleId="+moduleId;
    }
</script>
</html>