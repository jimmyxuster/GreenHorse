<?php
$projectName = "GreenHorse";
$database_basic = $_SERVER['DOCUMENT_ROOT'].$projectName."/database/database_basic.php";
require_once($database_basic);


class ModuleDB{
	public function selectAllModules(){
		$text = "select * from module";
		$sql = sprintf($text);
		$db = new database();
		$link = $db->start();
		$result = $db->execute_sql("select", $sql);
		mysql_close($link);
		return $result;
	}
	public function selectModuleById($id){
		$text = "select * from module where id = %s";
		$sql = sprintf($text, $id);
		$db = new database();
		$link = $db->start();
		$result = $db->execute_sql("select", $sql);
		mysql_close($link);
		return $result;
	}
	/**
	 * 选择某模块下的所有课程信息
	 */
	public function selectCoursesByModuleId($moduleId){
		$text = "select * from course where moduleId = %s";
		$sql = sprintf($text, $moduleId);
		$db = new database();
		$link = $db->start();
		$result = $db->execute_sql("select", $sql);
		mysql_close($link);
		return $result;
	}
	/**
	 * 选择某用户选择的某模块下的所有课程信息
	 */
	public function selectUserSelectedCoursesByModuleId($userId,$moduleId){
		$text = "select course.*,takecourse.attendance from takecourse left outer join course 
				on course.id = takecourse.courseId 
				where takecourse.studentId = '%s' and course.moduleId = %s";
		$sql = sprintf($text, $userId, $moduleId);
		$db = new database();
		$link = $db->start();
		$result = $db->execute_sql("select", $sql);
		mysql_close($link);
		return $result;
	}

	public function insertModule($name, $minCredit)
	{
		$text = "insert into module (name, minCredit)
                 values ('%s', %s)";
		$sql = sprintf($text, $name, $minCredit);
		$db = new database();
		$link = $db->start();
		$result = $db->execute_sql("insert", $sql);
		mysql_close($link);
		return $result;
	}

	public function moduleNotExists($name)
	{
		$text = "select * from module where name = '%s'";
		$sql = sprintf($text, $name);
		$db = new database();
		$link = $db->start();
		$result = $db->execute_sql("select", $sql);
		$array = mysql_fetch_array($result);
		mysql_close($link);
		return ($array == null);
	}
}
?>
