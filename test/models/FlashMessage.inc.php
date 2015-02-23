<?php

	class FlashMessage{

		static public function setMsg($msg){
			$_SESSION['f_msg']=$msg;

		}
		static public function display($custom=false){
			if (!isset($_SESSION['f_msg'])) 
				return;

			$msg = $_SESSION['f_msg'];
			unset($_SESSION['f_msg']);
			if (!$custom )
				echo '<div id="flash_message" >'.$msg.' </div>';
			return $msg;
		}

		static public function cleanUp (){
			if (isset($_SESSION['f_msg'])){
				unset($_SESSION['f_msg']);
			}

		}
	}
?>
