<?php
$projectName = "GreenHorse";
$CourseDBurl = $_SERVER['DOCUMENT_ROOT'].$projectName."/database/CourseDB.php";
require($CourseDBurl);
require_once('head.php');
$courseDB = new CourseDB();
$allCourses = $courseDB->selectAllCourses();
?>
<html>
<head>
    <title>已存在课程</title>
    <link rel="stylesheet" href="../../static/style/weui.css"/>
    <link rel="stylesheet" href="../../static/example/example.css"/>
    <link rel="stylesheet" href="../../static/style/myStyle.css"/>
</head>
<body>
<a href = "importCourse.php">返回</a>

<h1 class = "page_title">已存在的课程&nbsp;<i class="icon icon_actionSheet" onclick='onImport()'></i></h1>
<table class='zebra'>
    <tr>
        <th width="30%">上课时间</th>
        <th width="20%">上课地点</th>
        <th>课程名</th>
    </tr>
    <?php
    $line = mysql_fetch_array($allCourses);
    while($line != null){
            ?>
            <tr>
                <td><?php echo $line['datetime']?></td>
                <td><?php echo $line['location']?></td>
                <td><?php echo $line['name']?></td>
            </tr>
            <?php
        $line = mysql_fetch_array($allCourses);
    }
    ?>
</table>
</body>
</html>
<script>
    function onImport(){
        location.href='importCourse.php';
    }
</script>