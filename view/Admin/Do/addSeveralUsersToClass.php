<?php
$projectName = "GreenHorse";
$ClassDBurl = $_SERVER['DOCUMENT_ROOT'].$projectName."/database/ClassDB.php";
$UserDBurl = $_SERVER['DOCUMENT_ROOT'].$projectName."/database/UserDB.php";
$errorUrl = 'http://'.$_SERVER['HTTP_HOST'].'/'.$projectName."/view/error.php";
$session_filter = $_SERVER['DOCUMENT_ROOT'].$projectName."/view/Admin/session_filter.php";
require_once($ClassDBurl);
require_once($UserDBurl);
header("Content-Type: text/html; charset=utf-8");

	$userId = $_GET['inputIds'];
	$classId = $_GET['classId'];
	
	if(!$_GET['classId']){
		header("Location:".$errorUrl."?error_code=101");
    	exit;
	}
	//用户输入逗号既有全角又有半角,返回重填
	if(strstr($userId,'，') != false && strstr($userId,',') != false){
		echo "<script>alert('逗号必须全部是半角或全角！');history.go(-1);</script>";
		exit;
	}
	//如果用户输入的逗号是半角的
	if(strstr($userId,',') != false){
		$userIds = explode(',',$userId);	
	}//如果用户输入的逗号是全角的
	else if(strstr($userId,'，') != false){
		$userIds = explode('，',$userId);
	}//如果用户没有输入逗号
	else{
		$userIds = array();
		$userIds[0] = $userId;
	}

	
	$classDB = new ClassDB();
	$userDB = new UserDB();
	$alreadyExist = '';
	$alreadyExistInOtherClass = ''; //用户在其他班级中
	$noUser = '';
	for($i=0; $i<count($userIds); $i++){
		$id = $userIds[$i];
		$user = mysql_fetch_array($userDB->selectUserById($id));
		if($user == null){//用户不在数据库中
			$noUser = $noUser.$id.',';
			break;
		}
		if(mysql_fetch_array($classDB->selectUserInClass($id, $classId))){
			$alreadyExist = $alreadyExist.$id.',';
		}
		if(mysql_fetch_array($classDB->selectUserNotInClass($id, $classId))){
			$alreadyExistInOtherClass = $alreadyExistInOtherClass.$id.',';
		}
		else{
			$userinclass = array();
			$userinclass['userId'] = $id;
			$userinclass['classId'] = $classId;
			$classDB->insertUserInClass($userinclass);	
		}
	}
	$show = "添加成功！";

	if($alreadyExistInOtherClass != ''){
		$show = $show.$alreadyExistInOtherClass.'已经在其他班级中，不再重复添加。';
	}

	if($alreadyExist != ''){
		$show = $show.$alreadyExist.'已经是班级成员，不再重复添加。';
	}

	if($noUser != ''){
		$show = $show.$noUser.'不存在在数据库中，未添加进班级。';
	}
	echo "<script>alert('".$show."');location.href='../importClassLeft.php?refresh=true&classId=$classId';</script>";	
?>
