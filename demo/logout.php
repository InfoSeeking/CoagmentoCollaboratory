<?php
	session_start();
	require_once('../core/Session.class.php');
	require_once('../core/Action.class.php');
	//require_once('core/Util.class.php');
	
	if (Session::getInstance()->isSessionActive()) 
	{
			Session::destroySession();
			//Save action
			$localDate = $_POST['clientDate'];
			$localTime = $_POST['clientTime'];
			$localTimeStamp = $_POST['clientTimestamp'];
			$userName = Session::getInstance()->userName;
			$a = new Action("logout", $userName);
			$a->setLocalDate($localDate);
			$a->setLocalTime($localTime);
			$a->setLocalTimestamp($localTimeStamp);
			$a->save();
	}
	
	header("Location: index.php");
	
?>
