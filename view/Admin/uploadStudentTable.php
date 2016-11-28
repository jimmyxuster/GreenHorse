<?php
//header("Content-Type: text/html; charset=gbk");	
$projectName = "GreenHorse";
$PHPExcelUrl = $_SERVER['DOCUMENT_ROOT'].$projectName."/static/PHPExcel/Classes/PHPExcel.php";
$UserDBurl = $_SERVER['DOCUMENT_ROOT'].$projectName."/database/UserDB.php";
require_once($PHPExcelUrl); 
require_once($UserDBurl);
header("Content-Type: text/html; charset=utf-8");
if ($_FILES["file"]["error"] > 0){
	echo "<script>alert('上传失败！');history.go(-1);</script>";
	exit;
}else if(substr(strrchr($_FILES["file"]["name"], '.'), 1) != 'xlsx' && 
		substr(strrchr($_FILES["file"]["name"], '.'), 1) != 'xls' && 
		substr(strrchr($_FILES["file"]["name"], '.'), 1) != 'csv'){
	echo "<script>alert('文件后缀名必须是xlsx,xls或csv！');history.go(-1);</script>";
	exit;
}

$objReader = PHPExcel_IOFactory::createReaderForFile($_FILES["file"]["tmp_name"]); 
$PHPExcel = $objReader->load($_FILES["file"]["tmp_name"]);
$sheet = $PHPExcel->getSheet(0); // 读取第一个工作表从0读起
$highestRow = $sheet->getHighestRow(); // 取得总行数
$highestColumn = $sheet->getHighestColumn(); // 取得总列数
// 根据自己的数据表的大小修改
$arr = array(1=>'A',2=>'B',3=>'C',4=>'D',5=>'E',6=>'F',7=>'G',8=>'H',9=>'I',10=>'J',11=>'K',12=>'L',13=>'M', 14=>'N',15=>'O',16=>'P',17=>'Q',18=>'R',19=>'S',20=>'T',21=>'U',22=>'V',23=>'W',24=>'X',25=>'Y',26=>'Z');
 
 $title = array();
 $attributeIndex = array();
 $row = 1;
 for ($column = 0; $arr[$column] != 'T'; $column++) {
        $val = $sheet->getCellByColumnAndRow($column, $row)->getValue();
        $encode = mb_detect_encoding($val, array("ASCII","UTF-8","GB2312","GBK","BIG5")); 
		if ($encode != 'UTF-8'){ 
			$val = iconv($encode,"UTF-8//IGNORE",$val); 
		}
		if($val == '学号'){
			$attributeIndex['id'] = $column-1;
		}
		if($val == '姓名'){
			$attributeIndex['name'] = $column-1;
		}
		if($val == '性别'){
			$attributeIndex['sex'] = $column-1;
		}
		if($val == '院系'){
			$attributeIndex['institute'] = $column-1;
		}
		if($val == '宿舍'){
			$attributeIndex['dormitory'] = $column-1;
		}
		if($val == '手机号码'){
			$attributeIndex['tel'] = $column-1;
		}
		if($val == '所属支部'){
			$attributeIndex['branch'] = $column-1;
		}
		if($val == '年级'){
			$attributeIndex['grade'] = $column-1;
		}
		if($val == '邮箱'){
			$attributeIndex['email'] = $column-1;
		}
		if($val == '类别'){
			$attributeIndex['type'] = $column-1;
		}
		$title[$column-1] = $val;
} 
//	if($attributeIndex['id'] == null || $attributeIndex['name'] == null){
//		echo "<script>alert('学号和姓名是必填项！');history.go(-1);</script>";
//		exit;
//	}

/*
 * 读取文件中的内容
 * 每次读取一行，再在行中循环每列的数值
 */
for ($row = 2; $row <= $highestRow; $row++) {
    for ($column = 1; $arr[$column] != 'T'; $column++) {
        $val = $sheet->getCellByColumnAndRow($column, $row)->getValue();
        $encode = mb_detect_encoding($val, array("ASCII","UTF-8","GB2312","GBK","BIG5")); 
		if ($encode != 'UTF-8'){ 
			$val = iconv($encode,"UTF-8//IGNORE",$val); 
		} 
        $list[$row-2][] = $val;
    }
}
/*
 * 逐条插入数据库
 */
 $userDB = new UserDB();
 for($i = 0; $i<count($list); $i++){
 	$userDB->insertStudent($list[$i][$attributeIndex['id']], 
 		$list[$i][$attributeIndex['name']], 
 		$list[$i][$attributeIndex['sex']], 
 		$list[$i][$attributeIndex['institute']], 
 		$list[$i][$attributeIndex['dormitory']], 
 		$list[$i][$attributeIndex['tel']], 
 		$list[$i][$attributeIndex['branch']], 
 		$list[$i][$attributeIndex['grade']], 
 		$list[$i][$attributeIndex['email']], 
 		$list[$i][$attributeIndex['type']]);
 } 
 	echo "<script>alert('导入成功！共导入了".$i."条数据！');location.href='importStudent.php';</script>";
?>