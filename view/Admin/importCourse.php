<?php
$projectName = "GreenHorse";
$CourseDBurl = $_SERVER['DOCUMENT_ROOT'].$projectName."/database/CourseDB.php";
$ModuleDBurl = $_SERVER['DOCUMENT_ROOT'].$projectName."/database/ModuleDB.php";
require($CourseDBurl);
require($ModuleDBurl);
require_once('head.php');
$courseDB = new CourseDB();
$moduleDB = new ModuleDB();
$allCourses = $courseDB->selectAllCourses();
$allModules = $moduleDB->selectAllModules();
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>导入课程</title>
    <link rel="stylesheet" href="../../static/style/weui.css"/>
    <link rel="stylesheet" href="../../static/example/example.css"/>
    <link rel="stylesheet" href="../../static/style/myStyle.css"/>
</head>
<body>
<h1 class = "page_title">导入课程</h1>
<p class="page_desc">
    <a href="existedCourses.php">点击查看已存在的课程</a>
    <br>带(*)的是必填项
</p>

<form action = "./Do/doImportCourse.php" method = "POST" name = "form" id = "form">
<div class="weui_cells weui_cells_form">
    <div class="weui_cell">
        <div class="weui_cell_hd"><label class="weui_label">课程名称(*)</label></div>
        <div class="weui_cell_bd weui_cell_primary">
            <input class="weui_input" type="text" name = "courseName"  placeholder="请输入课程名称"/>
        </div>
    </div>
    <div class="weui_cell">
        <div class="weui_cell_hd"><label class="weui_label">学分(*)</label></div>
        <div class="weui_cell_bd weui_cell_primary">
            <input class="weui_input" type="number" name = "credit" pattern = "[0-9]*" placeholder="请输入课程学分，不填则默认为0"/>
        </div>
    </div>
    <div class="weui_cell">
        <div class="weui_cell_hd"><label class="weui_label">上课时间(*)</label></div>
        <div class="weui_cell_bd weui_cell_primary">
            <select id="year" name="year">
                <option value="2016">2016</option>
                <option value="2017">2017</option>
            </select>年
            <select id="month" name="month">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>
            </select>月
            <select id="day" name="day">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>
                <option value="13">13</option>
                <option value="14">14</option>
                <option value="15">15</option>
                <option value="16">16</option>
                <option value="17">17</option>
                <option value="18">18</option>
                <option value="19">19</option>
                <option value="20">20</option>
                <option value="21">21</option>
                <option value="22">22</option>
                <option value="23">23</option>
                <option value="24">24</option>
                <option value="25">25</option>
                <option value="26">26</option>
                <option value="27">27</option>
                <option value="28">28</option>
                <option value="29">29</option>
                <option value="30">30</option>
                <option value="31">31</option>
            </select>日&nbsp;&nbsp;
            <select id="hour" name="hour">
                <option value="0">0</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>
                <option value="13">13</option>
                <option value="14">14</option>
                <option value="15">15</option>
                <option value="16">16</option>
                <option value="17">17</option>
                <option value="18">18</option>
                <option value="19">19</option>
                <option value="20">20</option>
                <option value="21">21</option>
                <option value="22">22</option>
                <option value="23">23</option>
            </select>时
            <select id="minute" name="minute">
                <option value="0">00</option>
                <option value="5">05</option>
                <option value="10">10</option>
                <option value="15">15</option>
                <option value="20">20</option>
                <option value="25">25</option>
                <option value="30">30</option>
                <option value="35">35</option>
                <option value="40">40</option>
                <option value="45">45</option>
                <option value="50">50</option>
                <option value="55">55</option>
            </select>分
        </div>
    </div>
    <div class="weui_cell">
        <div class="weui_cell_hd"><label class="weui_label">上课地点(*)</label></div>
        <div class="weui_cell_bd weui_cell_primary">
            <input class="weui_input" type="text" name = "location" placeholder="请输入上课地点"/>
        </div>
    </div>
    <div class="weui_cell">
        <div class="weui_cell_hd"><label class="weui_label">持续时间(分)</label></div>
        <div class="weui_cell_bd weui_cell_primary">
            <input class="weui_input" type="number" name = "duration" pattern = "[0-9]*" placeholder="请输入课程时间"/>
        </div>
    </div>
    <div class="weui_cell">
        <div class="weui_cell_hd"><label class="weui_label">最大人数</label></div>
        <div class="weui_cell_bd weui_cell_primary">
            <input class="weui_input" type="number" name = "maxNumber" pattern = "[0-9]*" placeholder="请输入课程最大人数"/>
        </div>
    </div>
    <div class="weui_cell">
        <div class="weui_cell_hd"><label class="weui_label">所属模块(*)</label></div>
        <div class="weui_cell_bd weui_cell_primary">
            <select name = "module" id = "module">
                <?php
                while($line2 = mysql_fetch_array($allModules))
                {
                    $moduleName = $line2['name'];
                    $moduleId = $line2['id'];
                    ?>
                    <option value = "<?php echo $moduleId; ?>"><?php echo $moduleName; ?></option>
                    <?php
                }
                ?>
            </select>
        </div>
    </div>
</div>
</form>


<!--<p>类别要求</p>-->
<!--    <input type = "checkbox" value = "团员" name = "restriction" />团员-->
<!--    <input type = "checkbox" value = "预备党员" name = "restriction" />预备党员-->
<!--    <input type = "checkbox" value = "党员" name = "restriction" />党员-->


<!--    <input type="hidden" id="restrictionhidden"/>-->

<button class="weui_btn weui_btn_default" style = "position: relative" type = "button" onclick = "mySubmit()">完成</button>
</body>
<script>
//    function getRestriction()
//    {
//        var restriction = new Array();
//        var restrictionarray = document.getElementsByName("restriction");
//        for(i = 0; i < restrictionarray.length; i++)
//        {
//            if(restrictionarray[i].checked)
//                restriction.push(restrictionarray[i]);
//        }
//        return restriction;
//    }

    function mySubmit()
    {
        if(document.getElementsByName("courseName")[0].value == "" ||
           document.getElementsByName("credit")[0].value == "" ||
           document.getElementsByName("year")[0].value == "" ||
           document.getElementsByName("month")[0].value == "" ||
           document.getElementsByName("day")[0].value == "" ||
           document.getElementsByName("hour")[0].value == "" ||
           document.getElementsByName("minute")[0].value == "" ||
           document.getElementsByName("location")[0].value == "" ||
           document.getElementsByName("module")[0].value == "")
        {
            alert('课程名称、学分、上课时间、上课地点、所属模块不能为空！');
            return;
        }
//        document.getElementById("restrictionhidden").value = getRestriction();
        document.form.submit();
    }
</script>
</html>