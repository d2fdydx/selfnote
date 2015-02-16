<?php
$DB_TYPE='sqlite';

switch($DB_TYPE){
	case 'sqlite':
		define('DATABASE','sqlite:../db/db.sqlite');
		break;
		
	case 'mysql':
		break;
	default:
		define('DATABASE','sqlite:../db/db.sqlite');
		break;
}

?>