<?php
/*
 * 当session中没有user信息时，说明用户在一段时间中第一次登陆了系统，则检查用户是否存在于数据库中。
 * 如果用户存在，将其存入session。
 * 如果用户不存在，转入error页面。
 */
$projectName = "GreenHorse";
$userURL = $_SERVER['DOCUMENT_ROOT'].$projectName."/model/User.php";
require_once($userURL);
require_once('weixin.class.php');
$url = $_GET['url'];

$weixin = new class_weixin();

echo "user_filter";

if (!isset($_GET["code"])){	
	$redirect_url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	$jumpurl = $weixin->oauth2_authorize($redirect_url, "snsapi_base","0");	
	Header("Location: $jumpurl");
}else{
	$access_token_oauth2 = $weixin->oauth2_access_token($_GET["code"]);
	$userId = $access_token_oauth2['UserId'];
	$openId = $access_token_oauth2['OpenId'];
	$deviceId = $access_token_oauth2['DeviceId'];
}
	if($userId){//用户绑定了企业号
		$user = new User($userId);
		if($user->id){//数据库中有该userId的记录
			session_start();
			$_SESSION['user'] = $user;
			header("Location:".$url);
		}else{//数据库中没有该userId的记录
			echo 'user     ';
			var_dump($user);
			echo "no user id ".$userId;
			//header("Location:error.php?error_code=100");
		}
	}else{//用户没绑定企业号
		echo 'not bounded';
		//header("Location:error.php?error_code= 100");
	}
