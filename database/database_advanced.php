 <?php
require('database_basic.php');
date_default_timezone_set('PRC');
mysql_query("set name 'UTF8'");

class ClassDB{
	public function select_last30days_classes($type=""){
		if($type == ""){
			$text = "select * from class";
			$sql = sprintf($text);
		}else if($type != null){
			$text = "select * from class where tag = %s";
			$sql = sprintf($text, $type);
		}else{
			return null;
		}
		$db = new database();
		$link = $db->start();
		$result = $db->execute_sql("select", $sql);
		mysql_close($link);
		return $result;
	}
}

class UserDB{
	public function add_user($id,$name, $tel, $type){
		$db = new database();
		$text = "insert into user(id,name,tel,type,createTime) values ('%s', '%s', '%s', '%s', '%s')";
		$date = date('Y-m-d H:m:s');
		$sql = sprintf($text, $id, $name, $tel, $type, $date);
		$link = $db->start();
		$result = $db->execute_sql("insert", $sql);
		mysql_close($link);
		return $result;
	}
	public function select_user_by_id($id){
		$text = "select * from user where id = '%s'";
		$sql = sprintf($text, $id);
		$db = new database();
		$link = $db->start();
		$result = $db->execute_sql("select", $sql);
		mysql_close($link);
		return $result;
	}
	public function select_user_by_openId($openId){
		$text = "select * from user where openId = '%s'";
		$sql = sprintf($text, $openId);
		$db = new database();
		$link = $db->start();
		$result = $db->execute_sql("select", $sql);
		mysql_close($link);
		return $result;
	}
	/*
	 * 选出所有非管理员的用户
	 */
	public function select_common_user(){
		$text = "select * from user where type != 'admin' order by type";
		$sql = $text;
		$db = new database();
		$link = $db->start();
		$result = $db->execute_sql("select", $sql);
		mysql_close($link);
		return $result;
	}
	public function update_user($user){
		$db = new database();
		$text = "UPDATE user SET tel  = '%s', openId = '%s', createTime = '%s'" .
				" WHERE id = '%s'";
		$sql = sprintf($text, $user['tel'], $user['openId'], $user['createTime'], $user['id']);
		$link = $db->start();
		$result = $db->execute_sql("update", $sql);
		mysql_close($link);
		return $result;
	}
	/*
	 * 根据userId查找该用户参加的所有课程
	 */
	public function select_user_classes($id){
		$text = "select " .
				"studentId, classId, ifAttended, scoreFromStudent, commentFromStudent,
				scoreFromOrg, commentFromOrg, user.name userName, tel, user.type userType, openId, createTime,
				class.name className, class.date classDate, class.time classTime, " .
				"class.content classContent, pic, tag, course.id courseId, course.name courseName, " .
				"course.type courseType, year courseYear ".
				" from takeclass left outer join user " .
				"on takeclass.studentId = user.id " .				
				"left outer join class " .
				"on takeclass.classid = class.id " .
				"left outer join course " .
				"on class.courseid = course.id " .
				"where studentId = '%s'";
		$sql = sprintf($text, $id);
		$db = new database();
		$link = $db->start();
		$result = $db->execute_sql("select", $sql);
		mysql_close($link);
		return $result;
	}
	/*
	 * 找出用户在某时间段内的所有课程
	 */
	public function select_user_classes_during($userId,$start,$end){
		$text = "select distinct class.* " .
				" from class,takecourse,user " .
				"where takecourse.courseId = class.courseId " .
				"and user.id=takecourse.studentId " .
				"and user.id= '%s' " .
				"and class.date >= '%s' " .
				"and class.date <= '%s' " .
				"order by date";
		$sql = sprintf($text, $userId, $start,$end);
		$db = new database();
		$link = $db->start();
		$result = $db->execute_sql("select", $sql);
		mysql_close($link);
		return $result;
	}
	
