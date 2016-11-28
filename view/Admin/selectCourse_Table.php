<?php
$projectName = "GreenHorse";
$courseDBurl = $_SERVER['DOCUMENT_ROOT'].$projectName."/database/CourseDB.php";
require_once($courseDBurl);
date_default_timezone_set('PRC');

header("Content-Type: text/html; charset=utf-8");
$courseId = $_GET['courseId'];
$courseDB = new CourseDB();
$studentsInCourse = $courseDB->selectStudentsInCourse($courseId);
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="../../static/style/weui.css"/>
    <link rel="stylesheet" href="../../static/example/example.css"/>
    <link rel="stylesheet" href="../../static/style/myStyle.css"/>
</head>
<body>

<table class = "zebra">
    <thead>
    <tr>
        <th>学号</th>
        <th>姓名</th>
        <th>操作</th>
    </tr>
    </thead>
    
        <?php
        while($line = mysql_fetch_array($studentsInCourse))
        {
            $studentId = $line['id'];
            $studentName = $line['name'];
        ?>
    <tr>
        <td><?php echo $studentId; ?></td>
        <td><?php echo $studentName; ?></td>
        <td>
            <button class="weui_btn weui_btn_mini weui_btn_default" style = "position: relative" type = "button"  onclick="removeStudent('<?php echo $studentId ?>', '<?php echo $courseId ?>')">移除</button>
        </td>
    </tr>
    <?php } ?>

</table>

</body>
<script>
    function removeStudent(studentId, courseId)
    {
        if (window.confirm("将要在此课程中移除这名学生。确定吗?")) {
            location.href = 'Do/doRemoveStudentFromCourse.php?studentId=' + studentId + '&courseId=' + courseId;
        }
    }
</script>
</html>