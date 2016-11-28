<?php
class Utility{
	public function http_request($url, $data = null)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        if (!empty($data)){
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            curl_setopt($curl, CURLOPT_HTTPHEADER, 
            array('Content-Type: application/json', 
				'Content-Length: ' . strlen($data)));
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        $output = curl_exec($curl);
        curl_close($curl);
        return $output;
    }
    public function printObj($object){
    	return $object;
    }
    
    function createPassword($length = 8)
	{
	    // 密码字符集，可任意添加你需要的字符  
		$chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$^*()_[]{}<>~`=,.;:?|';  
		$password = "";  
		for ( $i = 0; $i < $length; $i++ )  
		{  
			// 这里提供两种字符获取方式  
			// 第一种是使用 substr 截取$chars中的任意一位字符；  
			// 第二种是取字符数组 $chars 的任意元素  
			// $password .= substr($chars, mt_rand(0, strlen($chars) – 1), 1);  
			$password .= $chars[ mt_rand(0, strlen($chars) - 1) ];  
		}  
		return $password;  
	}
}

?>