	//根据openId删除用户
	public function delete_user_by_id($id){
		$db = new database();
		$text = "delete from user where id = '%s'";
		$sql = sprintf($text, $id);
		$link = $db->start();
		$result = $db->execute_sql("delete", $sql);
		mysql_close($link);
		return $result;
	}
}
class CourseDB{
	public function add_course($name,$type,$year){
		$db = new database();
		$text = "insert into course(name,type,year) values ('%s', '%s', '%s')";
		$sql = sprintf($text, $name, $type, $year);
		$link = $db->start();
		$result = $db->execute_sql("insert", $sql);
		mysql_close($link);
		$result = $this->select_last_id();
		return $result;
	}
	public function add_class($name,$date, $time, $duration, $location,$content, $pic,$courseId){
		$db = new database();
		$text = "insert into class(name,date,time,duration,location,content,pic,courseId) values ('%s', '%s', '%s', %s, '%s','%s', '%s',%s)";
		$sql = sprintf($text, $name, $date, $time, $duration, $location,$content, $pic, $courseId);
		$link = $db->start();
		$result = $db->execute_sql("insert", $sql);
		mysql_close($link);
		return $result;
	}
	public function add_takecourse($studentId, $courseId){
		$db = new database();
		$text = "insert into takecourse(studentId, courseId) values ('%s', %s)";
		$sql = sprintf($text, $studentId, $courseId);
		$link = $db->start();
		$result = $db->execute_sql("insert", $sql);
		mysql_close($link);
		return $result;
	}
	public function add_takeclass($array){
		$text = "insert into takeclass values('%s',%s,%s,'%s','%s','%s','%s')";
		$sql = sprintf($text, $array['studentId'],$array['classId'],
			$array['ifAttended'],$array['scoreFromStudent'],
			$array['commentFromStudent'],$array['scoreFromOrg'],$array['commentFromOrg']);
		$db = new database();
		$link = $db->start();
		$result = $db->execute_sql("insert", $sql);
		mysql_close($link);
		return $result;
	}
	
	public function delete_takecourse_by_courseId($courseId){
		$text = "delete from takecourse 
				where courseId = %s";
		$sql = sprintf($text, $courseId);
		$db = new database();
		$link = $db->start();
		$result = $db->execute_sql("delete", $sql);
		mysql_close($link);
		return $result;
	}
	public function select_last_id(){
		$db = new database();
		$text = "select max(id) id from course";
		$link = $db->start();
		$result = $db->execute_sql("select", $text);
		$line = mysql_fetch_array($result);
		return $line['id'];
	}
	public function select_takeclass($studentId, $classId){
		$db = new database();
		$text = "select * from takeclass where studentId = '%s' and classId = %s";
		$sql = sprintf($text, $studentId, $classId);
		$link = $db->start();
		$result = $db->execute_sql("select", $sql);
		mysql_close($link);
		return $result;
	}
	public function select_takeclass_by_classId($classId){
		$db = new database();
		$text = "select * from takeclass where classId = %s";
		$sql = sprintf($text, $classId);
		$link = $db->start();
		$result = $db->execute_sql("select", $sql);
		mysql_close($link);
		return $result;
	}
	/*
	 * 选出参加某class的全部成员,通过匹配takecourse.studentId和user.id
	 */
	public function select_users_in_class($classId){
		$db = new database();
		$text = "select distinct user.* from user,takecourse,class " .
				"where takecourse.studentId = user.id " .
				"and takecourse.courseId = class.courseId and class.id = %s";
		$sql = sprintf($text, $classId);
		$link = $db->start();
		$result = $db->execute_sql("select", $sql);
		mysql_close($link);
		return $result;
	}
	
	public function select_class($classId){
		$db = new database();
		$text = "select * from class where id = %s";
		$sql = sprintf($text, $classId);
		$link = $db->start();
		$result = $db->execute_sql("select", $sql);
		mysql_close($link);
		return $result;
	}
	/*
	 * 选出某时间段内的所有课程
	 */
	public function select_classes_during($start,$end){
		$text = "SELECT * FROM class WHERE " .
				"date >= '%s' and date <= '%s'" .
				"order by date";
		$sql = sprintf($text, $start,$end);
		$db = new database();
		$link = $db->start();
		$result = $db->execute_sql("select", $sql);
		mysql_close($link);
		return $result;
	}
	
