<?php
	require_once('../core/Bookmark.class.php');
	
	$newBookmark = new Bookmark();
	$newBookmark->setUrl("http://google.com");
	
	echo "Inserting a new bookmark into the database <br/>";
	$resultingID = $newBookmark->save();
	echo "BookmarkID: ".$resultingID."<br/><br/>";
	
	echo "Retrieving same bookmark from database using bookmarkID</br>";
	$retrievedBookmark = Bookmark::retrieve($resultingID);
	
	if ($retrievedBookmark!=NULL)
	{
		echo $retrievedBookmark;
	}
	else
		echo "Could not find bookmark";	
?>