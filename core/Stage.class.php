<?php
require_once('Connection.class.php');
require_once('Base.class.php');
require_once('Action.class.php');

class Stage extends Base
{
	protected $stageID;
	protected $currentPage;
	protected $maxTime;
	protected $maxQuestion;
	protected $maxLoops;
	protected $currentLoops;
	protected $allowBrowsing;
	protected $previoiusStage; //Stage object
	protected $nextStage; //Stage object
	protected $previousStartTimestamp;
	protected $previousMaxTime;
	
	public function __construct(){
		$this->inDatabase = false;
	}

	public static function retrieve($projectID, $userID) 
	{
		$params = Array(":projectID" => $projectID, ":userID" => $userID);
		$query = "SELECT stageID, page, maxTime, maxTimeQuestion, maxLoops, allowBrowsing, (SELECT count(*) FROM session_progress a WHERE a.stageID = b.stageID and projectID = :projectID and userID = :userID ) currentLoops
				  FROM session_stages b
				  WHERE status = 1
				    AND stageID = (SELECT stageID
				  				   FROM session_progress a 
				  				   WHERE projectID = :projectID
				  				   	 AND userID = :userID
				  				   	 AND progressID = (SELECT max(progressID)
                                                         FROM session_progress a 
                                                        WHERE projectID = :projectID
                                                          AND userID = :userID
                                                       )   			  				   
				  				   )";

		$connection = Connection::getInstance();
		$results = $connection->execute($query, $params);
		$record = $results->fetch(PDO::FETCH_ASSOC);
		
		if ($record)
		{
			$stage = new Stage();
			$stage->stageID = $record['stageID'];
			$stage->currentPage = $record['page'];
			$stage->maxTime = $record['maxTime'];
			$stage->maxTimeQuestion = $record['maxTimeQuestion'];
			$stage->maxLoops = $record['maxLoops'];
			$stage->currentLoops = $record['currentLoops'];
			$stage->allowBrowsing = $record['allowBrowsing'];
			$stage->populatePreviousStage();
			$stage->populateNextStage();
			//$stage->previousStartTimestamp = $stage->getPreviousStartTimestamp();
			//$stage->previousMaxTime = $stage->getPreviousMaxTime();
			$stage->inDatabase = true;
		}
		else 
		{
			return null;
		}
	}
  	
  	//changes session_progress, returns a new Stage object
	public function moveToNextStage()
	{
		$data = $this->getNextStageData();
		$this->currentPage = $data['page'];	//First get Page, then stageID
		$this->stageID = $data['stageID'];	  //Then get ID next page
		$this->maxTime = $data['maxTime']; //Get Max Time
		$this->maxTimeQuestion = $data['maxTimeQuestion']; //Get Max Time Question
		$this->maxLoops = $data['maxLoops']; //Get Max Loops
		$this->currentLoops = $data['currentLoops']; //Get Current Loops
		$this->allowBrowsing = $data['allowBrowsing'];		
		$this->previousStartTimestamp = $this->getPreviousStartTimestamp();
		$this->previousMaxTime = $this->getPreviousMaxTime();
											
		if ($this->currentPage<>'')
		{
			//Create action before setting the session variable to preserve the previous stage in the log
			$action = new Action('Next Stage: '.$this->currentPage,$this->stageID);
			
			//SAVING THE NEW STAGE IN SESSION VARIABLE
			$this->setStageID($this->stageID);	
			$this->setPage($this->currentPage);
			$this->setMaxTime($this->maxTime);	
			$this->setMaxTimeQuestion($this->maxTimeQuestion);
			$this->setMaxLoops($this->maxLoops);
			$this->setCurrentLoops($this->currentLoops);
			$this->setAllowBrowsing($this->allowBrowsing);
			$this->setPreviousStartTimestamp($this->previousStartTimestamp);
			$this->setPreviousMaxTime($this->previousMaxTime);
			
			$projectID = $action->getProjectID();
			$userID = $action->getUserID();
			$time = $action->getTime();
			$date = $action->getDate();
			$timestamp = $action->getTimestamp();
			$stageID = $action->getStageID();	//It keeps the previous stage ID		
			$connection = Connection::getInstance();
			$query = "INSERT INTO session_progress(projectID, userID, stageID, date, time, timestamp) 
			                               VALUES ('$projectID','$userID','$this->stageID','$date','$time','$timestamp')";	
		
			$results = $connection->commit($query);	
			$action->save();
			
			return true;
		}
		
		return false;
	}
	
	public function moveToPreviousStage()
	{
		$data = $this->getPreviousStageData();
		$this->currentPage = $data['page'];	//First get Page, then stageID
		$this->stageID = $data['stageID'];	  //Then get ID next page
		$this->maxTime = $data['maxTime']; //Get Max Time
		$this->maxTimeQuestion = $data['maxTimeQuestion']; //Get Max Time Question
		$this->maxLoops = $data['maxLoops']; //Get Max Loops
		$this->currentLoops = $data['currentLoops']; //Get Current Loops
		$this->allowBrowsing = $data['allowBrowsing'];
										
		if ($this->currentPage<>'')
		{
			//Create action before setting the session variable to preserve the previous stage in the log
			$action = new Action('Previous Stage: '.$this->currentPage,$this->stageID);
			
			//SAVING THE NEW STAGE IN SESSION VARIABLE
			$this->setStageID($this->stageID);	
			$this->setPage($this->currentPage);
			$this->setMaxTime($this->maxTime);	
			$this->setMaxTimeQuestion($this->maxTimeQuestion);
			$this->setMaxLoops($this->maxLoops);
			$this->setAllowBrowsing($this->allowBrowsing);
							
			$projectID = $action->getProjectID();
			$userID = $action->getUserID();
			$time = $action->getTime();
			$date = $action->getDate();
			$timestamp = $action->getTimestamp();
			$stageID = $action->getStageID();	//It keeps the previous stage ID		
			$connection = Connection::getInstance();
			$query = "INSERT INTO session_progress(projectID, userID, stageID, date, time, timestamp) 
			                               VALUES ('$projectID','$userID','$this->stageID','$date','$time','$timestamp')";	
		
			$results = $connection->commit($query);	
			$action->save();
			
			return true;
		}
		
		return false;
	}
	
