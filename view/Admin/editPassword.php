<?php
$projectName = "GreenHorse";
$Userurl = $_SERVER['DOCUMENT_ROOT'].$projectName."/model/User.php";
$session_filter = $_SERVER['DOCUMENT_ROOT'].$projectName."/view/Admin/session_filter.php";
require_once($Userurl);
require_once($session_filter);
require_once('head.php');
header("Content-Type: text/html; charset=utf-8");	

	session_start();
	$admin = new User();
	$admin = $_SESSION['admin'];
?>
<html>
<head>
	<title>修改密码</title>
	<link rel="stylesheet" href="../../static/style/weui.css"/>
	<link rel="stylesheet" href="../../static/example/example.css"/>
	<link rel="stylesheet" href="../../static/style/myStyle.css"/>
	<script type="text/javascript" src="../../static/js/myjs.js"></script>
</head>
<body>
<h1 class = "page_title">修改密码</h1>

	<div class="weui_cells weui_cells_form">
		<div class="weui_cell">
			<div class="weui_cell_hd"><label class="weui_label">用户名</label></div>
			<div class="weui_cell_bd weui_cell_primary">
				<?php echo $admin->name?>
			</div>
		</div>
		<div class="weui_cell">
			<div class="weui_cell_hd"><label class="weui_label">新密码</label></div>
			<div class="weui_cell_bd weui_cell_primary">
				<input class="weui_input" type="password" id = "pw1" placeholder="请输入新密码"/>
			</div>
		</div>
		<div class="weui_cell">
			<div class="weui_cell_hd"><label class="weui_label">确认密码</label></div>
			<div class="weui_cell_bd weui_cell_primary">
				<input class="weui_input" type="password" id = "pw2" placeholder="请再次输入新密码"/>
			</div>
		</div>
	</div>
			<button class="weui_btn weui_btn_default" style = "position: relative" onclick="onSubmit('<?php echo $admin->id?>')">提交</button>
</body>
<script>
	function onSubmit(id){
		var pw1 = document.getElementById('pw1').value;
		var pw2 = document.getElementById('pw2').value;
		if(pw1 != pw2){
			alert('两次的密码不相同！');
			return;
		}
		if(pw1.length<5 || pw1.length>20){
			alert("密码长度应不小于5位，不大于20位！");
			return;
		}
		jsPost('./Do/doEditPassword.php', {
            'password': pw1
	       });
	}
</script>
</html>
