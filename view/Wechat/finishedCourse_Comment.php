<?php
$projectName = "GreenHorse";
$CourseDBurl = $_SERVER['DOCUMENT_ROOT'].$projectName."/database/CourseDB.php";
$CommentDBurl = $_SERVER['DOCUMENT_ROOT'].$projectName."/database/CommentDB.php";
$sessionFilterUrl = $_SERVER['DOCUMENT_ROOT'].$projectName."/view/session_filter.php";
$Userurl = $_SERVER['DOCUMENT_ROOT'].$projectName."/model/User.php";
require_once($Userurl);
require($CourseDBurl);
require($CommentDBurl);
date_default_timezone_set('PRC');
/*
 * 检查session 只有通过正常方法通过过session_filter的用户才能看到当前页面
 */
require($sessionFilterUrl);
session_start();
$user = new User();
$user = $_SESSION['user'];
$userId = $user->id;
	
//$userId = 1;

$courseDB = new CourseDB();
$allCourses = $courseDB->selectAllUserPresentedCourses($userId);
$courses = array();
$commentDB = new CommentDB();
$allCommented = $commentDB->selectAllUserCommentedCourses($userId);
$commented = array();


?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
    <title>已结束课程</title>
    <link rel="stylesheet" href="../../static/style/weui.css"/>
    <link rel="stylesheet" href="../../static/example/example.css"/>
    <link rel="stylesheet" href="../../static/style/myStyle.css"/>
</head>
<body>
<h1 class="page_title">已结束课程</h1>
<table class = "zebra">
        <thead>
        <tr>
            <th>时间</th><th>课程名</th><th>状态</th><th>&nbsp;</th>
        </tr>
        <thead>
    <tr>
        <?php
        $i = 0;
        while($line = mysql_fetch_array($allCourses))
        {
            $courseId = $line['courseId'];
            $courseResult = $courseDB->selectCoursesInfoFromCourseId($courseId);
            $courses[$i] = mysql_fetch_array($courseResult);
            $courseName = $courses[$i]['name'];
            if(strtotime($courses[$i]['datetime']) <= time())
            {
        ?>
                <td><?php echo date("y-m-d H:i",strtotime($courses[$i]['datetime'])) ?></td>
                <td><?php echo $courses[$i]['name']?></td>
                <td>
                <?php
                    if($commentDB->isCommented($userId, $courseId))
                        echo "已评";
            else
            {
                ?>
                <a href="commentPage.php?courseId=<?php echo $courseId?>&courseName=<?php echo $courseName?>">评价</a>
            <?php
            }
            ?>
            </td>
    </tr>
    <?php

    }
    $i++;
    }
    ?>
    <tr><td>&nbsp;</td></tr>
</table>
</body>
</html>