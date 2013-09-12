<?php
	require_once('../core/User.class.php');
	
	$userName = "user12";
	$password = "passUser1";
	$password = sha1($password);
	$status = 1;
	
	$newUser = new User();
	$newUser->setUserName($userName);
	$newUser->setPassword($password);	
	$newUser->setStatus($status);	
	
	/*try
	{*/	
		echo "Inserting a new user into the database <br/>";
		$result = $newUser->save();
		echo "UserID: ".$result."<br/><br/>";
		
		echo "Retrieving same user from database using username and password </br>";
		$userAuth = User::login($userName,$password);
		
		if ($userAuth!=NULL)
		{
			echo $userAuth;
		}
		else
			echo "Username and password do not match or user does not exist";		
	/*}
	catch(CoagmentoException $e)
	{
		echo "An unexcepted error has occurred Code".$e->getCode();
	}*/
	
?>