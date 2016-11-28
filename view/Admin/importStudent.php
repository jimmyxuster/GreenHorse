<?php
$projectName = "GreenHorse";
$ClassDBurl = $_SERVER['DOCUMENT_ROOT'].$projectName."/database/ClassDB.php";
require($ClassDBurl);
require_once('head.php');
$classDB = new ClassDB();
$allClasses = $classDB->selectAllClasses();
$line = mysql_fetch_array();
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>导入学生</title>
    <link rel="stylesheet" href="../../static/style/weui.css"/>
    <link rel="stylesheet" href="../../static/example/example.css"/>
    <link rel="stylesheet" href="../../static/style/myStyle.css"/>
</head>
<body>
<h1 class = "page_title">导入学生</h1>
<p class="page_desc">带(*)的是必填项</p>

<form action = "./Do/doImportStudent.php" method = "POST" name = "form" id = "form">
<div class="weui_cells weui_cells_form">
    <div class="weui_cell">
        <div class="weui_cell_hd"><label class="weui_label">学号(*)</label></div>
        <div class="weui_cell_bd weui_cell_primary">
            <input class="weui_input" type="number" name = "id" pattern = "[0-9]*" placeholder="请输入学生学号"/>
        </div>
    </div>
    <div class="weui_cell">
        <div class="weui_cell_hd"><label class="weui_label">姓名(*)</label></div>
        <div class="weui_cell_bd weui_cell_primary">
            <input class="weui_input" type="text" name = "name" placeholder="请输入学生姓名"/>
        </div>
    </div>
    <div class="weui_cell">
        <div class="weui_cell_hd"><label class="weui_label">性别</label></div>
        <div class="weui_cell_bd weui_cell_primary">
            <input type="radio" value = "男" name = "sex"/>男
            <input type="radio" value = "女" name = "sex"/>女
        </div>
    </div>
    <div class="weui_cell">
        <div class="weui_cell_hd"><label class="weui_label">学院</label></div>
        <div class="weui_cell_bd weui_cell_primary">
            <input class="weui_input" type="text" name = "institute" placeholder="请输入学生所在学院"/>
        </div>
    </div>
    <div class="weui_cell">
        <div class="weui_cell_hd"><label class="weui_label">宿舍</label></div>
        <div class="weui_cell_bd weui_cell_primary">
            <input class="weui_input" type="text" name = "dormitory" placeholder="请输入学生所在宿舍"/>
        </div>
    </div>
    <div class="weui_cell">
        <div class="weui_cell_hd"><label class="weui_label">电话</label></div>
        <div class="weui_cell_bd weui_cell_primary">
            <input class="weui_input" type="number" name = "tel" pattern = "[0-9]*" placeholder="请输入学生电话号码"/>
        </div>
    </div>
    <div class="weui_cell">
        <div class="weui_cell_hd"><label class="weui_label">支部</label></div>
        <div class="weui_cell_bd weui_cell_primary">
            <input class="weui_input" type="text" name = "branch" placeholder="请输入学生所在支部"/>
        </div>
    </div>
    <div class="weui_cell">
        <div class="weui_cell_hd"><label class="weui_label">年级</label></div>
        <div class="weui_cell_bd weui_cell_primary">
            <input class="weui_input" type="text" name = "grade" placeholder="请输入学生年级"/>
        </div>
    </div>
    <div class="weui_cell">
        <div class="weui_cell_hd"><label class="weui_label">邮箱</label></div>
        <div class="weui_cell_bd weui_cell_primary">
            <input class="weui_input" type="text" name = "email" placeholder="请输入学生邮箱"/>
        </div>
    </div>
    <div class="weui_cell">
        <div class="weui_cell_hd"><label class="weui_label">类别</label></div>
        <div class="weui_cell_bd weui_cell_primary">
            <input type = "radio" value = "团员" name = "type" />团员
            <input type = "radio" value = "预备党员" name = "type" />预备党员
            <input type = "radio" value = "党员" name = "type" />党员
        </div>
    </div>
    <div class="weui_cell">
        <div class="weui_cell_hd"><label class="weui_label">班级</label></div>
        <select id = "class" name = "class">
            <?php
            while($line = mysql_fetch_array($allClasses))
            {
                $className = $line['name'];
                $classId = $line['id'];
                ?>
                <option value = "<?php echo $classId; ?>"><?php echo $className; ?></option>
                <?php
            }
            ?>
        </select>
    </div>
</div>
    <input type="hidden" id="sexhidden"/>
    <input type="hidden" id="typehidden"/>
</form>

<button class="weui_btn weui_btn_default" style = "position: relative" type = "button" onclick = "onTable()">通过表格导入...</button>

<button class="weui_btn weui_btn_default" style = "position: relative" type = "button" onclick = "mySubmit()">完成</button>
</body>
<script>
	function onTable(){
		location.href='importStudentTable.php';
	}

    function getSex()
    {
        var sex = 0;
        var sexarray = document.getElementsByName("sex");
        for(i = 0; i < sexarray.length; i++)
        {
            if(sexarray[i].checked)
                sex = sexarray[i];
        }
        return sex;
    }

    function getType()
    {
        var type = 0;
        var typearray = document.getElementsByName("type");
        for(i = 0; i < typearray.length; i++)
        {
            if(typearray[i].checked)
                type = typearray[i];
        }
        return type;
    }

    function mySubmit()
    {
        if(document.getElementsByName("id")[0].value == "" || document.getElementsByName("name")[0].value == "")
        {
            alert('学号、姓名不能为空！');
            return;
        }
        document.getElementById("sexhidden").value = getSex();
        document.getElementById("typehidden").value = getType();
        document.form.submit();
    }

</script>
</html>