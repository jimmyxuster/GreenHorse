<?php
$projectName = "GreenHorse";
$database_basic = $_SERVER['DOCUMENT_ROOT'].$projectName."/database/database_basic.php";
require_once($database_basic);

class CreditDB{
	/*
	 * 查找某学生的所有已修学分
	 */
	public function selectAllUserFinishedCredits($userId){
		$text = "select sum(credit) from finishedcredit where studentId = '%s'";
		$sql = sprintf($text,$userId);
		$db = new database();
		$link = $db->start();
		$result = $db->execute_sql("select", $sql);
		mysql_close($link);
		return $result;
	}
	/*
	 * 查找某学生的在某模块下的所有已修学分
	 */
	public function selectAllUserFinishedCreditsByModuleId($userId,$moduleId){
		$text = "select sum(credit) from finishedcredit where studentId = '%s' and moduleId = %s";
		$sql = sprintf($text,$userId,$moduleId);
		$db = new database();
		$link = $db->start();
		$result = $db->execute_sql("select", $sql);
		mysql_close($link);
		return $result;
	}
	/*
	 * 查找所有需要的学分数量（所有模块minCredit的和）
	 */
	public function selectAllCreditsNeeded(){
		$text = "select sum(minCredit) from module";
		$sql = sprintf($text);
		$db = new database();
		$link = $db->start();
		$result = $db->execute_sql("select", $sql);
		mysql_close($link);
		return $result;
	}
	/*
	 * 查看某个班的所有学生修过的学分
	 */
	public function selectUserCreditsByClassId($classId){
		$text = "select userId,classId,credit from userinclass " .
				"left outer join usercredit " .
				"on userinclass.userId = usercredit.studentId " .
				"where classId=%s";
		$sql = sprintf($text,$classId);
		$db = new database();
		$link = $db->start();
		$result = $db->execute_sql("select", $sql);
		mysql_close($link);
		return $result;
	}
}
?>
