<?php
$projectName = "GreenHorse";
$ModuleDBurl = $_SERVER['DOCUMENT_ROOT'].$projectName."/database/ModuleDB.php";
require($ModuleDBurl);
require_once('head.php');
$moduleDB = new ModuleDB();
$allModules = $moduleDB->selectAllModules();
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>导入模块</title>
    <link rel="stylesheet" href="../../static/style/weui.css"/>
    <link rel="stylesheet" href="../../static/example/example.css"/>
    <link rel="stylesheet" href="../../static/style/myStyle.css"/>
</head>
<body>
<h1 class = "page_title">导入模块</h1>
<p class="page_desc">
<?php
    echo "已存在的模块： ";
    while($line = mysql_fetch_array($allModules)) {
        $moduleName = $line['name'];
        echo $moduleName." ";
    }
?>
</p>
<DIV  style='width:80%;margin-left:auto;margin-right:auto;align:center' >
<form action = "./Do/doImportModule.php" method = "POST" name = "form" id = "form">
<div class="weui_cells weui_cells_form">
    <div class="weui_cell">
        <div class="weui_cell_hd"><label class="weui_label">模块名称</label></div>
        <div class="weui_cell_bd weui_cell_primary">
            <input class="weui_input" type="text" name = "moduleName" placeholder="请输入模块名称"/>
        </div>
    </div>
    <div class="weui_cell">
        <div class="weui_cell_hd"><label class="weui_label">要求学分</label></div>
        <div class="weui_cell_bd weui_cell_primary">
            <input class="weui_input" type="number" pattern = "[0-9]*" name = "minCredit" placeholder="请输入要求学分"/>
        </div>
    </div>
</div>
</form>
<DIV>
<button class="weui_btn weui_btn_default" style = "position: relative" type = "button" onclick = "mySubmit()">完成</button>
</body>
<script>
    function mySubmit()
    { 
        if(document.getElementsByName("moduleName")[0].value == "" ||
           document.getElementsByName("minCredit")[0].value == "")
        {
            alert('模块名称、要求学分不能为空！');
            return;
        }
        document.form.submit();
    }
</script>
</html>