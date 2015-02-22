<?php
	class Session {
	
		public static function destroy(){

			$_SESSION= array();
			session.destroy();
		}	
	}


?>
