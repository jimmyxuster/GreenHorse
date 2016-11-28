<?php
$projectName = "GreenHorse";
$database_basic = $_SERVER['DOCUMENT_ROOT'].$projectName."/database/database_basic.php";
require_once($database_basic);
class CourseDB
{
	public function selectCourseById($id){
		$text = "select * from course where id = ".$id;
        $sql = sprintf($text);
        $db = new database();
        $link = $db->start();
        $result = $db->execute_sql("select", $sql);
        mysql_close($link);
        return $result;
	}
	
	/*
	 * 选出所有课程
	 */
	public function selectCourses($start=0, $length=999){
		$text = "select * from course limit %s, %s";
        $sql = sprintf($text,$start,$length);
        $db = new database();
        $link = $db->start();
        $result = $db->execute_sql("select", $sql);
        mysql_close($link);
        return $result;
	}
    /*
     * 查找某学生的全部已选课程
     */
    public function selectAllUserTakenCourses($id)
    {
        $text = "select takecourse.* from takecourse left outer join course 
                on course.id = takecourse.courseId where studentId = '%s' order by course.datetime";
        $sql = sprintf($text, $id);
        $db = new database();
        $link = $db->start();
        $result = $db->execute_sql("select", $sql);
        mysql_close($link);
        return $result;
    }
    public function selectAllUserPresentedCourses($id)
    {
        $text = "select takecourse.* from takecourse left outer join course 
                on course.id = takecourse.courseId where studentId = '%s' and takecourse.attendance = '出席' order by course.datetime";
        $sql = sprintf($text, $id);
        $db = new database();
        $link = $db->start();
        $result = $db->execute_sql("select", $sql);
        mysql_close($link);
        return $result;
    }
	/*
	 * 查看某门课
	 */
    public function selectCoursesInfoFromCourseId($id)
    {
        $text = "select * from course where id = %s";
        $sql = sprintf($text, $id);
        $db = new database();
        $link = $db->start();
        $result = $db->execute_sql("select", $sql);
        mysql_close($link);
        return $result;
    }

	/*
	 * 选出用户没有选过的所有还没有到时间的课
	 */
	public function selectFutureCoursesNotSelectedByUser($userId){
		$text = "select * from course where datetime >= now() and id not in" .
				"(select courseId from takecourse where studentId = '%s')";
        $sql = sprintf($text, $userId);
        $db = new database();
        $link = $db->start();
        $result = $db->execute_sql("select", $sql);
        mysql_close($link);
        return $result;
	}
	/*
	 * 选出某模块下，用户没有选过的所有还没有到时间的课
	 */
	public function selectFutureCoursesNotSelectedByUserInModule($userId, $moduleId){
		$text = "select * from course where datetime >= now() and moduleId = %s and id not in" .
				"(select courseId from takecourse where studentId = '%s')order by datetime";
        $sql = sprintf($text, $moduleId, $userId);
        $db = new database();
        $link = $db->start();
        $result = $db->execute_sql("select", $sql);
        mysql_close($link);
        return $result;
	}
	/*
	 * 添加takecourse
	 */
	public function addTakecourse($takecourse){
		$text = "insert into takecourse(studentId, courseId, attendance)" .
				"values('%s', %s, '%s')";
        $sql = sprintf($text, $takecourse['studentId'], 
        			$takecourse['courseId'], $takecourse['attendance']);
        $db = new database();
        $link = $db->start();
        $result = $db->execute_sql("insert", $sql);
        mysql_close($link);
        return $result;
	}
	/*
	 * 根据studentId和courseId选出takecourse
	 */
	public function selectTakecourse($studentId,$courseId){
        $text = "select * from takecourse where studentId = '%s' and courseId = %s";
        $sql = sprintf($text, $studentId, $courseId);
        $db = new database();
        $link = $db->start();
        $result = $db->execute_sql("select", $sql);
        mysql_close($link);
        return $result;
    }
	/*
	 * 选出选了某门课的所有学生
	 */
	public function selectStudentsInCourse($courseId){
		$text = "select * from user where id in " .
				"(select studentId from takecourse where courseId = %s)";
        $sql = sprintf($text, $courseId);
        $db = new database();
        $link = $db->start();
        $result = $db->execute_sql("select", $sql);
        mysql_close($link);
        return $result;
	}

	public function deleteTakecourse($userId, $courseId){
		$text = "delete from takecourse where studentId = '%s' and courseId = %s";
        $sql = sprintf($text, $userId, $courseId);
        $db = new database();
        $link = $db->start();
        $result = $db->execute_sql("delete", $sql);
        mysql_close($link);
        return $result;
	}
	public function updateTakecourse($takecourse){
		$text = "update takecourse set attendance = '%s' where studentId = '%s' and courseId = %s";
        $sql = sprintf($text, $takecourse['attendance'],$takecourse['studentId'],$takecourse['courseId']);
        $db = new database();
        $link = $db->start();
        $result = $db->execute_sql("update", $sql);
        mysql_close($link);
        return $result;
	}

