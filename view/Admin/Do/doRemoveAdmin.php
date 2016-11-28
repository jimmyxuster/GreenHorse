<?php
$projectName = "GreenHorse";
$UserDBurl = $_SERVER['DOCUMENT_ROOT'].$projectName."/database/UserDB.php";
$errorUrl = 'http://'.$_SERVER['HTTP_HOST'].'/'.$projectName."/view/error.php";
require_once($UserDBurl);

header("Content-Type: text/html; charset=utf-8");
date_default_timezone_set('PRC');

$id = $_POST['id'];
$name = $_POST['name'];
if(!$id || !$name)
{
    header("Location:".$errorUrl."?error_code=103");
    exit;
}

$userDB = new UserDB();
$userDB->updateAdmin(null, $id, $name);
echo"<script>location.href='../manager.php';</script>";
?>