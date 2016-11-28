<?php
$projectName = "GreenHorse";
$CourseDBurl = $_SERVER['DOCUMENT_ROOT'].$projectName."/database/CourseDB.php";
$QRCodeDBurl = $_SERVER['DOCUMENT_ROOT'].$projectName."/database/QRCode.php";
require_once($CourseDBurl);
require_once($QRCodeDBurl);
include_once "api/WXBizMsgCrypt.php";
require_once "Utility.php";

// 假设企业号在公众平台上设置的参数如下
$encodingAesKey = "oRdhCZItQ1GRu3NX3vmLayWsaMxFoGIowI3XkXsDj7h";
$token = "dxjBTBaqCEIag63";
$corpId = "wxebee63fa4a23266d";
$agentId = '29';

/*
------------使用示例二：对用户回复的消息解密---------------
用户回复消息或者点击事件响应时，企业会收到回调消息，此消息是经过公众平台加密之后的密文以post形式发送给企业，密文格式请参考官方文档
假设企业收到公众平台的回调消息如下：
POST /cgi-bin/wxpush? msg_signature=477715d11cdb4164915debcba66cb864d751f3e6&timestamp=1409659813&nonce=1372623149 HTTP/1.1
Host: qy.weixin.qq.com
Content-Length: 613
<xml>
<ToUserName><![CDATA[wx5823bf96d3bd56c7]]></ToUserName><Encrypt><![CDATA[RypEvHKD8QQKFhvQ6QleEB4J58tiPdvo+rtK1I9qca6aM/wvqnLSV5zEPeusUiX5L5X/0lWfrf0QADHHhGd3QczcdCUpj911L3vg3W/sYYvuJTs3TUUkSUXxaccAS0qhxchrRYt66wiSpGLYL42aM6A8dTT+6k4aSknmPj48kzJs8qLjvd4Xgpue06DOdnLxAUHzM6+kDZ+HMZfJYuR+LtwGc2hgf5gsijff0ekUNXZiqATP7PF5mZxZ3Izoun1s4zG4LUMnvw2r+KqCKIw+3IQH03v+BCA9nMELNqbSf6tiWSrXJB3LAVGUcallcrw8V2t9EL4EhzJWrQUax5wLVMNS0+rUPA3k22Ncx4XXZS9o0MBH27Bo6BpNelZpS+/uh9KsNlY6bHCmJU9p8g7m3fVKn28H3KDYA5Pl/T8Z1ptDAVe0lXdQ2YoyyH2uyPIGHBZZIs2pDBS8R07+qN+E7Q==]]></Encrypt>
<AgentID><![CDATA[218]]></AgentID>
</xml>

企业收到post请求之后应该
1.解析出url上的参数，包括消息体签名(msg_signature)，时间戳(timestamp)以及随机数字串(nonce)
2.验证消息体签名的正确性。
3.将post请求的数据进行xml解析，并将<Encrypt>标签的内容进行解密，解密出来的明文即是用户回复消息的明文，明文格式请参考官方文档
第2，3步可以用公众平台提供的库函数DecryptMsg来实现。
*/
$sReqMsgSig = $_GET['msg_signature'];
$sReqTimeStamp = $_GET['timestamp'];
$sReqNonce = $_GET['nonce'];
$sReqData = $GLOBALS['HTTP_RAW_POST_DATA'];
$sMsg = "";  // 解析之后的明文
$wxcpt = new WXBizMsgCrypt($token, $encodingAesKey, $corpId);
$errCode = $wxcpt->DecryptMsg($sReqMsgSig, $sReqTimeStamp, $sReqNonce, $sReqData, $sMsg);
if ($errCode == 0) {
	// 解密成功，sMsg即为xml格式的明文
	// TODO: 对明文的处理
	// For example:
	$xml = new DOMDocument();
	$xml->loadXML($sMsg);
	$msgType =  $xml->getElementsByTagName('MsgType')->item(0)->nodeValue;
	$fromUserName = $xml->getElementsByTagName('FromUserName')->item(0)->nodeValue;


	switch($msgType){
	case 'text':
		$textContent = $xml->getElementsByTagName('Content')->item(0)->nodeValue;
		$type = 'text';
		$content = '你好，欢迎来到青马时代~~~';
		break;
	case 'event':
		$event = $xml->getElementsByTagName('Event')->item(0)->nodeValue;
		$eventKey = $xml->getElementsByTagName('EventKey')->item(0)->nodeValue;
		if($event == "scancode_waitmsg" && $eventKey =="qrcode_signin"){
			$type = "text";
			$scanResult = $xml->getElementsByTagName('ScanResult')->item(0)->nodeValue;;
			$qrcodeCon = new QRCode();
			$qrcode = mysql_fetch_array($qrcodeCon->selectByQRCode($scanResult));
			if($qrcode){
				$from = $xml->getElementsByTagName('FromUserName')->item(0)->nodeValue;
				$courseDB = new CourseDB();
				$takecourse = mysql_fetch_array($courseDB->selectTakecourse($from,$qrcode['courseId']));
				if($takecourse){
					$takecourse['attendance'] = "出席";
					$courseDB->updateTakecourse($takecourse);
					$content = "update";
					$course = mysql_fetch_array($courseDB->selectCourseById($qrcode['courseId']));
					$content = "你签到了 ".$course['name'];
				}else{
					$content = "你没有选这门课！";
				}
			}else{
				$content = "二维码已过期";
			}
		}
//		else if($event == "subscribe")
//		{
//			$type = 'text';
//			$content = '感谢你关注青马时代！请在菜单中进行更多操作吧~♪(^∇^*)';
//		}
		break;
	}

	if($content != null && $content != ''){
		$sRespData = "<xml><ToUserName><![CDATA[mycreate]]></ToUserName><FromUserName><![CDATA[".
					$corpId.
					"]]></FromUserName><CreateTime>".
					time().
					"</CreateTime><MsgType><![CDATA[".
					$type."]]></MsgType><Content><![CDATA[".
					$content.
					"]]></Content><MsgId>1234567890123456</MsgId><AgentID>".
					$agentId.
					"</AgentID></xml>";
		$sEncryptMsg = ""; //xml格式的密文
		$errCode = $wxcpt->EncryptMsg($sRespData, $sReqTimeStamp, $sReqNonce, $sEncryptMsg);
		if ($errCode == 0) {
			echo $sEncryptMsg;
		} else {
			print("ERR: " . $errCode . "\n\n");
			// exit(-1);
		}
	}
} else {
	print("ERR: " . $errCode . "\n\n");
	//exit(-1);
}