	public function delete_class($classId){
		$text = "delete from class 
				where id = %s";
		$sql = sprintf($text, $classId);
		$db = new database();
		$link = $db->start();
		$result = $db->execute_sql("delete", $sql);
		mysql_close($link);
		return $result;
	}
	/*
	 * 选出某course的所有class
	 */
	public function select_class_by_courseId($courseId){
		$db = new database();
		$text = "select * from class where courseId = %s order by date";
		$sql = sprintf($text, $courseId);
		$link = $db->start();
		$result = $db->execute_sql("select", $sql);
		mysql_close($link);
		return $result;
	}	
	
	public function select_all_course(){
		$db = new database();
		$text = "select * from course";
		$sql = $text;
		$link = $db->start();
		$result = $db->execute_sql("select", $sql);
		mysql_close($link);
		return $result;
	}	
	
	public function select_course($id){
		$db = new database();
		$text = "select * from course where id = %s";
		$sql = sprintf($text, $id);
		$link = $db->start();
		$result = $db->execute_sql("select", $sql);
		mysql_close($link);
		return $result;
	}	
	
	public function select_course_by_year($year){
		$db = new database();
		$text = "select * from course where year= %s";
		$sql = sprintf($text, $year);
		$link = $db->start();
		$result = $db->execute_sql("select", $sql);
		mysql_close($link);
		return $result;
	}	
	public function update_class($array){
		$text = "update class set name = '%s', " .
				"date = '%s', time = '%s',".
				"duration = %s,location='%s', content = '%s', ".
				"pic = '%s', tag = '%s'".
				"where id = %s";
		$sql = sprintf($text, $array['name'],$array['date'], $array['time'],
			$array['duration'],$array['location'],$array['content'],$array['pic'],$array['tag'],
			$array['id']);
		$db = new database();
		$link = $db->start();
		$result = $db->execute_sql("update", $sql);
		mysql_close($link);
		return $result;
	}	
	/*
	 * ****注意：takeclass不一定代表某用户注册某门课。
	 * 当（1）用户对课程有评价。
	 * 或（2）admin对user有出勤统计，
	 * takeclass才会产生数据
	 * 
	 * 先检验takeclass中是否存在记录，如果存在则updat，不存在则insert
	 */
	public function update_takeclass($array){
		$result = $this->select_takeclass($array['studentId'], $array['classId']);
		$line = mysql_fetch_array($result);
		$flag = '';
		if($line == null){
			$result = $this->add_takeclass($array);
			$flag = 'takeclass不存在';
		}else{
			$text = "update takeclass set ifAttended = %s, " .
					"scoreFromStudent = '%s', commentFromStudent = '%s',".
					"scoreFromOrg = '%s',commentFromOrg = '%s'".
					"where studentId='%s' and classId = %s";
			$sql = sprintf($text, $array['ifAttended'],$array['scoreFromStudent'],
			$array['commentFromStudent'],$array['scoreFromOrg'],$array['commentFromOrg'],
			$array['studentId'],$array['classId']);
			$db = new database();
			$link = $db->start();
			$result = $db->execute_sql("update", $sql);
			mysql_close($link);
			$flag = 'takeclass存在';
		}
		return $result;
	}	
	/*
	 * 选出所有参加过某course的学生名单
	 */
	public function select_user_takeCourse($courseId){
		$db = new database();
		$text = "select distinct studentId, courseId, user.name studentName," .
				"course.name courseName, course.type courseType,tel," .
				"openId from takecourse,user,course " .
				"where user.id = takecourse.studentId " .
				"and course.id = takecourse.courseId " .
				"and courseId= %s";
		$sql = sprintf($text, $courseId);
		$link = $db->start();
		$result = $db->execute_sql("select", $sql);
		mysql_close($link);
		return $result;
	}
	/*
	 * 选出所有***没有***参加过某course的学生名单
	 * ****不包括admin
	 */
	public function select_user_nottakeCourse($courseId){
		$db = new database();
		$text = "SELECT user.id studentId, user.name studentName," .
				"tel,type studentType,openId,createTime, courseId " .
				" FROM user left outer join takecourse " .
				" on user.id = takecourse.studentId " .
				" where user.id not in " .
				" (select studentId from takecourse where courseId = %s)" .
				" and user.type !='admin'";
		$sql = sprintf($text, $courseId);
		$link = $db->start();
		$result = $db->execute_sql("select", $sql);
		mysql_close($link);
		return $result;
	}
}
class NoticeDB{
	public function add_notice($title,$status, $content, $picUrl, $type, $url){
		$db = new database();
		$text = "insert into notice(title,status, content, picUrl, type, url, time) values ('%s', '%s', '%s', '%s', '%s', '%s','%s')";
		$date = date('Y-m-d H:m:s');
		$sql = sprintf($text, $title,$status, $content, $picUrl, $type, $url, $date);
		$link = $db->start();
		$result = $db->execute_sql("insert", $sql);
		mysql_close($link);
		return $result;
	}
	public function update_notice($id, $status, $content, $picUrl, $url){
		$db = new database();
		$text = "UPDATE NOTICE SET status  = '%s', content = '%s', picUrl = '%s'," .
				"url = '%s' WHERE id = '%s'";
		$sql = sprintf($text, $status, $content, $picUrl, $url, $id);
		$link = $db->start();
		$result = $db->execute_sql("update", $sql);
		mysql_close($link);
		return $result;
	}
	public function delete_notice($id){
		$db = new database();
		$text = "delete from notice where id = '%s'";
		$sql = sprintf($text, $id);
		$link = $db->start();
		$result = $db->execute_sql("delete", $sql);
		mysql_close($link);
		return $result;
	}
	public function select_notice_by_id($id){
		$db = new database();
		$text = "select * from notice where id = %s";
		$sql = sprintf($text, $id);
		$link = $db->start();
		$result = $db->execute_sql("select", $sql);
		mysql_close($link);
		return $result;
	}
	/*
	 * 选出所有status为on的notice
	 */
	public function select_notice(){
		$db = new database();
		$text = "select * from notice where status = 'on' order by time desc";
		$sql = sprintf($text);
		$link = $db->start();
		$result = $db->execute_sql("select", $sql);
		mysql_close($link);
		return $result;
	}
	/*
	 * 选出所有status为on和off的notice
	 */
	public function select_all_notice(){
		$db = new database();
		$text = "select * from notice order by time desc";
		$sql = sprintf($text);
		$link = $db->start();
		$result = $db->execute_sql("select", $sql);
		mysql_close($link);
		return $result;
	}
}

