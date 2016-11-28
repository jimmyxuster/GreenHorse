<?php
$projectName = "GreenHorse";
$ModuleDBurl = $_SERVER['DOCUMENT_ROOT'].$projectName."/database/ModuleDB.php";
$errorUrl = 'http://'.$_SERVER['HTTP_HOST'].'/'.$projectName."/view/error.php";
require_once($ModuleDBurl);

header("Content-Type: text/html; charset=utf-8");
date_default_timezone_set('PRC');

$minCredit = $_POST['minCredit'];
$moduleName = $_POST['moduleName'];

if(!$moduleName)
{
    header("Location:".$errorUrl."?error_code=105");
    exit;
}

$moduleDB = new ModuleDB();
if($moduleDB->moduleNotExists($moduleName)) {
    $moduleDB->insertModule($moduleName, $minCredit);
    echo "<script>alert('导入成功！'); location.href='../importModule.php';</script>";
}
else{
    echo "<script>alert('该模块名已存在，导入失败。'); location.href='../importModule.php';</script>";
}

?>