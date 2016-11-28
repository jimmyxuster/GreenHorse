<?php
header('Content-Type:application/vnd.ms-excel');
header('Content-Disposition:attachment;filename=学分统计表.xls');
header('Pragma:no-cache');
header('Expires:0');

$projectName = "GreenHorse";
$ClassDBurl = $_SERVER['DOCUMENT_ROOT'].$projectName."/database/ClassDB.php";
$CreditDBurl = $_SERVER['DOCUMENT_ROOT'].$projectName."/database/CreditDB.php";
$UserDBurl = $_SERVER['DOCUMENT_ROOT'].$projectName."/database/UserDB.php";
$errorUrl = 'http://'.$_SERVER['HTTP_HOST'].'/'.$projectName."/view/error.php";
$session_filter = $_SERVER['DOCUMENT_ROOT'].$projectName."/view/Admin/session_filter.php";
require_once($session_filter);
require_once($ClassDBurl);
require_once($CreditDBurl);
require_once($UserDBurl);

if(!$_GET['classId']){
	header("Location:".$errorUrl."?error_code=101");
	exit;
}
$classId = $_GET['classId'];
$classDB = new ClassDB();
$creditDB = new CreditDB();
$userDB = new UserDB();
$class = mysql_fetch_array($classDB->selectClassById($classId));
$userCredits = $creditDB->selectUserCreditsByClassId($classId);




$beforeTitle = array("班级",$class['name']);
$blank = array('','');
$title = array('学号','姓名','学分');
$data = array();
for($i=0; $userCredit = mysql_fetch_array($userCredits); $i++){
	$user = mysql_fetch_array($userDB->selectUserById($userCredit['userId']));
	if($user == null || $user['id'] == null){
		break;
	}
	$data[$i] = array($user['id'],$user['name'],$userCredit['credit'] == 0 ? 0 : $userCredit['credit']);
}
echo iconv('utf-8','gbk',implode("\t",$beforeTitle))."\n";
echo iconv('utf-8','gbk',implode("\t",$blank))."\n";
echo iconv('utf-8','gbk',implode("\t",$title))."\n";
foreach ($data as $value){
	echo iconv('utf-8','gbk',implode("\t",$value))."\n";
}