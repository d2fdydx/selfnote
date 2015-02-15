<?php
//===================get =======================
	if ($_SERVER['REQUEST_METHOD'] == 'GET'){
		if (isset($_GET['Control'])){
			switch ($_GET['Control']) {
				case 'user':
					userGetRoute();
			
					break;
				default:
					break;
				
			
			}
		}
	
		
	
	} //===================Post==========================
	else if ($_SERVER['REQUEST_METHOD'] == 'POST'){
		if (isset ($_POST['Control'])){
			switch ($_POST['Control']) {
				case 'user':
					userPostRoute();
			
					break;
				default:
					break;
				
			
			}
		}
	
	
	}
	
// -----------------function -----------------------	

//===========USER================
	function userGetRoute(){
		
		$controller = new UserController();
		switch ($_GET['Action']){
			case 'add':
				$controller->add();
			
				break;
			default:
				$controller->index();
				
				break;
		}
	
		unset ($controller);
	}
	
	function userPostRoute(){
		
		$controller = new UserController();
		switch ($_POST['Action']){
			case 'add':
				$controller->create();
			
				break;
			default:
				break;
		}
	
		unset ($controller);
	}
	
	

?>