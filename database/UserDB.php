<?php
$projectName = "GreenHorse";
$database_basic = $_SERVER['DOCUMENT_ROOT'].$projectName."/database/database_basic.php";
require_once($database_basic);
class UserDB{
	public function selectUserById($id){
		$text = "select * from user where id = '%s'";
       	$sql = sprintf($text, $id);
   		$db = new database();
       	$link = $db->start();
       	$result = $db->execute_sql("select", $sql);
       	mysql_close($link);
       	return $result;
	}

	public function selectAdmin()
	{
		$text = "select * from user where permission = 'admin' order by id";
		$sql = sprintf($text);
		$db = new database();
		$link = $db->start();
		$result = $db->execute_sql("select", $sql);
		mysql_close($link);
		return $result;
	}
	
	public function selectIndividual($id, $name)
	{
		$text = "select * from user where id = '%s' and name = '%s'";
		$sql = sprintf($text, $id, $name);
		$db = new database();
		$link = $db->start();
		$result = $db->execute_sql("select", $sql);
		mysql_close($link);
		return $result;
	}

	public function updateAdmin($permission, $id, $name)
	{
		$text = "update user set permission = '%s' where id = '%s' and name = '%s'";
		$sql = sprintf($text, $permission, $id, $name);
		$db = new database();
		$link = $db->start();
		$result = $db->execute_sql("update", $sql);
		mysql_close($link);
		return $result;
	}

	public function insertStudent($id, $name, $sex, $institute, $dormitory, $tel, $branch, $grade, $email, $type)
	{
		$text = "insert into user (id, name, sex, institute, dormitory, tel, branch, grade, email, type)
                 values ('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s') on duplicate key update
                 name = '%s', sex = '%s', institute = '%s', dormitory = '%s', tel = '%s', branch = '%s', grade = '%s', email = '%s', type = '%s'";
		$sql = sprintf($text, $id, $name, $sex, $institute, $dormitory, $tel, $branch, $grade, $email, $type, $name, $sex, $institute, $dormitory, $tel, $branch, $grade, $email, $type);
		$db = new database();
		$link = $db->start();
		$result = $db->execute_sql("insert", $sql);
		mysql_close($link);
		return $result;
	}
	
	public function insertStudentClass($id, $class)
	{
		$text = "insert into userinclass (userId, classId)
                 values ('%s', '%s')";
		$sql = sprintf($text, $id, $class);
		$db = new database();
		$link = $db->start();
		$result = $db->execute_sql("insert", $sql);
		mysql_close($link);
		return $result;
	}
	/*
	 * update用户的权限和密码
	 */
	public function updateUserPermission($permission, $id, $password)
	{
		$text = "update user set permission = '%s', password = '%s' where id = '%s'";
		$sql = sprintf($text, $permission,$password, $id);
		$db = new database();
		$link = $db->start();
		$result = $db->execute_sql("update", $sql);
		mysql_close($link);
		return $result;
	}
	
	/*
	 * 自定义用户的条件的搜索
	 */
	public function selectUserByConditions($conditions = null,$orderby=null, $start=0, $length=999){
		$text = "select * from userWithClass ";
		if($conditions != null){
			if(count($conditions) > 0){
				$text = $text . ' where ';
			}
		}
		$i = 0;
		foreach ($conditions as $key => $value) {
	    	if($i != 0){
	    		$text = $text.' and ';
	    	}
	    	$text = $text.' '.$key.' = '.$value;
	    	$i++;
		}
		if($orderby != null && $orderby != ''){
			$text = $text.' order by '.$orderby.' ';
		}
		$text = $text.' limit '.$start.','.$length;
		$db = new database();
		$link = $db->start();
		$result = $db->execute_sql("select", $text);
		mysql_close($link);
		return $result;
	}

	public function userNotExists($id)
	{
		$text = "select * from user where id = '%s'";
		$sql = sprintf($text, $id);
		$db = new database();
		$link = $db->start();
		$result = $db->execute_sql("select", $sql);
		$array = mysql_fetch_array($result);
		mysql_close($link);
		return ($array == null);
	}

	public function removeStudent($studentId)
	{
		$text = "delete from user where id = '%s'";
		$sql = sprintf($text, $studentId);
		$db = new database();
		$link = $db->start();
		$result = $db->execute_sql("delete", $sql);
		mysql_close($link);
		return $result;
	}

	public function userIdNotExists($id)
	{
		$text = "select * from user where id = %s";
		$sql = sprintf($text, $id);
		$db = new database();
		$link = $db->start();
		$result = $db->execute_sql("select", $sql);
		$array = mysql_fetch_array($result);
		mysql_close($link);
		return ($array == null);
	}
}
?>
