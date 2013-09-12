<?php
	require_once('../core/Project.class.php');
	
	$newProject = new Project();
	$newProject->setTitle("Test Project");
	$newProject->setDescription("This is a test project");
	$newProject->setStatus(1);
	
	echo "Inserting a new project into the database <br/>";
	$resultingID = $newProject->save();
	echo "ProjectID: ".$resultingID."<br/><br/>";
	
	echo "Retrieving same project from database using projectID </br>";
	$retrievedProject = Project::retrieve($resultingID);
	
	if ($retrievedProject!=NULL)
	{
		echo $retrievedProject;
	}
	else
		echo "Could not find project";	
?>