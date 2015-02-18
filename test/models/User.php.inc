<?php
	
	class User extends ActiveRecord{
		static protected  $s_table = 'users';
		static protected $s_field = array('user_name','nickname','password','user_levels_id');
		protected function initField(){
			
									
			$this->m_field=array_combine(static::$s_field, array_fill(0, count(static::$s_field), ''));
			$this->m_field['user_levels_id']=0;
		
		}
		
		
	}


?>