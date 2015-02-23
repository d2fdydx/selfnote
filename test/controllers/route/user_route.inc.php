<?php
//===========USER================
	function userGetRoute(){
		
		$controller = new UserController();
		
		switch ($_GET['Action']){
			case 'add':
				$controller->add();
			
				break;
			case 'edit':
				if (!isset($_GET['id'])) {
					$controller->index();
					return;
				}
				$controller->edit($_GET['id']);
				break;
			case 'login':
				$controller->login();
				break;
			case 'logout':
				$controller ->logout();
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
			case 'delete':
				$controller->delete();
				break;
				
			case 'update':
				$controller->update($_POST['index']);
				break;
			case 'login':
				$controller->p_login();
			default:
				break;
		}
	
		unset ($controller);
	}
	
//========================================	
?>
