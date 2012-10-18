<?php

if (!isset($_SESSION[ID.'_user'])){
	redirect('login');
}

$time = time() - 42000;
$_SESSION = array();

if(ini_get('session.use_cookies')){
	$params = session_get_cookie_params();
	setcookie(session_name(), '',
			$time, $params['path'], $params['domain'],
			$params['secure'], $params['httponly']);
}

$expire = time() - 3600;
setcookie(ID.'_username', '', $expire, '/');
setcookie(ID.'_password', '', $expire, '/');

session_destroy();

redirect('home');

?>
