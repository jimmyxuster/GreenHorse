<?php
$projectName = "GreenHorse";
$UserDBurl = $_SERVER['DOCUMENT_ROOT'].$projectName."/database/UserDB.php";
$errorUrl = 'http://'.$_SERVER['HTTP_HOST'].'/'.$projectName."/view/error.php";
require_once($UserDBurl);

header("Content-Type: text/html; charset=utf-8");
date_default_timezone_set('PRC');

$id = $_POST['id'];
$name = $_POST['name'];
$sex = $_POST['sex'];
$institute = $_POST['institute'];
$dormitory = $_POST['dormitory'];
$tel = $_POST['tel'];
$branch = $_POST['branch'];
$grade = $_POST['grade'];
$email = $_POST['email'];
$type = $_POST['type'];
$class = $_POST['class'];

if(!$id || !$name)
{
    header("Location:".$errorUrl."?error_code=104");
    exit;
}


$userDB = new UserDB();
if($userDB->userIdNotExists($id)) {
    $userDB->insertStudent($id, $name, $sex, $institute, $dormitory, $tel, $branch, $grade, $email, $type);
    $userDB->insertStudentClass($id, $class);
    echo "<script>alert('导入成功！'); location.href='../importStudent.php';</script>";
}
else
{
    $userDB->insertStudent($id, $name, $sex, $institute, $dormitory, $tel, $branch, $grade, $email, $type);
    $userDB->insertStudentClass($id, $class);
    echo "<script>alert('该学号已存在，学生信息已更新。导入成功！'); location.href='../importStudent.php';</script>";
}

?>