class LmaterialsDB{
	public function add_lmaterials($title,$status, $content, $picUrl, $type, $url){
		$db = new database();
		$text = "insert into lmaterials(title,status, content, picUrl, type, url, time) values ('%s', '%s', '%s', '%s', '%s', '%s','%s')";
		$date = date('Y-m-d H:m:s');
		$sql = sprintf($text, $title,$status, $content, $picUrl, $type, $url, $date);
		$link = $db->start();
		$result = $db->execute_sql("insert", $sql);
		mysql_close($link);
		return $result;
	}
	public function update_lmaterials($id, $status, $content, $picUrl, $url){
		$db = new database();
		$text = "UPDATE lmaterials SET status  = '%s', content = '%s', picUrl = '%s'," .
				"url = '%s' WHERE id = '%s'";
		$sql = sprintf($text, $status, $content, $picUrl, $url, $id);
		$link = $db->start();
		$result = $db->execute_sql("update", $sql);
		mysql_close($link);
		return $result;
	}
	public function delete_lmaterials($id){
		$db = new database();
		$text = "delete from lmaterials where id = '%s'";
		$sql = sprintf($text, $id);
		$link = $db->start();
		$result = $db->execute_sql("delete", $sql);
		mysql_close($link);
		return $result;
	}
	public function select_lmaterials_by_id($id){
		$db = new database();
		$text = "select * from lmaterials where id = %s";
		$sql = sprintf($text, $id);
		$link = $db->start();
		$result = $db->execute_sql("select", $sql);
		mysql_close($link);
		return $result;
	}
	/*
	 * 选出所有status为on的lmaterials
	 */
	public function select_lmaterials(){
		$db = new database();
		$text = "select * from lmaterials where status = 'on' order by time desc";
		$sql = sprintf($text);
		$link = $db->start();
		$result = $db->execute_sql("select", $sql);
		mysql_close($link);
		return $result;
	}
	/*
	 * 选出所有status为on和off的lmaterials
	 */
	public function select_all_lmaterials(){
		$db = new database();
		$text = "select * from lmaterials order by time desc";
		$sql = sprintf($text);
		$link = $db->start();
		$result = $db->execute_sql("select", $sql);
		mysql_close($link);
		return $result;
	}
}

