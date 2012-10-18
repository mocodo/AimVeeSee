<?php

if (isset($_SESSION[ID.'_user'])){
	$user = $_SESSION[ID.'_user'];
}

if(isAjax()){
	exit(0);
}

include('./views/header.php');
include('./views/home.php');
include('./views/footer.php');

?>