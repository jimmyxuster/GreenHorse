<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>登录</title>
	<link rel="stylesheet" href="../../static/style/weui.css"/>
	<link rel="stylesheet" href="../../static/example/example.css"/>
	<link rel="stylesheet" href="../../static/style/myStyle.css"/>
</head>
<body>
<h1 class = "page_title">登录</h1>

<form method='post' action='Do/doLogin.php'>
<div class="weui_cells weui_cells_form">
	<div class="weui_cell">
		<div class="weui_cell_hd"><label class="weui_label">学工号</label></div>
		<div class="weui_cell_bd weui_cell_primary">
			<input class="weui_input" type="number" name = "id" pattern = "[0-9]*" placeholder="请输入学工号"/>
		</div>
	</div>
	<div class="weui_cell">
		<div class="weui_cell_hd"><label class="weui_label">密码</label></div>
		<div class="weui_cell_bd weui_cell_primary">
			<input class="weui_input" type="password" name = "pwd" placeholder="请输入密码"/>
		</div>
	</div>
</div>
	<input class="weui_btn weui_btn_default" style = "position: relative" type = "submit" value = "登录"/>
</form>
<h4 align='center'>默认密码：qingma</h4>
</body>
</html>