<?php
//include=======================
require_once ('route/user_route.inc.php');

require_once('route/general_route.inc.php');

//===================get =======================
	if ($_SERVER['REQUEST_METHOD'] == 'GET'){

		if (isset($_GET['Control'])){
			
			switch ($_GET['Control']) {
				case 'user':
					userGetRoute();
			
					break;
				default:
					generalGetRoute();
					break;
				
			
			}
		}
		else {
			generalGetRoute();
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

?>