    public function selectAllFutureCourses($start=0, $length=999)
    {
        $text = "select * from course where datetime > now() order by datetime desc limit %s,%s";
        $sql = sprintf($text, $start, $length);
        $db = new database();
        $link = $db->start();
        $result = $db->execute_sql("select", $sql);
        mysql_close($link);
        return $result;
    }

    public function insertCourse($courseName, $credit, $datetime, $location, $duration, $maxNumber, $module)
    {
        $text = "insert into course (name, credit, datetime, location, duration, maxNumber, moduleId)
                 values ('%s', %s, '%s', '%s', %s, %s, %s)";
        $sql = sprintf($text, $courseName, $credit, $datetime, $location, $duration, $maxNumber, $module);
        $db = new database();
        $link = $db->start();
        $result = $db->execute_sql("insert", $sql);
        mysql_close($link);
        return $result;
    }
    /*
     * 分页选出所有已经结束了的课程,按时间倒序
     * ****这里的已结束是指，过了开课时间的课程
     */
    public function selectAllFinishedCourses($start=0, $length=999)
    {
        $text = "select * from course where datetime < now() " .
        		"order by datetime desc limit %s, %s";
        $sql = sprintf($text,$start,$length);
        $db = new database();
        $link = $db->start();
        $result = $db->execute_sql("select", $sql);
        mysql_close($link);
        return $result;
    }
    /*
     * 选出所有正在进行中的课程
     * 按时间倒序
     */
    public function selectOngoingCourses($start=0,$length=999){
    	$text = "select * from course where datetime<now() and datetime+SEC_TO_TIME(duration*60)>=now() " .
        		"order by datetime desc limit %s, %s";
        $sql = sprintf($text,$start,$length);
        $db = new database();
        $link = $db->start();
        $result = $db->execute_sql("select", $sql);
        mysql_close($link);
        return $result;
    }
    /*
     * 选出所有已经结束的课程
     * *****这里的已经结束是指时间>datetime+duration的课程
     * *****因为duration不是必填项，所以duration可能是null或0，
     * *****所以对这类课程，只要超过开始时间，就算已经结束
     * 按时间倒序
     */
     public function selectCoursesAfterDuration($start=0,$length=999){
    	$text = "select * from course where datetime+SEC_TO_TIME(duration*60)<now() union " .
    			"select * from course where (ISNULL(duration)or duration = 0) and  datetime < now()" .
        		"order by datetime desc limit %s, %s";
        $sql = sprintf($text,$start,$length);
        $db = new database();
        $link = $db->start();
        $result = $db->execute_sql("select", $sql);
        mysql_close($link);
        return $result;
    }

    public function selectCoursesAfterDurationCount($start=0,$length=999){
        $text = "select count(*) from course where datetime+SEC_TO_TIME(duration*60)<now() limit %s, %s";
        $sql = sprintf($text,$start,$length);
        $db = new database();
        $link = $db->start();
        $result = $db->execute_sql("select", $sql);
        if(mysql_num_rows($result)) {
            $rs = mysql_fetch_array($result);
            $count = $rs[0];
        }else{
            $count = 0;
        }
        mysql_close($link);
        return $count;
    }
    /*
     * 选出某门课所有的takecourse，并且还有用户的一些数据
     */
    public function selectTakecourseAndUserInfoByCourseId($courseId){
    	$text = "select takecourse.*,user.name from takecourse left outer join user " .
    			"on user.id = takecourse.studentId where takecourse.courseId = %s";
        $sql = sprintf($text,$courseId);
        $db = new database();
        $link = $db->start();
        $result = $db->execute_sql("select", $sql);
        mysql_close($link);
        return $result;
    }

    public function courseNotExists($name)
    {
        $text = "select * from course where name = '%s'";
        $sql = sprintf($text, $name);
        $db = new database();
        $link = $db->start();
        $result = $db->execute_sql("select", $sql);
        $array = mysql_fetch_array($result);
        mysql_close($link);
        return ($array == null);
    }

    public function selectAllCourses(){
        $text = "select * from course";
        $sql = sprintf($text);
        $db = new database();
        $link = $db->start();
        $result = $db->execute_sql("select", $sql);
        mysql_close($link);
        return $result;
    }

    public function addQuitCourse($studentId, $courseId, $reason){
        $text = "insert into quitcourse(studentId, courseId, reason)" .
            "values('%s', %s, '%s')";
        $sql = sprintf($text, $studentId,
            $courseId, $reason);
        $db = new database();
        $link = $db->start();
        $result = $db->execute_sql("insert", $sql);
        mysql_close($link);
        return $result;
    }

    public function selectCoursesCount(){
        $text = "select count(*) from course";
        $sql = sprintf($text);
        $db = new database();
        $link = $db->start();
        $result = $db->execute_sql("select", $sql);
        if(mysql_num_rows($result)) {
            $rs = mysql_fetch_array($result);
            $count = $rs[0];
        }else{
            $count = 0;
        }
        mysql_close($link);
        return $count;
    }
}
?>
