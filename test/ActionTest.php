<?php
	require_once('../core/Action.class.php');
	
	$newAction = new Action("Test Action", "Test Action Value");

	
	echo "Inserting a new action into the database <br/>";
	$resultingID = $newAction->save();
	echo "ActionID: ".$resultingID."<br/><br/>";
	
	echo "Retrieving same query from database using actionID</br>";
	$retrievedAction = Action::retrieve($resultingID);
	
	if ($retrievedAction!=NULL)
	{
		echo $retrievedAction;
	}
	else
		echo "Could not find action";	
?>