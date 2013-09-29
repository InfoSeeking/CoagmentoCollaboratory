<?php
	session_start();
 	require_once('../core/User.class.php');
 	require_once('../core/Snippet.class.php');
	require_once('../core/Session.class.php');
	if(!isset($_POST['action'])){die("No action");}
	$s = Session::getInstance();
	if(!$s->isSessionActive()){
		die("No session active");
	}
	$userID = $s->userID;
	$action = $_POST['action'];
	$localDate = $_POST['clientDate'];
	$localTime = $_POST['clientTime'];
	$localTimeStamp = $_POST['clientTimestamp'];
	switch($action){
		case "save":
			$newSnippet = new Snippet();
			$newSnippet->setLocalDate($localDate);
			$newSnippet->setLocalTimestamp($localTimeStamp);
			$newSnippet->setLocalTime($localTime);
			$newSnippet->setSnippet($_POST['content']);
			$newSnippet->setUserID($userID);
			$newSnippet->save();
			header("Location: index.php");
		break;
		case "update":

		break;
		case "delete":

		break;
	}
?>