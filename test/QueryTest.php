<?php
	require_once('../core/Query.class.php');
	
	$newQuery = new Query();
	$newQuery->setQuery("Test Query");
	$newQuery->setSource("google");
	$newQuery->setUrl("http://google.com");
	$newQuery->setTitle("Query Title");
	$newQuery->setTopResults("Top results");

	
	echo "Inserting a new query into the database <br/>";
	$resultingID = $newQuery->save();
	echo "QueryID: ".$resultingID."<br/><br/>";
	
	echo "Retrieving same query from database using queryID</br>";
	$retrievedQuery = Query::retrieve($resultingID);
	
	if ($retrievedQuery!=NULL)
	{
		echo $retrievedQuery;
	}
	else
		echo "Could not find query";	
?>