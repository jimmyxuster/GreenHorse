<?php
$projectName = "GreenHorse";
$classurl = $_SERVER['DOCUMENT_ROOT'].$projectName."/database/ClassDB.php";
$crediturl = $_SERVER['DOCUMENT_ROOT'].$projectName."/database/CreditDB.php";
$userurl = $_SERVER['DOCUMENT_ROOT'].$projectName."/database/UserDB.php";
$session_filter = $_SERVER['DOCUMENT_ROOT'].$projectName."/view/Admin/session_filter.php";
require_once($classurl);
require_once($crediturl);
require_once($userurl);
require_once($session_filter);
require_once('head.php');
header("Content-Type: text/html; charset=utf-8");	

	$classId = $_GET['classId'];
	if($classId == '' || $classId == null){
		$classId = 1;
	}
	$classDB = new ClassDB();
	$classes = $classDB->selectAllClasses();
	$creditDB = new CreditDB();
	$userCredits = $creditDB->selectUserCreditsByClassId($classId);
	$userDB= new UserDB();
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>学分管理</title>
    <link rel="stylesheet" href="../../static/js/jquery.min.js"/>
    <link rel="stylesheet" href="../../static/style/weui.css"/>
    <link rel="stylesheet" href="../../static/example/example.css"/>
    <link rel="stylesheet" href="../../static/style/myStyle.css"/>
</head>
<body align="center">
<h1 class = "page_title">学分</h1>

<?php
	while($line = mysql_fetch_array($classes)){
?>
        <a href='credit.php?classId=<?php echo $line['id']?>'><?php echo $line['name']?></a>
<?php
	}
?>
<table class = "zebra">
    <thead>
    <tr>
        <th>学号</th>
        <th>姓名</th>
        <th>已完成学分</th>
    </tr>
    </thead>
    <?php
    while($line = mysql_fetch_array($userCredits)){
    	$user = mysql_fetch_array($userDB->selectUserById($line['userId']));
    ?>
    <tr>
        <td><?php echo $line['userId']?></td>
        <td><?php echo $user['name']?></td>
        <td><?php echo $line['credit'] == 0 ? 0 : $line['credit']?></td>
    </tr>
    <?php 
    }?>
</table>
<br>

<button class="weui_btn weui_btn_default" style = "position: relative" type = "button" onclick="onTable('<?php echo $classId?>')">导出表格...</button>

<a href="#" id="toTop" style="display: block;"> <span id="toTopHover" style="opacity: 1;"> </span></a>
</body>
<script>
function onTable(classId){
	location.href='Do/creditTable.php?classId='+classId;
}
</script>
<script type="text/javascript">
 $(document).ready(function() {
  $().UItoTop({ easingType: 'easeOutQuart' });
 });
</script>
</html>