<?php
require_once('Connection.class.php');
require_once('Base.class.php');
require_once('Action.class.php');

/*
TODO: utilize the Stage class to make things a bit cleaner
*/

/**
* @class SessionProgress
* This class allows users to save their progress in the stages of a project.
*/
class SessionProgress extends Base
{
	protected $seqNum;
	protected $currentPage;
	protected $maxTime;
	protected $maxQuestion;
	protected $maxLoops;
	protected $currentLoops;
	protected $allowBrowsing;
	protected $previousSessionProgress; //SessionProgress object
	protected $nextSessionProgress; //SessionProgress object
	protected $previousStartTimestamp;
	protected $previousMaxTime;
	
	public function __construct(){
		$this->inDatabase = false;
	}

	/**
	* Creates a record for the userID in the project saying they are on the first sessionprogress. Currently this method does not set the time/date, but this should change with the integration of the Stage class.
	* @return boolean tells whether or not it was successful. If the stage does not exist or it cannot insert it will return false.
	*/
	public static function addInitialProgress($projectID, $userID){
		//first select the first stage in the project
		$params = Array(":projectID" => $projectID);
		$query = "SELECT seqNum FROM session_stages WHERE projectID = :projectID ORDER BY seqNum";
		$connection = Connection::getInstance();
		$results = $connection->execute($query, $params);
		$record = $results->fetch(PDO::FETCH_ASSOC);
		if($record){
			$params = Array(":projectID" => $projectID, ":userID" => $userID, ":seqNum" => $record["seqNum"]);
			$query = "INSERT INTO session_progress (`projectID`, `userID`, `seqNum`) VALUES (:projectID, :userID, :seqNum)";
			$results = $connection->execute($query, $params);
			return $results->rowCount > 0;
		}
		else{
			return false;
		}
	}
	/**
	* Returns the sessionprogress which the user is at in the specified project. If the user is not in the session_progress table for this project, it returns null.
	* @param int $projectID
	* @param int $userID
	* @return SessionProgress
	*/
	public static function retrieve($projectID, $userID) 
	{
		$params = Array(":projectID" => $projectID, ":userID" => $userID);
		$query = "SELECT seqNum, page, maxTime, maxTimeQuestion, maxLoops, allowBrowsing, (SELECT count(*) FROM session_progress a WHERE a.seqNum = b.seqNum and a.projectID = b.projectID and projectID = :projectID and userID = :userID ) currentLoops
				  FROM session_stages b
				  WHERE status = 1
				    AND seqNum = (SELECT seqNum
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
			$sessionprogress = new SessionProgress();
			$sessionprogress->seqNum = $record['seqNum'];
			$sessionprogress->currentPage = $record['page'];
			$sessionprogress->maxTime = $record['maxTime'];
			$sessionprogress->maxTimeQuestion = $record['maxTimeQuestion'];
			$sessionprogress->maxLoops = $record['maxLoops'];
			$sessionprogress->currentLoops = $record['currentLoops'];
			$sessionprogress->allowBrowsing = $record['allowBrowsing'];
			$sessionprogress->projectID = $projectID;
			$sessionprogress->userID = $userID;
			$sessionprogress->populatePreviousSessionProgress();
			$sessionprogress->populateNextSessionProgress();
			$sessionprogress->inDatabase = true;
			return $sessionprogress;
		}
		else 
		{
			return null;
		}
	}
  	
