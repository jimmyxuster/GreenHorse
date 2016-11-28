<?php
    $projectName = "GreenHorse";
    $session_filter = $_SERVER['DOCUMENT_ROOT'].$projectName."/view/Admin/session_filter.php";
    $ClassDBurl = $_SERVER['DOCUMENT_ROOT'].$projectName."/database/ClassDB.php";
    require_once($session_filter);
    require_once($ClassDBurl);
    require_once('head.php');
    header("Content-Type: text/html; charset=utf-8");
    $classDB = new ClassDB();
    $classes = $classDB->selectAllClasses();
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>移除班级</title>
    <link rel="stylesheet" href="../../static/style/weui.css"/>
    <link rel="stylesheet" href="../../static/example/example.css"/>
    <link rel="stylesheet" href="../../static/style/myStyle.css"/>
</head>
<body>
<a href = "main.php">返回</a>

<h1 class = "page_title">移除班级</h1>
<br>

<table class='zebra'>
    <tr>
        <th>班级名称</th>
        <th>操作</th>
    </tr>
    <?php while($class = mysql_fetch_array($classes)){
        $className = $class['name'];
        ?>
        <tr>
            <td><?php echo $className?></td>
            <td>
                <button class="weui_btn weui_btn_mini weui_btn_default" style = "position: relative" onclick="removeClass('<?php echo $class['id']?>')">删除班级</button>
            </td>
        </tr>
    <?php }?>
</table>
</body>
<script>
    function removeClass(classId){
        if (window.confirm("将要删除这个班级。确定吗?")) {
            location.href = 'do/doRemoveClass.php?classId=' + classId;
        }
    }
</script>