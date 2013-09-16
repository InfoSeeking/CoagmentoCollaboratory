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
		echo $retrievedPage;
	}
	else
		echo "Could not find page";	
?>