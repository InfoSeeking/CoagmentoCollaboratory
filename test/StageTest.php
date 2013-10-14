<?php
	require_once('../core/Stage.class.php');
	/*
	This test will move the user to the next stage and then the previous stage or vice versa depending if next/previous stages exist.
	It will move from where they last left off (their most recent entry in the session_progress table)
	*/
	function printState($i, $stage){
		echo "<h4>Step " . $i . "</h4>";
		$p = $stage->getPreviousStage();
		if(!$p){
			$p = "<NULL>";
		}
		echo "<p>Previous Stage ID: " . $p . "</p>";

		$c = $stage->getCurrentStage();
		echo "<p>Current Stage ID: " . $c . "</p>";

		$n = $stage->getNextStage();
		if(!$n){
			$n = "<NULL>";
		}
		echo "<p>Next Stage ID: " . $n . "</p>";
	}

	$uid = 1;
	$pid = 1;
	$stage = Stage::retrieve($pid ,$uid);
	if($stage == NULL){
		die("Could not retrieve stage for userID=$uid and projectID=$pid<br/>");
	}
	
	printState(1, $stage);
	if($stage->getNextStage() != null){
		echo "<h3>Moving to next stage</h3>";
		$stage = $stage->moveToNextStage();
		printState(2, $stage);
		echo "<h3>Moving to previous stage</h3>";
		$stage = $stage->moveToPreviousStage();
		printState(3, $stage);
	}
	else if($stage->getPreviousStage() != null){
		echo "<h3>Moving to previous stage</h3>";
		$stage = $stage->moveToPreviousStage();
		printState(2, $stage);
		echo "<h3>Moving to next stage</h3>";
		$stage = $stage->moveToNextStage();
		printState(3, $stage);
	}
	
?>