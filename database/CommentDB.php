<?php
$projectName = "GreenHorse";
$database_basic = $_SERVER['DOCUMENT_ROOT'].$projectName."/database/database_basic.php";
require_once($database_basic);

class CommentDB{
	public function insertComment($comment){
		$text = "insert into courseComment(studentId,courseId,rating1,rating2,rating3,comment)" .
				"values('%s',%s,%s,%s,%s,'%s')";
        $sql = sprintf($text, $comment['studentId'],$comment['courseId'],$comment['rating1'],
        			$comment['rating2'],$comment['rating3'],$comment['comment']);
        $db = new database();
        $link = $db->start();
        $result = $db->execute_sql("insert", $sql);
        mysql_close($link);
        return $result;
	}
	public function selectComment($studentId, $courseId){
		$text = "select * from coursecomment where studentId = '%s' and courseId = %s";
        $sql = sprintf($text, $studentId, $courseId);
        $db = new database();
        $link = $db->start();
        $result = $db->execute_sql("select", $sql);
        mysql_close($link);
        return $result;
	}
    public function selectAllUserCommentedCourses($id)
    {
        $text = "select * from takecourse where studentId = '%s'";
        $sql = sprintf($text, $id);
        $db = new database();
        $link = $db->start();
        $result = $db->execute_sql("select", $sql);
        mysql_close($link);
        return $result;
    }
    /*
     * 返回某个学生对某门课是否已评价，返回true或者false
     */
    public function isCommented($studentId, $courseId)
    {
        $text = "select * from coursecomment where studentId = '%s' and courseId = %d";
        $sql = sprintf($text, $studentId, $courseId);
        $db = new database();
        $link = $db->start();
        $result = $db->execute_sql("select", $sql);
        $array = mysql_fetch_array($result);
        mysql_close($link);
        return ($array != NULL);
    }
    /*
     * 根据courseId把某门课的所有评价提取出来
     */
    public function selectCommentsByCourseId($courseId, $start=0, $length=999){
    	$text = "select * from courseComment where courseId = %s limit %s, %s";
        $sql = sprintf($text, $courseId, $start, $length);
        $db = new database();
        $link = $db->start();
        $result = $db->execute_sql("select", $sql);
        mysql_close($link);
        return $result;
    }
    /*
     * 根据courseId提取某门课的平均分
     */
    public function selectAvgRatingByCourseId($courseId){
    	$text = "select avg(rating1) rating1, avg(rating2) rating2, avg(rating3) rating3" .
    			" from coursecomment where courseId = %s";
        $sql = sprintf($text, $courseId);
        $db = new database();
        $link = $db->start();
        $result = $db->execute_sql("select", $sql);
        mysql_close($link);
        return $result;
    }

    public function selectQuitReasonsByCourseId($courseId, $start=0, $length=999){
        $text = "select * from quitcourse where courseId = %s limit %s, %s";
        $sql = sprintf($text, $courseId, $start, $length);
        $db = new database();
        $link = $db->start();
        $result = $db->execute_sql("select", $sql);
        mysql_close($link);
        return $result;
    }
}
?>
