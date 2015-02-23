<?php

class UserController {
	
	public function index(){
		$this->requireAdmin();

					
		$users = User::All(false,'UserLevel');
		if ($users==false){
			echo '<p> error </p>';
			return ;
		}
		
		//print_r($users);
		
		require(BASE_URI.'views/user/user_index.inc.html');
		
	}
	public function add(){
		$this->requireAdmin();
		$grades = UserLevel::All();
		
		require(BASE_URI.'views/user/add.inc.html');
	
	}
	public function edit($id){
		$this->requireAdmin();
		
		if (!ctype_digit($id)){
			return;
		}
		$grades = UserLevel::All();
		
		require(BASE_URI.'views/user/edit.inc.html');
	
	}
	public function login(){
		if (User::isLogin()){
			header('Location: /');	
			exit();
		}
		else {
			require(BASE_URI.'views/user/login.inc.html');
		}

	}	
	public function logout(){
		User::logout();
		ob_end_clean();
		FlashMessage::setMsg('You have logged out');
		header('Location: /');		
		exit();
	}	
	//===============post=================
	public function create(){
		$this->requireAdmin();
		$inputs = $_POST['object'];
		//print_r ($inputs);
		if (!$this->verifyInputs($inputs)){
			echo '<p> error </p>';
			exit;
		}
		$inputs['user_name'] = htmlentities($inputs['user_name']);
		$inputs['nickname'] = htmlentities($inputs['nickname']);
		$inputs['password'] = password_hash($inputs['password'], PASSWORD_DEFAULT);
		
		
		$user = new User($inputs);
		echo '<h1> adding </h1>';
		if ($user->save()==true){
			
			FlashMessage::setMsg("Added {$inputs['user_name']}");	
			unset($user);
			header('Location: http://'.USER_URL."user");
			exit;
		}
		unset($user);
	}
	public function update($id){
		$this->requireAdmin();
		if (!ctype_digit($id)){
			return;
		}
		$inputs = $_POST['object'];
		if (!$this->verifyInputs($inputs)){
			
			echo '<p> verify error </p>';
			exit;
		}
		$inputs['user_name'] = htmlentities($inputs['user_name']);
		$inputs['nickname'] = htmlentities($inputs['nickname']);
		$inputs['password'] = password_hash($inputs['password'], PASSWORD_DEFAULT);
		$inputs['id']=$id;
		$user = new User($inputs);
		if ($user->save()==true){
			
			
			unset($user);
			header('Location: http://'.USER_URL."user");
			exit;
		}
		unset($user);
	}
	
	
	public function delete(){
		$this->requireAdmin();
		ob_clean();
		if(!($user = User::find($_POST['id']))){
			echo '<h3> not found </h3>';
			ob_end_flush();
			exit();
		}
		
		if ($user->delete()){			
			echo '<h3> Deleted </h3>';			
		}else{
			echo '<h3> Fail </h3>';
		}
		unset($user);
		$this->index();
		ob_end_flush();
		exit();
	
	
	}
	public function p_login(){
		$inputs = $_POST['object'];
	//	print_r($inputs);
		$pwd = $inputs['password'];
		if(empty($pwd) || empty(trim($inputs['user_name']))){
			FlashMessage::setMsg('Empty/invalid');
			header('Location: /user/login');
		}		
		
		$para = array( 'user_name' => htmlentities($inputs['user_name']));
		//print_r ($para);
		$user_obj = User::findBy($para);	
		if ($user_obj == false){
			return ;


		}	
		//print_r ($user_obj->getObjectData('password'));
		if( password_verify($pwd,$user_obj->getObjectData('password'))){
			$user_obj->setObjectData('password','');
			User::setSessionUser($user_obj);
			FlashMessage::setMsg('You have logged in');
			ob_end_clean();
			header('Location: /');
			exit;
		}else{
			Flash::setMsg( 'Password wrong'); 
			header('Location: /user/login');
		}	
	}
//===============private =====================	
	private function verifyInputs($inputs){
		if ($inputs['password'] != $inputs['re_password']){
			//error	
			//header('Location: '.BASE_URL.'user/add');
			return false;
		}
		//not allow all space 
		trim($inputs['user_name']);
		trim($inputs['nickname']);
		if (empty($inputs['user']) && empty($inputs['user_name'])){
			//error 
			//header('Location: '.BASE_URL.'user/add');
			return false;
		}
		return true;
	}
	private function requireAdmin(){
		global $s_user;
		if ($s_user != null ){
			if ($s_user->isAdmin())
				return;	
		}
		FlashMessage::setMsg('Invalid Path');
		header('Location: /');
		exit;

	}	
}