  	/**
  	* Returns the nextSessionProgress variable, but initializes the nextSessionProgress with it's own nextSessionProgress and previousSessionProgress properties (in a linked list fashion).
  	* Note that this function does not change the current object, but instead readies the next sessionprogress object and returns that.
  	* @param boolean $logAction if this is true, it will log an action saying the user moved to the next sessionprogress
  	* @return SessionProgress this is next sessionprogress which the nextSessionProgress property points
  	*/
	public function moveToNextSessionProgress($logAction=FALSE)
	{
		if($this->nextSessionProgress == null){
			return null;
		}
		$this->nextSessionProgress->previousSessionProgress = $this;
		$this->nextSessionProgress->populateNextSessionProgress();
		//Create action before setting the session variable to preserve the previous sessionprogress in the log
		if($logAction){
			$action = new Action('Next Stage: '.$this->currentPage . " to " . $this->nextSessionProgress->currentPage,$this->nextSessionProgress->seqNum);
			$action->setUserID($this->userID);
			$action->setProjectID($this->projectID);
			$action->setSeqNum($this->seqNum);
			$action->save();
		}

		$this->updateTimes();
		$params = array(
			":projectID" => $this->projectID,
			":userID" => $this->userID,
			":date" => $this->date,
			":time" => $this->time,
			":seqNum" => $this->nextSessionProgress->seqNum
			);
		$connection = Connection::getInstance();
		$query = "INSERT INTO session_progress(`projectID`, `userID`, `seqNum`, `date`, `time`) VALUES (:projectID,:userID, :seqNum,:date,:time)";	
		$results = $connection->execute($query, $params);	
		return $this->nextSessionProgress;
	}
	/**
  	* Similar to moveToNextSessionProgress, returns the previous sessionprogress with it's next and previous sessionprogress pointers initialized
  	* @param boolean $logAction if this is true, it will log an action saying the user moved to the previous sessionprogress
  	* @return SessionProgress this is previous sessionprogress which the previousSessionProgress property points
  	*/
	public function moveToPreviousSessionProgress($logAction=FALSE)
	{
		if($this->previousSessionProgress == null){
			return null;
		}
		$this->previousSessionProgress->nextSessionProgress = $this;
		$this->previousSessionProgress->populatePreviousSessionProgress();
		//Create action before setting the session variable to preserve the previous sessionprogress in the log
		if($logAction){
			$action = new Action('Previous Stage: '.$this->currentPage . " to " . $this->previousSessionProgress->currentPage,$this->previousSessionProgress->seqNum);
			$action->setUserID($this->userID);
			$action->setProjectID($this->projectID);
			$action->setSeqNum($this->seqNum);
			$action->save();
		}

		$this->updateTimes();
		$params = array(
			":projectID" => $this->projectID,
			":userID" => $this->userID,
			":date" => $this->date,
			":time" => $this->time,
			":seqNum" => $this->previousSessionProgress->seqNum
			);
		$connection = Connection::getInstance();
		$query = "INSERT INTO session_progress(`projectID`, `userID`, `seqNum`, `date`, `time`) VALUES (:projectID,:userID, :seqNum,:date,:time)";	
		$results = $connection->execute($query, $params);	
		return $this->previousSessionProgress;
		
	}
	
	//sets the next sessionprogress to another SessionProgress object
	public function populateNextSessionProgress()
	{			
		$connection = Connection::getInstance();
		$params = Array(":seqNum" => $this->seqNum, ":userID" => $this->userID, ":projectID" => $this->projectID);

		$query = "SELECT seqNum, page, maxTime, maxTimeQuestion, maxLoops, allowBrowsing, (SELECT count(*) FROM session_progress a WHERE a.seqNum = b.seqNum AND a.projectID = b.projectID  AND userID = :userID AND projectID = :projectID) currentLoops 
				    FROM session_stages b
				    WHERE seqNum>:seqNum AND status = 1 order by seqNum LIMIT 1";
		$results = $connection->execute($query, $params);
		$record = $results->fetch(PDO::FETCH_ASSOC);
		if($record){
			$this->nextSessionProgress = new SessionProgress();
			$this->nextSessionProgress->userID = $this->userID;
			$this->nextSessionProgress->projectID = $this->projectID;
			$this->nextSessionProgress->seqNum = $record['seqNum'];
			$this->nextSessionProgress->currentPage = $record['page'];
			$this->nextSessionProgress->maxTime = $record['maxTime'];
			$this->nextSessionProgress->maxTimeQuestion = $record['maxTimeQuestion'];
			$this->nextSessionProgress->maxLoops = $record['maxLoops'];
			$this->nextSessionProgress->currentLoops = $record['currentLoops'];
			$this->nextSessionProgress->allowBrowsing = $record['allowBrowsing'];
			//do not populate it's next/previous sessionprogress, this would create an infinite loop
		}
	}

