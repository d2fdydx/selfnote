<?php
$DB_TYPE='sqlite';

switch($DB_TYPE){
	case 'sqlite':
		define('DATABASE','sqlite:'.BASE_URI.'db/db.sqlite');
		break;
		
	case 'mysql':
		define('DATABASE','mysql:dbname=test;host=localhost');
		define('DB_USER','root');
		define('DB_PWD','12345');
		break;
	default:
		define('DATABASE','sqlite:'.BASE_URI.'db/db.sqlite');
		break;
}

?>