class DataDB{
	public function add_data($title,$status, $content, $picUrl, $type, $url){
		$db = new database();
		$text = "insert into data(title,status, content, picUrl, type, url, time) values ('%s', '%s', '%s', '%s', '%s', '%s','%s')";
		$date = date('Y-m-d H:m:s');
		$sql = sprintf($text, $title,$status, $content, $picUrl, $type, $url, $date);
		$link = $db->start();
		$result = $db->execute_sql("insert", $sql);
		mysql_close($link);
		return $result;
	}
	public function update_data($id, $status, $content, $picUrl, $url){
		$db = new database();
		$text = "UPDATE data SET status  = '%s', content = '%s', picUrl = '%s'," .
				"url = '%s' WHERE id = '%s'";
		$sql = sprintf($text, $status, $content, $picUrl, $url, $id);
		$link = $db->start();
		$result = $db->execute_sql("update", $sql);
		mysql_close($link);
		return $result;
	}
	public function delete_data($id){
		$db = new database();
		$text = "delete from data where id = '%s'";
		$sql = sprintf($text, $id);
		$link = $db->start();
		$result = $db->execute_sql("delete", $sql);
		mysql_close($link);
		return $result;
	}
	public function select_data_by_id($id){
		$db = new database();
		$text = "select * from data where id = %s";
		$sql = sprintf($text, $id);
		$link = $db->start();
		$result = $db->execute_sql("select", $sql);
		mysql_close($link);
		return $result;
	}
	/*
	 * 选出所有status为on的notice
	 */
	public function select_data(){
		$db = new database();
		$text = "select * from data where status = 'on' order by time desc";
		$sql = sprintf($text);
		$link = $db->start();
		$result = $db->execute_sql("select", $sql);
		mysql_close($link);
		return $result;
	}
	/*
	 * 选出所有status为on和off的notice
	 */
	public function select_all_data(){
		$db = new database();
		$text = "select * from data order by time desc";
		$sql = sprintf($text);
		$link = $db->start();
		$result = $db->execute_sql("select", $sql);
		mysql_close($link);
		return $result;
	}
}

class TestDB{
	public function add_question($question){
		$db = new database();
		$text = "INSERT INTO `question`(`tag`, `createTime`, `expireTime`, `picUrl`, `question`, `choice`, `answer`, `status`) " .
				"VALUES ('%s','%s',%s,'%s','%s','%s','%s','on')";
		$date = date('Y-m-d H:m:s');
		if($question['expireTime'] == ''){
			$sql = sprintf($text, $question['tag'],$date, '0000-00-00', $question['picUrl'], $question['question'], $question['choice'], $question['answer'], $question['status']);
		}else{
			$sql = sprintf($text, $question['tag'],$date, $question['expireTime'], $question['picUrl'], $question['question'], $question['choice'], $question['answer'], $question['status']);
		}
		$link = $db->start();
		$result = $db->execute_sql("insert", $sql);
		mysql_close($link);
		return $result;
	}
	
