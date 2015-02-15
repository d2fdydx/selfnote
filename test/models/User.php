<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/test/models/ActiveRecord.php');
	class User extends ActiveRecord{
		static public $m_table = 'users';
		
		protected function set(){
			
			$this->m_field['name']="";
			
		
		}
		
		
	}


?>