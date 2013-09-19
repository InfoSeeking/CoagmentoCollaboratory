<?php
require_once('Connection.class.php');
require_once('Base.class.php');
/*
	Action Class
	
	It keeps log of user actions
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
	}
  
	public function save()
	{

		//set time and date to present
		$this->setDate(NULL);
		$this->setTime(NULL);
		$this->setTimestamp(NULL);
		$this->setLocalDate(NULL);
		$this->setLocalTime(NULL);
		$this->setLocalTimestamp(NULL);
		
		$query = "INSERT INTO actions (userID, projectID, stageID, `timestamp`, `date`, `time`, `clientTimestamp`, `clientDate`, `clientTime`, `ip`, `action`, `value`) 
				  VALUES(:userID,:projectID,:stageID,:timestamp,:date,:time,:clientTimestamp,:clientDate,:clientTime,:ip,:actionName,:value)";

		//VALUES('".$this->getUserID()."','".$this->getProjectID()."','".$this->getStageID()."','".$this->getQuestionID()."','".$this->getTimestamp()."','".$this->getDate()."','".$this->getTime()."','".$this->getLocalTimestamp()."','".$this->getLocalDate()."','".$this->getLocalTime()."','".$this->getIP()."','$this->actionName','$this->value')";

		//echo "query: ".$query;
		$params = array(':userID' => $userID, ':projectID'=>$this->projectID, ':stageID'=>$this->stageID, ':timestamp'=>$this->timestamp, ':date'=>$this->date, ':time'=>$this->time, ':clientTimestamp'=>$this->clientTimestamp, ':clientDate'=>$this->clientDate, ':clientTime'=>$this->clientTime, ':ip'=>$this->ip, ':actionName'=>$this->actionName, ':value'=>$this->value);
		$connection = Connection::getInstance();
		$connection->execute($query,$params);
		$this->actionID = $connection->getLastID();
		return $this->actionID;
	}
	
	public static function retrieve($actionID)
	{
		try{
			$connection = Connection::getInstance();
			$query = "SELECT * FROM actions WHERE actionID=:actionID";
			$params = array('actionID' => $actionID);
			$results = $connection->execute($query, $params);
			$record = $results->fetch(PDO::FETCH_ASSOC);

				if ($record) {
					$action = new Action($record['actionName'], $record['value']);
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
}
?>