	/*
	 * 说明：删掉所有已经过了有效期的问题
	 * 为了解决问题：可能存在未过期的普通试卷，其中有已过期的题目。
	 * 因为引入status。问题过期后不直接从question表中删除，而是将status改为off。
	 * 生成新的试卷时，只从status为on的题目中选。
	 */
	public function select_question($id){
		//先去除已过期题目
		$db = new database();
		$text = "update question set status = 'off' where expireTime < '%s' && expireTime != '0000-00-00'";
		$date = date('Y-m-d H:m:s');
		$sql = sprintf($text, $date);
		$link = $db->start();
		$result = $db->execute_sql("update", $sql);
		
		$text = "select * from question where id = %s";
		$sql = sprintf($text, $id);
		$link = $db->start();
		$result = $db->execute_sql("select", $sql);
		mysql_close($link);
		return $result;
	}
	/*
	 * 找到状态不是off的所有某tag下的question
	 */
	public function select_question_by_tag($tag){
		//先去除已过期题目
		$db = new database();
		$text = "update question set status = 'off' where expireTime < '%s' && expireTime != '0000-00-00'";
		$date = date('Y-m-d H:m:s');
		$sql = sprintf($text, $date);
		$link = $db->start();
		$result = $db->execute_sql("update", $sql);
		
		$text = "select * from question where tag = '%s' and status != 'off'";
		$sql = sprintf($text, $tag);
		$link = $db->start();
		$result = $db->execute_sql("select", $sql);
		mysql_close($link);
		return $result;
	}
	/*
	 * 找到所有question表中出现过的tag
	 */
	public function select_question_tags(){
		$db = new database();
		$text = "select distinct tag from question";
		$sql = sprintf($text);
		$link = $db->start();
		$result = $db->execute_sql("select", $sql);
		mysql_close($link);
		return $result;
	}
	public function update_question($question){
		$db = new database();
		$text = "update question set picUrl = '%s', status = '%s' where id = %s";
		$sql = sprintf($text, $question['picUrl'], $question['status'], $question['id']);
		echo $sql;
		$link = $db->start();
		$result = $db->execute_sql("update", $sql);
		mysql_close($link);
		return $result;
	}
	public function add_test($test){
		$db = new database();
		if($test['maxTimes'] == null || $test['maxTimes'] == ""){
			$test['maxTimes'] = 99;
		}
		$text = "INSERT INTO `test`(`testeeType`, `createTime`, `expireTime`, `status`, `numberByTag`, `title`, `questionIds`, `type`, `maxTimes`)" .
				"VALUES ('%s','%s','%s','on','%s','%s','%s','%s', %s)";
		$date = date('Y-m-d H:m:s');
		$sql = sprintf($text, $test['testeeType'], $date, $test['expireTime'], $test['numberByTag'], $test['title'], $test['questionIds'], $test['type'], $test['maxTimes']);
		$link = $db->start();
		$result = $db->execute_sql("insert", $sql);
		mysql_close($link);
		return $result;
	}
	/*
	 * 根据tag随机选出$count题
	 */
	public function select_random_question_by_tag($tag, $count){
		$db = new database();
		$text = "SELECT * FROM `question` WHERE tag = '%s' and status = 'on' order by rand() limit %s";
		$sql = sprintf($text, $tag, $count);
		$link = $db->start();
		$result = $db->execute_sql("select", $sql);
		mysql_close($link);
		return $result;
	}
	public function select_all_tests(){
		$db = new database();
		$text = "select * from test order by id";
		$sql = sprintf($text);
		$link = $db->start();
		$result = $db->execute_sql("select", $sql);
		mysql_close($link);
		return $result;
	}
	/*
	 * 查找最新的10个考试
	 */
	public function select_10_newsest_tests(){
		$db = new database();
		$text = "select * from test order by createTime desc limit 10";
		$sql = sprintf($text);
		$link = $db->start();
		$result = $db->execute_sql("select", $sql);
		mysql_close($link);
		return $result;
	}
	public function select_test($id){
		$db = new database();
		$text = "select * from test where id = %s";
		$sql = sprintf($text, $id);
		$link = $db->start();
		$result = $db->execute_sql("select", $sql);
		mysql_close($link);
		return $result;
	}
	public function update_test($test){
		$db = new database();
		$text = "update test set testeeType = '%s', expireTime = '%s'," .
				"status='%s', numberByTag='%s', title='%s'," .
				"questionIds='%s', maxTimes=%s where id = %s";
		$sql = sprintf($text, $test['testeeType'], $test['expireTime'],
				$test['status'], $test['numberByTag'], $test['title'],
				$test['questionIds'], $test['maxTimes'], $test['id']);
		$link = $db->start();
		$result = $db->execute_sql("update", $sql);
		mysql_close($link);
		return $result;
	}
	/*
	 * 根据学生类型和考试开放时间选择考试可以参加的所有考试
	 */
	public function select_test_by_testeeType($type){
		$db = new database();
		$text = "select * from test where (testeeType = '%s' || testeeType = '') and " .
				"status = 'on' and (expireTime >= '%s' || expireTime = '0000-00-00') order by id desc";
		$date = date('Y-m-d H:m:s');
		$sql = sprintf($text, $type, $date);
		$link = $db->start();
		$result = $db->execute_sql("select", $sql);
		mysql_close($link);
		return $result;
	}
	public function select_taketest($userId,$testId){
		$db = new database();
		$text = "select * from taketest where userId = '%s' and testId = %s";
		$sql = sprintf($text, $userId, $testId);
		$link = $db->start();
		$result = $db->execute_sql("select", $sql);
		mysql_close($link);
		return $result;
	}
	public function select_taketest_by_testId($testId){
		$db = new database();
		$text = "select * from taketest where testId = %s";
		$sql = sprintf($text, $testId);
		$link = $db->start();
		$result = $db->execute_sql("select", $sql);
		mysql_close($link);
		return $result;
	}
	public function add_taketest($taketest){
		$db = new database();
		$text = "INSERT INTO `taketest`(`userId`, `testId`, `score`, `time`, `times`) VALUES " .
				"('%s',%s,%s,'%s',0)";
		$date = date('Y-m-d H:m:s');
		$sql = sprintf($text, $taketest['userId'], $taketest['testId'], $taketest['score'], $date);
		$link = $db->start();
		$result = $db->execute_sql("insert", $sql);
		mysql_close($link);
		return $result;
	}
	public function update_taketest($taketest){
		$db = new database();
		$text = "update taketest set score = %s, time = '%s', times = %s " .
				"where userId = '%s' and testId = %s";
		$date = date('Y-m-d H:m:s');
		$sql = sprintf($text, $taketest['score'], $date,$taketest['times'],
				$taketest['userId'], $taketest['testId']);
		$link = $db->start();
		$result = $db->execute_sql("update", $sql);
		mysql_close($link);
		return $result;
	}
	
	public function add_taketestaction($taketestaction){
		$db = new database();
		$text = "INSERT INTO `taketestaction`(`userId`, `testId`, `duration`, " .
				"`time`, `score`, `correct`, `incorrect`) VALUES " .
				"('%s', %s, %s,'%s',%s, '%s', '%s')";
		$date = date('Y-m-d H:m:s');
		$sql = sprintf($text, $taketestaction['userId'], $taketestaction['testId'],
		 $taketestaction['duration'], $date, $taketestaction['score'],
		 $taketestaction['correct'], $taketestaction['incorrect']);
		$link = $db->start();
		$result = $db->execute_sql("insert", $sql);
		mysql_close($link);
		return $result;
	}
}
?>