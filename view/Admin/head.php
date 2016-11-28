<?php
$projectName = "GreenHorse";
$Userurl = $_SERVER['DOCUMENT_ROOT'].$projectName."/model/User.php";
$session_filter = $_SERVER['DOCUMENT_ROOT'].$projectName."/view/Admin/session_filter.php";
require_once($Userurl);
require_once($session_filter);
header("Content-Type: text/html; charset=utf-8");
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="../../static/style/weui.css"/>
    <link rel="stylesheet" href="../../static/example/example.css"/>
    <link rel="stylesheet" href="../../static/style/myStyle.css"/>
</head>
<table width="100%" >
	<tr>
		<td align="left"><a href="main.php"><img src="../../static/image/logo.png" height="60px" style="padding:10px"/></a></td>
		<td align="center" style="font-size:30px;color:">青马班在线学习平台-管理员后台</a>
		<td align="right" style="vertical-align:bottom;padding:10px;font-size:10px">博远INFINITE工作室</td>
	</tr>
</table>
</div>
<div class="bd">
    <div class="weui_grids">
        <a href="import.php" class="weui_grid">
            <div class="weui_grid_icon">
                <i class="icon icon_actionSheet"></i>
            </div>
            <p class="weui_grid_label">
                导入
            </p>
        </a>
        <a href="attendance_index.php" class="weui_grid">
            <div class="weui_grid_icon">
                <i class="icon icon_panel"></i>
            </div>
            <p class="weui_grid_label">
                考勤
            </p>
        </a>
        <a href="credit.php" class="weui_grid">
            <div class="weui_grid_icon">
                <i class="icon icon_progress"></i>
            </div>
            <p class="weui_grid_label">
                学分
            </p>
        </a>
        <a href="students.php" class="weui_grid">
            <div class="weui_grid_icon">
                <i class="icon icon_search_bar"></i>
            </div>
            <p class="weui_grid_label">
                学生
            </p>
        </a>
        <a href="selectCourse.php" class="weui_grid">
            <div class="weui_grid_icon">
                <i class="icon icon_article"></i>
            </div>
            <p class="weui_grid_label">
                选课
            </p>
        </a>
        <a href="rating.php" class="weui_grid">
            <div class="weui_grid_icon">
                <i class="icon icon_dialog"></i>
            </div>
            <p class="weui_grid_label">
                评价
            </p>
        </a>
        <?php if($admin->permission == 'superadmin'){?>
            <a href="manager.php" class="weui_grid">
                <div class="weui_grid_icon">
                    <i class="icon icon_msg"></i>
                </div>
                <p class="weui_grid_label">
                    管理员
                </p>
            </a>
        <?php }?>
    </div>
</div>

</html>