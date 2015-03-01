<?php
class BaseController {
	protected function requireAdmin($custom=false){
		global $s_user;
		if ($s_user != null ){
			if ($s_user->isAdmin())
				return true;	
		}
		if (!$custom){
			FlashMessage::setMsg('Invalid Path');
			header('Location: /');
			exit;
		}
		return false;
	}
	protected function requireUser($custom=false){
		global $s_user;
		if ($s_user!=null){
			if($s_user->isNormal())
				return true;
		}
		if (!$custom){
			FlashMessage::setMsg('Need Login');
			header('Location: /');
			exit;
		}
		return false;
	}
}