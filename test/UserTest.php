<?php
	require_once('../core/User.class.php');
	
	$userName = "test";
	$password = "123";
	$password = sha1($password);
	$status = 1;
	
	$newUser = new User();
	$newUser->setUserName($userName);
	$newUser->setPassword($password);	
	$newUser->setStatus($status);	
	
	
	echo "Inserting a new user into the database <br/>";
	$result = $newUser->save();
	if($result == -1){
		//user already exists
		echo "Cannot insert user, username already in database<br/>";
	}
	else{
		echo "UserID: ".$result."<br/><br/>";
	}
	
	echo "Retrieving same user from database using username and password </br>";
	$userAuth = User::login($userName,$password);
	
	if ($userAuth!=NULL)
	{
		echo $userAuth;
	}
	else{
		echo "Username and password do not match or user does not exist";
	}

?>