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
	
	if (!($_GET['action']==""))
	{
		$actionVal = $_GET['action'];		
		$action = new Action($actionVal,0); //add later the ID of the tab
		$action->setBase($base);
		$action->setLocalTimestamp($localTimestamp);
		$action->setLocalTime($localTime);
		$action->setLocalDate($localDate);
		$action->save();		
	}
		
	$originalURL = $_GET['URL'];
	
	//When implementing full version verify membership
	if ($originalURL!=$_SESSION['CSpace_lastURL'])
	{	
		$title = $_GET['title'];
		$title = str_replace(" - Mozilla Firefox","",$title);
		$url = $originalURL;
	
		// Parse the URL to extract the source
		$url = str_replace("http://", "", $url); // Remove 'http://' from the reference
		$url = str_replace("com/", "com.", $url);
		$url = str_replace("org/", "org.", $url);
		$url = str_replace("edu/", "edu.", $url);
		$url = str_replace("gov/", "gov.", $url);
		$url = str_replace("us/", "us.", $url);
		$url = str_replace("ca/", "ca.", $url);
		$url = str_replace("uk/", "uk", $url);
		$url = str_replace("es/", "es.", $url);
		$url = str_replace("net/", "net.", $url);

		$entry = explode(".", $url);
		$i = 0;
		$isWebsite = 0;
		
		while (($entry[$i]) && ($isWebsite == 0))
		{
			$entry[$i] = strtolower($entry[$i]);
			if (($entry[$i] == "com") || ($entry[$i] == "edu") || ($entry[$i] == "org") || ($entry[$i] == "gov") || ($entry[$i] == "info") || ($entry[$i] == "us") || ($entry[$i] == "ca") || ($entry[$i] == "es") || ($entry[$i] == "uk") || ($entry[$i] == "net"))
			{
				$isWebsite = 1;
				$site = $entry[$i-1];
				$domain = $entry[$i];
			}
			$i++;
		} 

		// Extract the query if there is any
		$queryString = extractQuery($originalURL);
			
		$_SESSION['CSpace_lastURL'] = $originalURL;
		
		//$base = new Base();
		$projectID = $base->getProjectID();
		$userID = $base->getUserID();
		$time = $base->getTime();
		$date = $base->getDate();
		$timestamp = $base->getTimestamp();
		$stageID = $base->getStageID();
		$questionID = $base->getQuestionID();
		
		$query = "INSERT INTO pages (userID, projectID, stageID, questionID, url, title, source, query, timestamp, date, time, `localTimestamp`, `localDate`, `localTime`) 
				              VALUES('$userID','$projectID','$stageID','$questionID','$originalURL','$title','$site','$queryString','$timestamp','$date','$time','$localTimestamp','$localDate','$localTime')";
		
		$connection = Connection::getInstance();			
		$results = $connection->commit($query);
		$pageID = $connection->getLastID();
		
		$action = new Action('page',$pageID);
		$action->setBase($base);
		$action->setLocalTimestamp($localTimestamp);
		$action->setLocalTime($localTime);
		$action->setLocalDate($localDate);
		$action->save();		
				
		if ($queryString)
		{			
			$resultsPage = urlencode($originalURL);
			$topResults = file_get_contents($resultsPage);
			$query = "INSERT INTO queries (userID, projectID, stageID, questionID, query, source, url, title, topResults, timestamp, date, time, `localTimestamp`, `localDate`, `localTime`)  
			                       VALUES ('$userID','$projectID','$stageID','$questionID','$queryString','$site','$originalURL','$title','$topResults','$timestamp','$date','$time','$localTimestamp','$localDate','$localTime')";

			$connection = Connection::getInstance();			
			$results = $connection->commit($query);
			$queryID = $connection->getLastID();
		
			$contents = file_get_contents($originalURL);
			//$fileName = "/home1/shahonli/projects/Coagmento/data/study2_queries_results/". $queryID . ".qr";
			//$fout = fopen($fileName, 'w');
			//fwrite($fout, $contents);
			//fwrite($fout, "\n");
			//fclose($fout);
			
			$action->setAction('query');
			$action->setValue($queryID);
			$action->save();
		}										
	}
}
?>
