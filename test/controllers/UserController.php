<?php

class UserController {
	
	public function index(){
		
		include_once (BASE_URI.'models/User.php');
		$users = User::All();
		//print_r($users);
		
		require(BASE_URI.'views/user/user_index.html');
		
	}
	public function add(){
		require(BASE_URI.'views/user/add.html');
	
	}
	public function create(){
		$name = htmlentities($_POST['f_name']);
		$user = new User(compact('name'));
		echo '<h1> adding </h1>';
		if ($user->save()==true){
			$msg ="Successfully Added";
			$msg = urlencode($msg);
			unset($user);
			header('Location: http://'.USER_URL."user&notice=$msg");
			exit;
		}
		unset($user);
	}
	
	
}
