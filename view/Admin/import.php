<?php
	require_once('head.php');
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>导入</title>
    <link rel="stylesheet" href="../../static/style/weui.css"/>
    <link rel="stylesheet" href="../../static/example/example.css"/>
    <link rel="stylesheet" href="../../static/style/myStyle.css"/>
</head>
<body>
<h1 class = "page_title">导入</h1>
<br><br><br>
<div class="bd">
    <div class="weui_grids">
        <a href="importModule.php" class="weui_grid">
            <div class="weui_grid_icon">
                <i class="icon icon_button"></i>
            </div>
            <p class="weui_grid_label">
                模块
            </p>
        </a>
        <a href="importCourse.php" class="weui_grid">
            <div class="weui_grid_icon">
                <i class="icon icon_cell"></i>
            </div>
            <p class="weui_grid_label">
                课程
            </p>
        </a>
        <a href="importClass.php" class="weui_grid">
            <div class="weui_grid_icon">
                <i class="icon icon_tab"></i>
            </div>
            <p class="weui_grid_label">
                班级
            </p>
        </a>
        <a href="importStudent.php" class="weui_grid">
            <div class="weui_grid_icon">
                <i class="icon icon_search_bar"></i>
            </div>
            <p class="weui_grid_label">
                学生
            </p>
        </a>
    </div>
</div>
</body>
</html>