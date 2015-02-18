<?php

class UserController {
	
	public function index(){
				
		$users = User::All(false,'UserLevel');
		if ($users==false){
			echo '<p> error </p>';
			return ;
		}
		
		//print_r($users);
		
		require(BASE_URI.'views/user/user_index.html.inc');
		
	}
	public function add(){
		$grades = UserLevel::All();
		
		require(BASE_URI.'views/user/add.html.inc');
	
	}
	public function edit($id){
		
		if (!ctype_digit($id)){
			return;
		}
		$grades = UserLevel::All();
		
		require(BASE_URI.'views/user/edit.html.inc');
	
	}
	
	
	//===============post=================
	public function create(){
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
			
			
			unset($user);
			header('Location: http://'.USER_URL."user");
			exit;
		}
		unset($user);
	}
	public function update($id){
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
	
	private function verifyInputs($inputs){
		if ($inputs['password'] != $inputs['re_password']){
			//error	
			//header('Location: '.BASE_URL.'user/add');
			return false;
		}
		//not allow space at ^ $
		trim($inputs['user_name']);
		trim($inputs['nickname']);
		if (empty($inputs['user']) && empty($inputs['user_name'])){
			//error 
			//header('Location: '.BASE_URL.'user/add');
			return false;
		}
		return true;
	}
	
}
