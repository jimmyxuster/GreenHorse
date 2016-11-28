<?php
$projectName = "GreenHorse";
$session_filter = $_SERVER['DOCUMENT_ROOT'].$projectName."/view/Admin/session_filter.php";
require_once($session_filter);
header("Content-Type: text/html; charset=utf-8");
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>导入班级</title>
</head>
<frameset rows="22%,78%" frameborder='0'>
<frame src='importClassUp.php'></frame>
<frameset cols="50%,50%" frameborder='0' id="mainweb" name="mainweb" width="100%" height="100%" frameborder="0"  onLoad="iFrameHeight()" frameborder='0'>
	<frame src='importClassLeft.php' id='left_frame' name='left_frame'/>
	<frame src='importClassRight.php' id='right_frame' name='right_frame'/>
</frameset>
</frameset>
<input type = "submit" value = "完成"/>
</html>