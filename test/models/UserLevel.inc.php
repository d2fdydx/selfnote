<?php
	
	class UserLevel extends ActiveRecord{
		static protected  $s_table = 'user_levels';
		static protected $s_field = array('name','grade');
		public static $s_admin = array(1); 
		public static $s_normal =array(0,1);
		protected function initField(){
			
									
			$this->m_field=array_combine(static::$s_field, array_fill(0, count(static::$s_field), ''));
		
		}
		
		
	}


?>
