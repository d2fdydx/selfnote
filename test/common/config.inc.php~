<?php
//===========config =============
define('BASE_URI',"{$_SERVER['DOCUMENT_ROOT']}/test/");
define ('BASE_URL',"{$_SERVER['SERVER_NAME']}:1234/test/");
define ('USER_URL',"{$_SERVER['SERVER_NAME']}:1234/");
require_once(BASE_URI.'/se/db_config.inc');
//phpinfo();
spl_autoload_register('models_loader');
spl_autoload_register('controllers_loader');

session_start();
//==============================
$host = substr ($_SERVER['HTTP_HOST'],0,5);
if ( in_array($host, array('local','192.1', '127.0'))){
	$local=true;
}
else $local =false;

if ($local){
	$DEBUG = true;
	
	
}else {
	$DEBUG = false;
	

}

function my_error_handler($e_number, $e_message, $e_file, $e_line, $e_vars) {
	global $DEBUG;

	$message = "An error/warnging occurred in script '$e_file' on line $e_line: $e_message";
	$message .= print_r($e_vars,true);
	if ($DEBUG){
		echo " <div id='Error'> $message </div> ";
		debug_print_backtrace();
	}else {
	//==========do sth=======
	
	}
	
}
set_error_handler('my_error_handler');

function models_loader($class_name){
	if (file_exists(BASE_URI."models/$class_name.inc.php")){
		include_once(BASE_URI."models/$class_name.inc.php");
	}
}
function controllers_loader($class_name){
	if (file_exists(BASE_URI."controllers/$class_name.inc.php")){
		include_once(BASE_URI."controllers/$class_name.inc.php");
	}
	
}



//user
$s_user = User::getSessionUser();


//
?>
