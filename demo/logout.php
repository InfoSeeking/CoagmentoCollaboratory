<?php
	session_start();
	require_once('../core/Session.class.php');
	//require_once('core/Util.class.php');
	
	if (Session::getInstance()->isSessionActive()) 
	{
			Session::destroySession();
			//Save action
			//$base = new Base();
			//Util::getInstance()->saveAction('logout',0,$base);
	}
	
	header("Location: index.php");
	
?>
