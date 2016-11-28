<?php
$projectName = "GreenHorse";
$ClassDBurl = $_SERVER['DOCUMENT_ROOT'].$projectName."/database/ClassDB.php";
$errorUrl = 'http://'.$_SERVER['HTTP_HOST'].'/'.$projectName."/view/error.php";
require_once($ClassDBurl);

header("Content-Type: text/html; charset=utf-8");
date_default_timezone_set('PRC');

$id = $_GET['classId'];
//if(!$id)
//{
//    header("Location:".$errorUrl."?error_code=103");
//    exit;
//}

$classDB = new ClassDB();
$classDB->removeClass($id);
$classDB->deleteAllUsersInClass($id);
echo"<script>location.href='../removeClass.php';</script>";
?>