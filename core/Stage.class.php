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
	protected $previousStage; //Stage object
	protected $nextStage; //Stage object
	protected $previousStartTimestamp;
	protected $previousMaxTime;
	
	public function __construct(){
		$this->inDatabase = false;
	}
	/**
	* Returns the stage which the user is at in the specified project.
	* @param int $projectID
	* @param int $userID
	* @return Stage
	*/
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
			$stage->projectID = $projectID;
			$stage->userID = $userID;
			$stage->populatePreviousStage();
			$stage->populateNextStage();
			$stage->inDatabase = true;
			return $stage;
		}
		else 
		{
			return null;
		}
	}
  	
  	/**
  	* Returns the nextStage variable, but initializes the nextStage with it's own nextStage and previousStage properties (in a linked list fashion).
  	* Note that this function does not change the current object, but instead readies the next stage object and returns that.
  	* @param boolean $logAction if this is true, it will log an action saying the user moved to the next stage
  	* @return Stage this is next stage which the nextStage property points
  	*/
	public function moveToNextStage($logAction=FALSE)
	{
		if($this->nextStage == null){
			return null;
		}
		$this->nextStage->previousStage = $this;
		$this->nextStage->populateNextStage();
		//Create action before setting the session variable to preserve the previous stage in the log
		if($logAction){
			$action = new Action('Next Stage: '.$this->currentPage . " to " . $this->nextStage->currentPage,$this->nextStage->stageID);
			$action->setUserID($this->userID);
			$action->setProjectID($this->projectID);
			$action->setStageID($this->stageID);
			$action->save();
		}

		$this->updateTimes();
		$params = array(
			":projectID" => $this->projectID,
			":userID" => $this->userID,
			":date" => $this->date,
			":time" => $this->time,
			":stageID" => $this->nextStage->stageID
			);
		$connection = Connection::getInstance();
		$query = "INSERT INTO session_progress(`projectID`, `userID`, `stageID`, `date`, `time`) VALUES (:projectID,:userID, :stageID,:date,:time)";	
		$results = $connection->execute($query, $params);	
		return $this->nextStage;
	}
	/**
  	* Similar to moveToNextStage, returns the previous stage with it's next and previous stage pointers initialized
  	* @param boolean $logAction if this is true, it will log an action saying the user moved to the previous stage
  	* @return Stage this is previous stage which the previousStage property points
  	*/
	public function moveToPreviousStage($logAction=FALSE)
	{
		if($this->previousStage == null){
			return null;
		}
		$this->previousStage->nextStage = $this;
		$this->previousStage->populatePreviousStage();
		//Create action before setting the session variable to preserve the previous stage in the log
		if($logAction){
			$action = new Action('Previous Stage: '.$this->currentPage . " to " . $this->previousStage->currentPage,$this->previousStage->stageID);
			$action->setUserID($this->userID);
			$action->setProjectID($this->projectID);
			$action->setStageID($this->stageID);
			$action->save();
		}

		$this->updateTimes();
		$params = array(
			":projectID" => $this->projectID,
			":userID" => $this->userID,
			":date" => $this->date,
			":time" => $this->time,
			":stageID" => $this->previousStage->stageID
			);
		$connection = Connection::getInstance();
		$query = "INSERT INTO session_progress(`projectID`, `userID`, `stageID`, `date`, `time`) VALUES (:projectID,:userID, :stageID,:date,:time)";	
		$results = $connection->execute($query, $params);	
		return $this->previousStage;
		
	}
	
	//sets the next stage to another Stage object
	public function populateNextStage()
	{			
		$connection = Connection::getInstance();
		$params = Array(":stageID" => $this->stageID, ":userID" => $this->userID, ":projectID" => $this->projectID);

		$query = "SELECT stageID, page, maxTime, maxTimeQuestion, maxLoops, allowBrowsing, (SELECT count(*) FROM session_progress a WHERE a.stageID = b.stageID  AND userID = :userID AND projectID = :projectID) currentLoops 
				    FROM session_stages b
				    WHERE stageID>:stageID AND status = 1 order by stageID LIMIT 1";
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
		$params = array(":stageID" => $this->stageID, ":userID" => $this->userID, ":projectID" => $this->projectID);
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
	public function getPreviousMaxLoops(){return $this->previousStage->maxLoops;}
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