	//getters for next sessionprogress
	public function getNextSessionProgress(){return $this->nextSessionProgress->seqNum;}
	public function getNextPage(){return $this->nextSessionProgress->page;}
	public function getNextMaxTime(){return $this->nextSessionProgress->maxTime;}
	public function getNextMaxTimeQuestion(){return $this->nextSessionProgress->maxTimeQuestion;}
	public function getNextMaxLoops(){return $this->nextSessionProgress->maxLoops;}
	public function getNextCurrentLoops(){return $this->nextSessionProgress->currentLoops;}
	public function getNextAllowBrowsing(){return $this->nextSessionProgress->allowBrowsing;}
	
	//GETTERS PREVIOUS SESSIONPROGRESS
	public function populatePreviousSessionProgress()
	{	
		$connection = Connection::getInstance();
		$params = array(":seqNum" => $this->seqNum, ":userID" => $this->userID, ":projectID" => $this->projectID);
		$query = "SELECT seqNum, page, maxTime, maxTimeQuestion, maxLoops, allowBrowsing, (SELECT count(*) FROM session_progress a WHERE a.seqNum = b.seqNum AND a.projectID = b.projectID   AND userID = :userID AND projectID = :projectID) currentLoops 
				    FROM session_stages b
				    WHERE seqNum<:seqNum AND status = '1' order by seqNum DESC LIMIT 1";
		$results = $connection->execute($query, $params);
		$record = $results->fetch(PDO::FETCH_ASSOC);
		if($record){
			$this->previousSessionProgress = new SessionProgress();
			$this->previousSessionProgress->userID = $this->userID;
			$this->previousSessionProgress->projectID = $this->projectID;
			$this->previousSessionProgress->seqNum = $record['seqNum'];
			$this->previousSessionProgress->currentPage = $record['page'];
			$this->previousSessionProgress->maxTime = $record['maxTime'];
			$this->previousSessionProgress->maxTimeQuestion = $record['maxTimeQuestion'];
			$this->previousSessionProgress->maxLoops = $record['maxLoops'];
			$this->previousSessionProgress->currentLoops = $record['currentLoops'];
			$this->previousSessionProgress->allowBrowsing = $record['allowBrowsing'];
			//do not populate it's next/previous sessionprogress, this would create an infinite loop
		}
	}
	//getters for previous sessionprogress
	public function getPreviousSessionProgress(){return $this->previousSessionProgress->seqNum;}
	public function getPreviousPage(){return $this->previousSessionProgress->page;}
	public function getPreviousMaxTime(){return $this->previousSessionProgress->maxTime;}
	public function getPreviousMaxTimeQuestion(){return $this->previousSessionProgress->maxTimeQuestion;}
	public function getPreviousMaxLoops(){return $this->previousSessionProgress->maxLoops;}
	public function getPreviousCurrentLoops(){return $this->previousSessionProgress->currentLoops;}
	public function getPreviousAllowBrowsing(){return $this->previousSessionProgress->allowBrowsing;}	
	public function getPreviousStartTimestamp(){return $this->previousSessionProgress->timestamp;}


	//getters for this sessionprogress
	public function getCurrentSessionProgress(){return $this->seqNum;}
	public function getCurrentPage(){return $this->currentPage;}
	public function getMaxTime(){return $this->maxTime;}
	public function getMaxTimeQuestion(){return $this->maxTimeQuestion;}
	public function getAllowBrowsing(){return $this->allowBrowsing;}

	//SETTERS
	public function setPage($val){$this->page = $val;}
	public function setSeqNum($val){$this->seqNum = $val;}
	public function setMaxTime($val){$this->maxTime = $val;}
	public function setMaxTimeQuestion($val){$this->maxTimeQuestion = $val;}
	public function setMaxLoops($val){$this->maxLoops = $val;}
	public function setCurrentLoops($val){$this->currentLoops = $val;}
	public function setAllowBrowsing($val){$this->allowBrowsing = $val;}
	public function setPreviousStartTimestamp($val){$this->previousStartTimestamp = $val;}
	public function setPreviousMaxTime($val){$this->previousMaxTime = $val;}
}
?>