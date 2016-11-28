<?php
$projectName = "GreenHorse";
$database_basic = $_SERVER['DOCUMENT_ROOT'].$projectName."/database/database_basic.php";
require_once($database_basic);

class ClassDB
{
    public function selectAllClasses()
    {
        $text = "select * from class order by id";
        $sql = sprintf($text);
        $db = new database();
        $link = $db->start();
        $result = $db->execute_sql("select", $sql);
        mysql_close($link);
        return $result;
    }

	/*
	 * 根据classId选出所有某班级中的同学的信息
	 */
	public function selectUserInClassByClassId($classId){
		$text = "select * from userinclass LEFT OUTER JOIN user " .
				"on `user`.id = userinclass.userId where classId = %s";
        $sql = sprintf($text,$classId);
        $db = new database();
        $link = $db->start();
        $result = $db->execute_sql("select", $sql);
        mysql_close($link);
        return $result;
	}
	/*
	 * 插入一个class并返回新的class的自增id
	 */
    public function insertClass($name)
    {
        $text = "insert into class (name)
                 values ('%s')";
        $sql = sprintf($text, $name);
        $db = new database();
        $link = $db->start();
        $result = $db->execute_sql("insert", $sql);
        $id = mysql_insert_id($link);
        mysql_close($link);
        return $id;
    }
    /*
     * 选出没有班级归属的学生
     */
    public function selectStudentsNotInClass()
    {
        $text = "select * from user where id not in (select DISTINCT userId from userinclass)";
        $sql = sprintf($text);
        $db = new database();
        $link = $db->start();
        $result = $db->execute_sql("select", $sql);
        mysql_close($link);
        return $result;
    }
    
    public function insertUserInClass($userinclass){
    	$text = "insert into userinclass(userId,classId,position) " .
    			"values('%s', %s, '%s')";
        $sql = sprintf($text, $userinclass['userId'], $userinclass['classId'], $userinclass['position']);
        $db = new database();
        $link = $db->start();
        $result = $db->execute_sql("select", $sql);
        mysql_close($link);
        return $result;
    }
    
    public function selectUserNotInClass($userId, $classId){
        $text = "select * from userinclass where userId = '%s' and classId != %s";
        $sql = sprintf($text, $userId, $classId);
        $db = new database();
        $link = $db->start();
        $result = $db->execute_sql("select", $sql);
        mysql_close($link);
        return $result;
    }
    
    public function selectUserInClass($userId, $classId){
    	$text = "select * from userinclass where userId = '%s' and classId = %s";
        $sql = sprintf($text, $userId, $classId);
        $db = new database();
        $link = $db->start();
        $result = $db->execute_sql("select", $sql);
        mysql_close($link);
        return $result;
    }
    
    public function selectClassByName($name){
    	$text = "select * from class where name = '%s'";
        $sql = sprintf($text, $name);
        $db = new database();
        $link = $db->start();
        $result = $db->execute_sql("select", $sql);
        mysql_close($link);
        return $result;
    }
    
    public function selectClassById($id){
    	$text = "select * from class where id = %s";
        $sql = sprintf($text, $id);
        $db = new database();
        $link = $db->start();
        $result = $db->execute_sql("select", $sql);
        mysql_close($link);
        return $result;
    }
    
    public function deleteUserInClass($userId, $classId){
    	$text = "delete from userinclass where userId='%s' and classId = %s";
        $sql = sprintf($text, $userId, $classId);
        $db = new database();
        $link = $db->start();
        $result = $db->execute_sql("delete", $sql);
        mysql_close($link);
        return $result;
    }

    public function removeClass($classId){
        $text = "delete from class where id = %s";
        $sql = sprintf($text, $classId);
        $db = new database();
        $link = $db->start();
        $result = $db->execute_sql("delete", $sql);
        mysql_close($link);
        return $result;
    }

    public function deleteAllUsersInClass($classId){
        $text = "delete from userinclass where classId = %s";
        $sql = sprintf($text, $classId);
        $db = new database();
        $link = $db->start();
        $result = $db->execute_sql("delete", $sql);
        mysql_close($link);
        return $result;
    }
    
}
?>