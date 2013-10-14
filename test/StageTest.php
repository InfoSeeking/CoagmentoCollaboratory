<?php
	require_once('../core/Stage.class.php');
	
	$stage = Stage::retrieve(1,1);
	if($stage == NULL){
		die("Could not retrieve stage<br/>");
	}
	
	
	echo "Current stage ID " . $stage->getCurrentStage() . "<br/>";
	echo "Next stage ID " . $stage->getNextStage() . "<br/>";
	echo "Moving to next stage<br/>";
	$stage = $stage->moveToNextStage(TRUE);
	echo "Current stage " . $stage->getCurrentStage() . "<br/>";
	echo "Previous stage " . $stage->getPreviousStage() . "<br/>";
	echo "Moving to previous stage<br/>";
	$stage = $stage->moveToPreviousStage();
	
?>