<?php
//===========================
	function noteGetRoute(){
		
		$controller = new NoteController();
		
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
	
//========================================	
	function notePostRoute(){
		$controller = new NoteController();
		if (!isset($_POST['Action'])){
			unset($controller);
			header('Location: /');
			exit;

		}	
		switch ($_POST['Action']){
			case 'create':
				$controller->create();
				break;
			default:
				break;
		}
		unset ($controller);
		header('Location: /');	
		exit;
	}
?>
