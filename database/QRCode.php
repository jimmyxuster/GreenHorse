<?php
date_default_timezone_set('PRC');

	class QRCode{
		function __construct(){
			//删除过期二维码
			$sql = "select * from qrcode";
	        $db = new database();
	        $link = $db->start();
	        $result = $db->execute_sql("select", $sql);
	        mysql_close($link);
	        while($line = mysql_fetch_array($result)){
	        	$expireTime = (int)($line['createTime']) + $line['expiresIn'];
	        	if($expireTime < time()){
	        		$this->deleteByQRCode($line['qrcode']);
	        	}
	        }
	        
	        return $result;
		}
		
		public function deleteByQRCode($qrcode){
			$text = "delete from qrcode where qrcode = '%s'";
	        $sql = sprintf($text, $qrcode);
	        $db = new database();
	        $link = $db->start();
	        $result = $db->execute_sql("delete", $sql);
	        mysql_close($link);
	        return $result;
		}
		
		public function insertQRCode($qrcode){
			$text = "insert into qrcode (courseId, qrcode,createTime, expiresIn)
                 values (%s,'%s','%s',%s)";
	        $sql = sprintf($text, $qrcode['courseId'], $qrcode['qrcode'],
	        	time(), $qrcode['expiresIn']);
	        $db = new database();
	        $link = $db->start();
	        $result = $db->execute_sql("insert", $sql);
	        mysql_close($link);
	        return $result;
		}
		//按照qrcode选出还没有过期的二维码记录
		public function selectByQRCode($qrcode){
			$text = "select * from qrcode where qrcode= '%s'";
	        $sql = sprintf($text,$qrcode);
	        $db = new database();
	        $link = $db->start();
	        $result = $db->execute_sql("select", $sql);
	        mysql_close($link);
	        return $result;
		}
	}
?>