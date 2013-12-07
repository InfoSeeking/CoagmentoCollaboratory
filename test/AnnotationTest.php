<?php
	require_once('../core/Annotation.class.php');
	
	$newAnnotation = new Annotation();
	$newAnnotation->setUrl("http://google.com");
	$newAnnotation->setAnnotation("This is a test");
	
	echo "Inserting a new annotation into the database <br/>";
	$resultingID = $newAnnotation->save();
	echo "AnnotationID: ".$resultingID."<br/><br/>";
	
	echo "Retrieving same annotation from database using annotationID</br>";
	$retrievedAnnotation = Annotation::retrieve($resultingID);
	
	if ($retrievedAnnotation!=NULL)
	{
		echo $retrievedAnnotation;
	}
	else
		echo "Could not find annotation";	
?>