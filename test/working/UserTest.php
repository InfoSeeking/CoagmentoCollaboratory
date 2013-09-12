<?php
	require_once('../core/User.class.php');
	
	$userName = "user16";
	$password = "last1";
	$password = sha1($password); //Try to use sha1, MD5 or other in the client side.
	
	$user = new User();
	if ($user->login($userName,$password))
		echo $user;
	else
		echo "Wrong user";

?>