	//sets the next stage to another Stage object
	public function populateNextStage()
	{			
		$connection = Connection::getInstance();
		$params = Array(":stageID" => $this->stageID, "userID" => $this->userID, "projectID" => $this->projectID);
		$query = "SELECT stageID, page, maxTime, maxTimeQuestion, maxLoops, allowBrowsing, (SELECT count(*) FROM session_progress a WHERE a.stageID = b.stageID  AND userID = :userID AND projectID = :projectID) currentLoops 
				    FROM session_stages b
				    WHERE stageID>:stageID AND status = '1' order by stageID LIMIT 1";
		$results = $connection->execute($query, $params);
		$record = $results->fetch(PDO::FETCH_ASSOC);
		if($record){
			$this->nextStage = new Stage();
			$this->nextStage->stageID = $record['stageID'];
			$this->nextStage->currentPage = $record['page'];
			$this->nextStage->maxTime = $record['maxTime'];
			$this->nextStage->maxTimeQuestion = $record['maxTimeQuestion'];
			$this->nextStage->maxLoops = $record['maxLoops'];
			$this->nextStage->currentLoops = $record['currentLoops'];
			$this->nextStage->allowBrowsing = $record['allowBrowsing'];
			//do not populate it's next/previous stage, this would create an infinite loop
		}
	}

	//getters for next stage
	public function getNextStage(){return $this->nextStage->stageID;}
	public function getNextPage(){return $this->nextStage->page;}
	public function getNextMaxTime(){return $this->nextStage->maxTime;}
	public function getNextMaxTimeQuestion(){return $this->nextStage->maxTimeQuestion;}
	public function getNextMaxLoops(){return $this->nextStage->maxLoops;}
	public function getNextCurrentLoops(){return $this->nextStage->currentLoops;}
	public function getNextAllowBrowsing(){return $this->nextStage->allowBrowsing;}
	
	//GETTERS PREVIOUS STAGE
	public function populatePreviousStage()
	{	
		$connection = Connection::getInstance();
		$params = Array(":stageID" => $this->stageID, "userID" => $this->userID, "projectID" => $this->projectID);
		$query = "SELECT stageID, page, maxTime, maxTimeQuestion, maxLoops, allowBrowsing, (SELECT count(*) FROM session_progress a WHERE a.stageID = b.stageID  AND userID = :userID AND projectID = :projectID) currentLoops 
				    FROM session_stages b
				    WHERE stageID<:stageID AND status = '1' order by stageID DESC LIMIT 1";
		$results = $connection->execute($query, $params);
		$record = $results->fetch(PDO::FETCH_ASSOC);
		if($record){
			$this->previousStage = new Stage();
			$this->previousStage->stageID = $record['stageID'];
			$this->previousStage->currentPage = $record['page'];
			$this->previousStage->maxTime = $record['maxTime'];
			$this->previousStage->maxTimeQuestion = $record['maxTimeQuestion'];
			$this->previousStage->maxLoops = $record['maxLoops'];
			$this->previousStage->currentLoops = $record['currentLoops'];
			$this->previousStage->allowBrowsing = $record['allowBrowsing'];
			//do not populate it's next/previous stage, this would create an infinite loop
		}
	}
	//getters for previous stage
	public function getPreviousStage(){return $this->previousStage->stageID;}
	public function getPreviousPage(){return $this->previousStage->page;}
	public function getPreviousMaxTime(){return $this->previousStage->maxTime;}
	public function getPreviousMaxTimeQuestion(){return $this->previousStage->maxTimeQuestion;}
	public function getPreviousMaxLoops(){return $this->previousStage->maxLoops;
	public function getPreviousCurrentLoops(){return $this->previousStage->currentLoops;}
	public function getPreviousAllowBrowsing(){return $this->previousStage->allowBrowsing;}	
	public function getPreviousStartTimestamp(){return $this->previousStage->timestamp;}


	//getters for this stage
	public function getCurrentStage(){return $this->stageID;}
	public function getCurrentPage(){return $this->currentPage;}
	public function getMaxTime(){return $this->maxTime;}
	public function getMaxTimeQuestion(){return $this->maxTimeQuestion;}
	public function getAllowBrowsing(){return $this->allowBrowsing;}

	//SETTERS
	public function setPage($val){$this->page = $val;}
	public function setMaxTime($val){$this->maxTime = $val;}
	public function setMaxTimeQuestion($val){$this->maxTimeQuestion = $val;}
	public function setMaxLoops($val){$this->maxLoops = $val;}
	public function setCurrentLoops($val){$this->currentLoops = $val;}
	public function setAllowBrowsing($val){$this->allowBrowsing = $val;}
	public function setPreviousStartTimestamp($val){$this->previousStartTimestamp = $val;}
	public function setPreviousMaxTime($val){$this->previousMaxTime = $val;}
}
?>