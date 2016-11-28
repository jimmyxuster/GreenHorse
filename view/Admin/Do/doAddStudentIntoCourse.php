<?php
$projectName = "GreenHorse";
$TakeCourseDBurl = $_SERVER['DOCUMENT_ROOT']. $projectName."/database/TakeCourseDB.php";
$UserDBurl = $_SERVER['DOCUMENT_ROOT']. $projectName."/database/UserDB.php";
$errorUrl = 'http://'.$_SERVER['HTTP_HOST'].'/'. $projectName."/view/error.php";
require_once($TakeCourseDBurl);
require_once($UserDBurl);

header("Content-Type: text/html; charset=utf-8");

$studentId = $_POST['studentId'];
$courseId = $_POST['courseId'];
$takecourseDB = new TakeCourseDB();
$userDB = new UserDB();

if(!$studentId || !$courseId){
    header("Location:".$errorUrl."?error_code=108");
    exit;
}


if($userDB->userNotExists($studentId))
    echo "<script>alert('添加失败，输入的学号在数据库中不存在。');location.href='../selectCourse.php';</script>";
else if($takecourseDB->studentAlreadyInCourse($studentId, $courseId))
{
    echo "<script>alert('添加失败，输入的学号已经选了这门课。');location.href='../selectCourse.php';</script>";
}
else
{
    $takecourseDB->addCourseForStudent($studentId, $courseId);
    echo "<script>alert('添加成功');location.href='../selectCourse.php';</script>";
}
?>
