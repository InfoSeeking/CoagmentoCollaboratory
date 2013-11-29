<?php
	require_once('../core/SessionProgress.class.php');
	/*
	This test will move the user to the next sessionprogress and then the previous sessionprogress or vice versa depending if next/previous sessionprogresss exist.
	It will move from where they last left off (their most recent entry in the session_progress table)
	*/
	function printState($i, $sessionprogress){
		echo "<h4>Step " . $i . "</h4>";
		$p = $sessionprogress->getPreviousSessionProgress();
		if(!$p){
			$p = "<NULL>";
		}
		echo "<p>Previous Stage ID: " . $p . "</p>";

		$c = $sessionprogress->getCurrentSessionProgress();
		echo "<p>Current Stage ID: " . $c . "</p>";

		$n = $sessionprogress->getNextSessionProgress();
		if(!$n){
			$n = "<NULL>";
		}
		echo "<p>Next Stage ID: " . $n . "</p>";
	}

	$uid = 2;
	$pid = 1;
	$sessionprogress = SessionProgress::retrieve($pid ,$uid);
	if($sessionprogress == NULL){
		printf("Could not retrieve stage for userID=$uid and projectID=$pid<br/>");
		printf("Creating new initial progress");
		SessionProgress::addInitialProgress($pid, $uid);
		$sessionprogress = SessionProgress::retrieve($pid ,$uid);
	}
	
	printState(1, $sessionprogress);
	if($sessionprogress->getNextSessionProgress() != null){
		echo "<h3>Moving to next stage </h3>";
		$sessionprogress = $sessionprogress->moveToNextSessionProgress();
		printState(2, $sessionprogress);
		echo "<h3>Moving to previous stage </h3>";
		$sessionprogress = $sessionprogress->moveToPreviousSessionProgress();
		printState(3, $sessionprogress);
	}
	else if($sessionprogress->getPreviousSessionProgress() != null){
		echo "<h3>Moving to previous stage </h3>";
		$sessionprogress = $sessionprogress->moveToPreviousSessionProgress();
		printState(2, $sessionprogress);
		echo "<h3>Moving to next stage </h3>";
		$sessionprogress = $sessionprogress->moveToNextSessionProgress();
		printState(3, $sessionprogress);
	}
	
?>