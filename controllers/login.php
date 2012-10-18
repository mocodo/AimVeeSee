<?php

/*
 * Must create a GetAttemptCount($value) function
 * You might create a DOA or a Model for users including a login($value, $value) method
 * You might also create the methods getAttemptCount($value), addConnectionAttempt($value) and resetConnectionAttempt($value)
 */
function connect($username, $password){
	if(getAttemptCount($username) >= LOGIN_THRESHOLD){
		addError('general', 'See you tomorrow');	
	}
	else{
		$password = SALT_PRE.$password.SALT_POST;
		$user = login($username, $password);
		
		if($user == null){
			addConnectionAttempt($username);
			addError('general', 'Access denied');
		}
		else{
			resetConnectionAttempt($user->id);
			Log::addMessage(Log::INFO, 'User '.$user->login.' has log into the system.');

			$expire = time() + COOKIE_TIMEOUT;

			// Automatic connection
			setcookie(ID.'_username', $username, $expire, '/');
			setcookie(ID.'_password', $password, $expire, '/');

			// Redirection
			$_SESSION[ID.'_user'] = $user;
			redirect('admin');
		}
	}		
}

if(isset($_COOKIE[ID.'_username'], $_COOKIE[ID.'_password'])){
	$username = parseString($_COOKIE[ID.'_username']);
	$password = $_COOKIE[ID.'_password'];

	try{
		connect($username, $password);
	}
	catch(Exception $exception){
		Log::addException(Log::ERROR, $exception);
		error($exception);
	}
}

if(isset($_SESSION[ID . '_user'])){
	redirect('admin');
}

$action = getAction();
if($action == 'submit'){

	$username = parseString(getParameter('username'));
	$password = getParameter('password');

	if(empty($username) || empty($password)){
		addError('general', 'All the fields are mandatory');
	}
	else{

		try{
			connect($username, $password);
		}
		catch(Exception $exception){
			Log::addException(Log::ERROR, $exception);
			error($exception);
		}
	}
}

$username = getParameter('username');

include('./views/header.php');
include('./views/login.php');
include('./views/footer.php');

?>
