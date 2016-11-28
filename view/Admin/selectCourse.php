<?php
$projectName = "GreenHorse";
$CourseDBurl = $_SERVER['DOCUMENT_ROOT']. $projectName."/database/CourseDB.php";
$TakeCourseDBurl = $_SERVER['DOCUMENT_ROOT']. $projectName."/database/TakeCourseDB.php";
require($CourseDBurl);
require($TakeCourseDBurl);

$courseDB = new CourseDB();
$takecourseDB = new TakeCourseDB();
$allFutureCourses = $courseDB->selectAllFutureCourses();
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <title>选课管理</title>
    <link rel="stylesheet" href="../../static/style/weui.css"/>
    <link rel="stylesheet" href="../../static/example/example.css"/>
    <link rel="stylesheet" href="../../static/style/myStyle.css"/>
    <script type="text/javascript" src="../../static/js/myjs.js"></script>
</head>
<body>
<a href = "main.php">返回</a>

<h1 class = "page_title">选课</h1>
<br>
<center>
<?php
while($line = mysql_fetch_array($allFutureCourses))
{
    $courseName = $line['name'];
    $courseId = $line['id'];
    ?>
    <input type = "radio" onclick="clickTable('<?php echo $courseId; ?>')" value = "<?php echo $courseId; ?>" name = "className" /><?php echo $courseName; ?>
    <?php
    }
?>
<br><br>
<iframe id = "frame" name = "frame" src = "selectCourse_Table.php" frameborder = "0"  width = "400px" height = "300px"></iframe>

    <br>学号
<input type = "text" name = "studentId" />
<input type = "hidden" name = "courseId" value = "<?php echo $courseId; ?>"/>


<button class="weui_btn weui_btn_mini weui_btn_primary" style = "position: relative" type = "button" onclick = "mySubmit('<?php echo $studentId; ?>', '<?php echo $courseId; ?>')">添加学生
</button>

</center>
<br>
</body>
<script>
    var currentCourseId;
    function clickTable(courseId)
    {
        currentCourseId = courseId;
        window.frame.location.href = 'selectCourse_Table.php?courseId='+courseId;
    }

    function getCourseId()
    {
        var courseId = 0;
        currentCourseId = document.getElementsByName("courseId")[0]().value;
        return currentCourseId;
    }

    function mySubmit()    {
        if(document.getElementsByName("studentId")[0].value == "")
        {
            alert('请输入学生学号再添加！');
            return;
        }
        jsPost('./Do/doAddStudentIntoCourse.php', {
            'studentId' : document.getElementsByName("studentId")[0].value,
            'courseId' : currentCourseId
        });
    }
</script>
</html>