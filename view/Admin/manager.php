<?php
$projectName = "GreenHorse";
$UserDBurl = $_SERVER['DOCUMENT_ROOT'].$projectName."/database/UserDB.php";
require_once('head.php');
require_once($UserDBurl);
$userDB = new UserDB();
$allAdmins = $userDB->selectAdmin();
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>管理员管理</title>
    <link rel="stylesheet" href="../../static/style/weui.css"/>
    <link rel="stylesheet" href="../../static/example/example.css"/>
    <link rel="stylesheet" href="../../static/style/myStyle.css"/>
    <script type="text/javascript" src="../../static/js/myjs.js"></script>
</head>
<body>
<h1 class = "page_title">管理员</h1>

<p>普通管理员：</p>
<table class = "zebra">
    <thead>
    <tr>
        <th>学号</th>
        <th>姓名</th>
        <th>操作</th>
    </tr>
    </thead>
    <tr>
        <?php
        while($line = mysql_fetch_array($allAdmins))
        {
            $adminId = $line['id'];
            $adminName = $line['name'];
        ?>
        <tr>
            <td><?php echo $adminId; ?></td>
            <td><?php echo $adminName; ?></td>
            <td>
                <button class="weui_btn weui_btn_mini weui_btn_default" style = "position: relative" type = "button"  onclick="removeAdmin('<?php echo $adminId?>', '<?php echo $adminName?>')">移除</button>
            </td>
        </tr>
        <?php } ?>
</table>
<br>

<button class="weui_btn weui_btn_default" style = "position: relative" type = "button" onclick="newAdmin()">添加管理员</button>
<br>
<script>
    function removeAdmin(id, name) {
        if (window.confirm("将要取消此人的管理员权限。确定吗?")) {
            jsPost('./Do/doRemoveAdmin.php', {
                'id': id,
                'name': name
            });
        }
    }
    function newAdmin(){
	    var id = prompt("请输入新管理员的学/工号:","");
		if (id != null){
			jsPost('./Do/doNewAdmin.php', {
            'adminId': id
        });
		}else{
			
		}
    }
</script>
</body>
</html>