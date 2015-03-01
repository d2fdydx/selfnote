<?php
	
	class User extends ActiveRecord{
		static protected  $s_table = 'users';
		static protected $s_field = array('user_name','nickname','password','user_levels_id');
		protected $grade=null;
		protected function initField($argv){
			if (!isset($argv['user_levels_id'])){ // default grade
				$result = UserLevel::findBy(array('name'=>'normal'));
				if ($result == null){
					include(BASE_URI.'views/error.inc.html');
					exit;
				}
				//print_r($result);
				$this->m_field['user_levels_id']=$result->getObjectData('id');
			}	
		
		}
		
		public function isAdmin(){
			if ($this->grade!=null){
				if (in_array($this->grade,UserLevel::$s_admin)){
					return true;
				}
			}else{
				$this->setGrade();	
				if (in_array($this->grade,UserLevel::$s_admin)){
					return true;
				}
			}
			return false;
		}	

		public function isNormal(){
			if ($this->grade !=null){
				if (in_array($this->grade,UserLevel::$s_normal)){
					return true;
				}
			}else{
				$this->setGrade();	
				if (in_array($this->grade,UserLevel::$s_normal)){
					return true;
				}
			}
			return false;

		}

		//get the user level grade
		private function setGrade(){
				$this->join('UserLevel');
				$result = $this->getData();
				$row = $result->fetch();
				$this->grade = $row['user_levels.grade'];
				self::setSessionUser($this);

		}


		static public function setSessionUser($user){
			global $s_user;
			$_SESSION['user'] = $user;
			$s_user =$user;	
		}
		static public function getSessionUser(){
			if (isset($_SESSION['user'] )){
				return $_SESSION['user'];
			}else {
				return null;
			}
		}
		static public function isLogin(){
			global $s_user;
			if ($s_user == null){
				return false;
			}else{
				return true;
			}
		}
		static public function logout(){
			global $s_user;
			$s_user =null;
			if (isset($_SESSION['user']))
				unset($_SESSION['user']);
		}
	}


?>
