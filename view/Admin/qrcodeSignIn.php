<?php
/*
 * 二维码功能用到的API http://goqr.me/api/
 */
$projectName = "GreenHorse";
$CourseDBurl = $_SERVER['DOCUMENT_ROOT'].$projectName."/database/CourseDB.php";
$QRCodeDBurl = $_SERVER['DOCUMENT_ROOT'].$projectName."/database/QRCode.php";
require_once('head.php');
require_once($CourseDBurl);
require_once("Utility.php");
require_once($QRCodeDBurl);
date_default_timezone_set('PRC');

$courseId = $_GET['courseId'];
$courseDB = new CourseDB();
$course = mysql_fetch_array($courseDB->selectCourseById($courseId));

$utility = new Utility();
$qrcodeKey = $utility->createPassword(10);

$qrcodeCon = new QRCode();
$qrcode = array();
$qrcode['courseId'] = $courseId;
$qrcode['qrcode'] = $qrcodeKey;
$qrcode['expiresIn'] = 60;
$qrcodeCon->insertQRCode($qrcode);

$date = strtotime(date("Y-m-d H:i:s")) + 10;
?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>二维码签到</title>
	<link rel="stylesheet" href="../../static/style/weui.css"/>
	<link rel="stylesheet" href="../../static/example/example.css"/>
	<link rel="stylesheet" href="../../static/style/myStyle.css"/>
</head>
<body>
	<h1 class = "page_title">二维码签到</h1>
	<h3 align='center'><?php echo $course['name']?></h3>
	<br/>
	<div align="center"><img src="https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=<?php echo $qrcodeKey?>"/></div>
	<h5 align='center'>*二维码有效时长 一分钟</h5>
</body>
</html>