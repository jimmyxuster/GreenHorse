<?php
$projectName = "GreenHorse";
$ModuleDBurl = $_SERVER['DOCUMENT_ROOT'].$projectName."/database/ModuleDB.php";
$CreditDBurl = $_SERVER['DOCUMENT_ROOT'].$projectName."/database/CreditDB.php";
$Userurl = $_SERVER['DOCUMENT_ROOT'].$projectName."/model/User.php";
$sessionFilterUrl = $_SERVER['DOCUMENT_ROOT'].$projectName."/view/session_filter.php";
require($ModuleDBurl);
require($CreditDBurl);
require($Userurl);
/*
 * 检查session 只有通过正常方法通过过session_filter的用户才能看到当前页面
 */
 /*
require($sessionFilterUrl);
session_start();
$user = new User();
$user = $_SESSION['user'];
$userId = $user->id;
*/
date_default_timezone_set('PRC');
header("Content-Type: text/html; charset=utf-8");

$userId = 1;


$moduleDB = new ModuleDB();
$creditDB = new CreditDB();
$allModules = $moduleDB->selectAllModules();
$allCredits = mysql_fetch_array($creditDB->selectAllCreditsNeeded())[0];
$userCredits= mysql_fetch_array($creditDB->selectAllUserFinishedCredits($userId))[0];
?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
    <title>我的学分</title>
    <link rel="stylesheet" href="../../static/style/weui.css"/>
    <link rel="stylesheet" href="../../static/example/example.css"/>
</head>
<body>
<div class="hd">
	<p class="page_desc">最近成就</p>
    <h1 class="page_title">党性修养菜鸟</h1>
</div>
<p>已完成学分/所需学分： <?php echo ($userCredits!=0?$userCredits:0).'/'.$allCredits?></p>
<?php
	while($line = mysql_fetch_array($allModules)){
		$moduleName = $line['name'];
		$moduleId = $line['id'];
		$moduleMinCredit = $line['minCredit'];
		$userModuleCredits = mysql_fetch_array($creditDB->selectAllUserFinishedCreditsByModuleId($userId,$moduleId))[0];
?>
	<p><?php echo $moduleName?> 已完成学分/所需学分： <?php echo ($userModuleCredits!=0?$userModuleCredits:0).'/'.$moduleMinCredit?></p>
	<table>
	<tr>
		<td>课程</td>
		<td>学分</td>
		<td>备注</td>
	</tr>
	<?php
		$moduleCourses = $moduleDB->selectUserSelectedCoursesByModuleId($userId,$moduleId);
		while($line = mysql_fetch_array($moduleCourses)){
			$courseDatetime = strtotime($line['datetime']);
			$now = time();
			$ifFinished = "未上课";
			if($now > $courseDatetime){
				if($line['attendance'] == "出席")
					$ifFinished = "";
				else{
					$ifFinished = $line['attendance'];
				}
			}
	?>
		<tr>
			<td><?php echo $line['name']?></td>
			<td><?php echo $line['credit']?></td>
			<td><?php echo $ifFinished?></td>
		</tr>
	<?php
		}?>
	</table>
<?php
	}
?>
</body>
</html>
