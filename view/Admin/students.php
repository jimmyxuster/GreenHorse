<?php
$projectName = "GreenHorse";
$UserDBurl = $_SERVER['DOCUMENT_ROOT'].$projectName."/database/UserDB.php";
require_once($UserDBurl);
require_once('head.php');

if($_GET['p']){
	$page = $_GET['p'];
}else{
	$page = 0;
}
$limit = 20;
$userDB = new UserDB();
$conditions = array();
$coma = "'";
if($_GET['searchId']){
	$conditions['id'] = $coma.$_GET['searchId'].$coma;
}
if($_GET['searchName']){
	$conditions['name'] = $coma.$_GET['searchName'].$coma;
}
if($_GET['searchClassName']){
	$conditions['className'] = $coma.$_GET['searchClassName'].$coma;
}
if($_GET['orderby']){
	$orderby = $_GET['orderby'];
}
$users = $userDB->selectUserByConditions($conditions,$orderby,$page*$limit,$limit);
if(mysql_num_rows($users) < $limit){
	$next = $page;
}else{
	$next = $page + 1;
}
if($page > 0){
	$previous = $page - 1;
}else{
	$previous = $page;
}
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <script type="text/javascript" src="../../static/js/myjs.js"></script>
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
    <title>学生</title>
    <link rel="stylesheet" href="../../static/style/weui.css"/>
    <link rel="stylesheet" href="../../static/example/example.css"/>
    <link rel="stylesheet" href="../../static/style/myStyle.css"/>
</head> 
<body>
<h1 class = "page_title">学生&nbsp;<i class="icon icon_actionSheet" onclick='onImport()'></i></h1>
		
<div align='center'>
<form action='students.php' method='get'>
	学号<input type='text' placeholder='学号' name='searchId'/>
	姓名<input type='text' placeholder='姓名' name='searchName'/>
	班级<input type='text' placeholder='班级' name='searchClassName' value='<?php echo $_GET['searchClassName']?>'/>
	<input class="weui_btn weui_btn_mini weui_btn_primary" style = "position: relative" type='submit' value='查找'/>
</form>
</div>
<table class='zebra'>
	<tr>
		<th width="8%"><a href='students.php?searchClassName=<?php echo $_GET['searchClassName']?>&orderby=id'>学号</a></th>
		<th width="9%"><a href='students.php?searchClassName=<?php echo $_GET['searchClassName']?>&orderby=name'>姓名</a></th>
		<th width="8%"><a href='students.php?searchClassName=<?php echo $_GET['searchClassName']?>&orderby=sex'>性别</a></th>
		<th width="12%"><a href='students.php?searchClassName=<?php echo $_GET['searchClassName']?>&orderby=classId'>班级</a></th>
		<th width="17%"><a href='students.php?searchClassName=<?php echo $_GET['searchClassName']?>&orderby=institute'>学院</a></th>
<!--		<th width="14%"><a href='students.php?searchClassName=--><?php //echo $_GET['searchClassName']?><!--&orderby=branch'>支部</a></th>-->
<!--		<th width="10%"><a href='students.php?searchClassName=--><?php //echo $_GET['searchClassName']?><!--&orderby=grade'>年级</a></th>-->
<!--		<th width="10%"><a href='students.php?searchClassName=--><?php //echo $_GET['searchClassName']?><!--&orderby=dormitory'>宿舍</a></th>-->
		<th><a href='students.php?searchClassName=<?php echo $_GET['searchClassName']?>&orderby=tel'>电话</a></th>
		<th><a href='students.php?searchClassName=<?php echo $_GET['searchClassName']?>&orderby=email'>邮件</a></th>
		<th width="8%"><a href='students.php?searchClassName=<?php echo $_GET['searchClassName']?>&orderby=credit'>学分</a></th>
		<th width="5%"></th>
	</tr>
<?php
	while($user = mysql_fetch_array($users)){
		if($user['permission']!="superadmin"){
?>
	<tr>
		<td ondblclick="onName('<?php echo $user['id']?>')" id="name<?php echo $user['id']?>"><?php echo $user['id']?></td>
		<td><?php echo $user['name']?></td>
		<td><?php echo $user['sex']?></td>
		<td><?php echo $user['className']?></td>
		<td><?php echo $user['institute']?></td>
<!--		<td>--><?php //echo $user['branch']?><!--</td>-->
<!--		<td>--><?php //echo $user['grade']?><!--</td>-->
<!--		<td>--><?php //echo $user['dormitory']?><!--</td>-->
		<td><?php echo $user['tel']?></td>
		<td><?php echo $user['email']?></td>
		<td><?php echo $user['credit']==0 ? '0' : $user['credit']?></td>
		<td>
			<button class="weui_btn weui_btn_mini weui_btn_default" style = "position: relative" type = "button"  onclick="removeStudent('<?php echo $user['id'] ?>')">×</button>
		</td>
	</tr>
<?php
	}
}
?>
</table>
<div align='center'>
	<a href='students.php?p=<?php echo $previous?>&searchClassName=<?php echo $_GET['searchClassName']?>&orderby=<?php echo $orderby?>'>上一页</a>
	<a href='students.php?p=<?php echo $next?>&searchClassName=<?php echo $_GET['searchClassName']?>&orderby=<?php echo $orderby?>'>下一页</a>
</div>
</body>
<script>
	
	function removeStudent(studentId)
	{
		if (window.confirm("将要把这个学生从数据库中删除。确定吗?"))
		{
			location.href = 'Do/doRemoveStudent.php?studentId='+studentId;
		}
	}
	function onName(userId){

	}
	function onImport(){
		location.href='importStudent.php';
	}
</script>
</html>
