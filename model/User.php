<?php
$projectName = "GreenHorse";
$database_basic = $_SERVER['DOCUMENT_ROOT'].$projectName."/database/UserDB.php";
require_once($database_basic);
	class User{
		var $id;
		var $name;
		var $sex;
		var $institute;
		var $branch;
		var $grade;
		var $type;
		var $dormitory;
		var $permission;
		var $tel;
		var $email;
		var $createTime;
		var $password;
		public function __construct($id){
			$userDB = new UserDB();
			$result = $userDB->selectUserById($id);
			$line = mysql_fetch_array($result);
			if(!$line){
				return;
			}
			$this->id = $line['id'];
			$this->name = $line['name'];
			$this->sex = $line['sex'];
			$this->institute = $line['institude'];
			$this->branch = $line['branch'];
			$this->grade = $line['grade'];
			$this->type = $line['type'];
			$this->dormitory = $line['dormitory'];
			$this->permission = $line['permission'];
			$this->tel = $line['tel'];
			$this->email = $line['email'];
			$this->createTime = $line['createTime'];
			$this->password = $line['password'];
		}
	}
 	
?>
