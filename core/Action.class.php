<?php
require_once('Connection.class.php');
require_once('Base.class.php');
/**
* Defines different actions from users
*/

class Action extends Base
{
	protected $actionID;
	protected $actionName;
	protected $value;
	protected $ip;
	
	public function __construct($actionName, $value) {
		//parent::__construct();
		$this->actionName = $actionName;
		$this->value = $value;
		$this->inDatabase = false;
		$this->updateTimes();//sets server times to present
	}
  	/**
  	* Adds action to database.
  	* The save method will either insert the action into the database if it is new, or update it if it is already in the database.
  	*/
	public function save()
	{
		$params = array(':userID' => $this->userID, ':projectID'=>$this->projectID, ':stageID'=>$this->stageID, ':timestamp'=>$this->timestamp, ':date'=>$this->date, ':time'=>$this->time, ':clientTimestamp'=>$this->localTimestamp, ':clientDate'=>$this->localDate, ':clientTime'=>$this->localTime, ':ip'=>$this->ip, ':actionName'=>$this->actionName, ':value'=>$this->value);
		if($this->inDatabase){
			$query = "UPDATE actions SET `userID` = :userID,`projectID` = :projectID,`stageID` = :stageID,`timestamp` = :timestamp,`date` = :date,`time` = :time,`clientTimestamp` = :clientTimestamp,`clientDate` = :clientDate,`clientTime` = :clientTime,`ip` = :ip,`action` = :actionName,`value` = :value WHERE `actionID`=:actionID";
			$params[":actionID"] = $this->actionID;
		}
		else{
			$query = "INSERT INTO actions (userID, projectID, stageID, `timestamp`, `date`, `time`, `clientTimestamp`, `clientDate`, `clientTime`, `ip`, `action`, `value`) 
				  VALUES(:userID,:projectID,:stageID,:timestamp,:date,:time,:clientTimestamp,:clientDate,:clientTime,:ip,:actionName,:value)";
		}

		//VALUES('".$this->getUserID()."','".$this->getProjectID()."','".$this->getStageID()."','".$this->getQuestionID()."','".$this->getTimestamp()."','".$this->getDate()."','".$this->getTime()."','".$this->getLocalTimestamp()."','".$this->getLocalDate()."','".$this->getLocalTime()."','".$this->getIP()."','$this->actionName','$this->value')";

		//echo "query: ".$query;
		
		$connection = Connection::getInstance();
		$connection->execute($query,$params);
		$this->actionID = $connection->getLastID();
		return $this->actionID;
	}
	
	/**
	* Retrieves an action object given it's id
	* @param int $actionID
	* @return Action
	*/
	public static function retrieve($actionID)
	{
		try{
			$connection = Connection::getInstance();
			$query = "SELECT * FROM actions WHERE actionID=:actionID";
			$params = array('actionID' => $actionID);
			$results = $connection->execute($query, $params);
			$record = $results->fetch(PDO::FETCH_ASSOC);

				if ($record) {
					$action = new Action($record['action'], $record['value']);
					$action->inDatabase = true;
					$action->date = $record['date'];
					$action->time = $record['time'];
					$action->timestamp = $record['timestamp'];
					$action->userID = $record['userID'];
					$action->projectID = $record['projectID'];
					$action->ip = $record['ip'];
					$action->taskID = $record['taskID'];
					$action->localDate = $record['clientDate'];
					$action->localTime = $record['clientTime'];
					$action->localTimestamp = $record['clientTimestamp'];
					$action->stageID = $record['stageID'];
					$action->actionID = $record['actionID'];
					return $action;
				}
				else
					return null;
			}
			catch(Exception $e){
				throw($e);
			}
	}
	/**
	* Deletes an action from the database
	*/
	public static function delete($actionID){
		$connection = Connection::getInstance();
		$query = "DELETE FROM actions WHERE actionID=:actionID";
		$params = array('actionID' => $actionID);
		$statement = $connection->execute($query, $params);
		return $statement->rowCount();
	}
	
	//GETTERS
	public function getActionID()
	{
		return $this->actionID;
	}
	
	public function getAction()
	{
		return $this->action;
	}
	
	public function getValue()
	{
		return $this->value;
	}
	public function getIP(){
		return $this->ip;
	}
			
	//SETTERS
	public function setActionID($actionID)
	{
		$this->actionID = $actionID;
	}
	
	public function setAction($actionName)
	{
		$this->actionName = $actionName;
	}
	
	public function setValue($value)
	{
		$this->value = $value;
	}

	public function setIP($val){
		$this->ip = $val;
	}
	
	//TO STRING
	public function __toString()
	{		
		return $this->actionID.",".$this->userID.",".$this->projectID.",".$this->timestamp.",".$this->date.",".$this->time.",".$this->ip.",".$this->actionName.",".$this->value;
	}
	public function toXML(){
		return "<resource><type>action</type><actionID>" . $this->actionID . "</actionID><userID>" . $this->userID . "</userID><projectID>" . $this->projectID . "</projectID><timestamp>". $this->timestamp."</timestamp><date>".$this->date."</date><time>".$this->time."</time><ip>".$this->ip."</ip><actionName>".$this->actionName."</actionName><actionValue>".$this->value . "</actionValue></resource>";
	}
}
?>
