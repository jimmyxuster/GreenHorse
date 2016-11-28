<?php
$projectName = "GreenHorse";
$database_basic = $_SERVER['DOCUMENT_ROOT'].$projectName."/database/database_basic.php";
require_once($database_basic);


class TakeCourseDB
{
    public function addCourseForStudent($studentId, $courseId)
    {
        $text = "insert into takecourse (studentId, courseId)
        values ('%s', %s)";
        $sql = sprintf($text, $studentId, $courseId);
        $db = new database();
        $link = $db->start();
        $result = $db->execute_sql("insert", $sql);
        mysql_close($link);
        return $result;
    }
    
    public function removeStudentFromCourse($studentId, $courseId)
    {
        $text = "delete from takecourse where studentId = '%s' and courseId = %s";
        $sql = sprintf($text, $studentId, $courseId);
        $db = new database();
        $link = $db->start();
        $result = $db->execute_sql("delete", $sql);
        mysql_close($link);
        return $result;
    }

    public function studentAlreadyInCourse($studentId, $courseId)
    {
        $text = "select * from takecourse where studentId = '%s' and courseId = %s";
        $sql = sprintf($text, $studentId, $courseId);
        $db = new database();
        $link = $db->start();
        $result = $db->execute_sql("select", $sql);
        $fetch = mysql_fetch_array($result);
        mysql_close($link);
        return ($fetch != null);
    }
}
?>