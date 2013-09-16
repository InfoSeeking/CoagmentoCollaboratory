<?php
	require_once('../core/Snippet.class.php');
	
	$newSnippet = new Snippet();
	$newSnippet->setUrl("http://google.com");
	$newSnippet->setSnippet("This is a test");
	
	echo "Inserting a new snippet into the database <br/>";
	$resultingID = $newSnippet->save();
	echo "SnippetID: ".$resultingID."<br/><br/>";
	
	echo "Retrieving same snippet from database using snippetID</br>";
	$retrievedSnippet = Snippet::retrieve($resultingID);
	
	if ($retrievedSnippet!=NULL)
	{
		echo $retrievedSnippet;
	}
	else
		echo "Could not find snippet";	
?>