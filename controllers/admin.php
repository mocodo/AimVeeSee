<?php

if(!isset($_SESSION[ID.'_user'])){
	redirect('home');
}

$user = $_SESSION[ID.'_user'];

if($user->profile != 'Administrator'){
	redirect('home');
}

if(isAjax()){
	exit(0);
}

include('./views/header.php');
include('./views/admin.php');
include('./views/footer.php');

?>