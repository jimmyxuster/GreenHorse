<?php
$projectName = "GreenHorse";
$ClassDBurl = $_SERVER['DOCUMENT_ROOT'].$projectName."/database/ClassDB.php";
$errorUrl = 'http://'.$_SERVER['HTTP_HOST'].'/'.$projectName."/view/error.php";
require_once($ClassDBurl);

header("Content-Type: text/html; charset=utf-8");
date_default_timezone_set('PRC');

$className = $_GET['className'];


if(!$className)
{
    header("Location:".$errorUrl."?error_code=106");
    exit;
}

$classDB = new ClassDB();
$class = mysql_fetch_array($classDB->selectClassByName($className));
if($class != null){
	header("Location:../importClassUp.php?show=查询成功&classId=".$class['id']."&className=".$className);
	exit;
}
$id = $classDB->insertClass($className);
header("Location:../importClassUp.php?show=添加成功&classId=".$id."&className=".$className);
?>