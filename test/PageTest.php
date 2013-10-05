<?php
	require_once('../core/Page.class.php');
	
	$newPage = new Page();
	$newPage->setTitle("Page Title");
	
	echo "Inserting a new page into the database <br/>";
	$resultingID = $newPage->save();
	echo "PageID: ".$resultingID."<br/><br/>";
	
	echo "Retrieving same page from database using pageID</br>";
	$retrievedPage = Page::retrieve($resultingID);
	
	if ($retrievedPage!=NULL)
	{
		echo $retrievedPage . "<br/>";
		$retrievedPage->setQuery("This is an updated query");
		$retrievedPage->save();
		echo "Retrieved page changed and saved<br/>";
		Page::delete($resultingID);
		echo "Page deleted<br/>";
	}
	else
		echo "Could not find page";	
?>