
<?php
	session_start();
	require_once('../core/Connection.class.php');
	require_once('../core/Base.class.php');
	require_once('../core/Action.class.php');
	require_once('../core/Util.class.php');
	require_once("utilityFunctions.php");

if (Base::getInstance()->isSessionActive())
{
	$localTime = $_GET['localTime'];
	$localDate = $_GET['localDate'];
	$localTimestamp = $_GET['localTimestamp'];
	
	$base = new Base();
	
	$url = $_GET['URL'];
	$title = htmlspecialchars($_GET['title']);
	$snippet = addslashes($_GET['snippet']);
	$title = str_replace(" - Mozilla Firefox","",$title);
	
	$snippet = stripslashes($snippet);
	$snippet = stripslashes($snippet);
	$snippetValue = str_replace("\"","&quote;",$snippet);
	$snippet = str_replace("&quote;", "\"", $snippet);
	$snippet = str_replace("'", "\\'", $snippet);
	
	$projectID = $base->getProjectID();
	$userID = $base->getUserID();
	$time = $base->getTime();
	$date = $base->getDate();
	$timestamp = $base->getTimestamp();
	$stageID = $base->getStageID();
	$questionID = $base->getQuestionID();
		
	$query = "INSERT INTO snippets (userID, projectID, stageID, questionID, url, title, snippet, timestamp, date, time, `localTimestamp`, `localDate`, `localTime`, type)
	 		                VALUES('$userID','$projectID','$stageID', '$questionID','$url','$title','$snippet','$timestamp','$date','$time','$localTimestamp','$localDate','$localTime','text')";
	
	$connection = Connection::getInstance();			
	$results = $connection->commit($query);
	$snippetID = $connection->getLastID();
		
	$action = new Action('snippet',$snippetID);
	$action->setBase($base);
	$action->setLocalTimestamp($localTimestamp);
	$action->setLocalTime($localTime);
	$action->setLocalDate($localDate);
	$action->save();
}			
?>