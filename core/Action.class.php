<?php
require_once('Connection.class.php');
require_once('Session.class.php');
require_once('Base.class.php');
/*
	Action Class
	
	It keeps login of user actions
*/

class Action extends Base
{
	protected $actionID;
	protected $actionName;
	protected $value;
	
	public function __construct($actionName, $value) {
		//parent::__construct();
		$this->actionName = $actionName;
		$this->value = $value;
		//$this->session = Session::getInstance();
	}
  
	public function save()
	{
		
		$session = Session::getInstance();
		$userID = $session->getUserID();
		if($userID == null){
			throw new Exception("User is not logged in");
		}
		$this->date = $session->getDate();
		$this->time = $session->getTime();
		$this->timestamp = $session->getTimestamp();
		$this->userID = $userID;
		$this->projectID = $session->getProjectID();
		$this->ip = $session->getIP();
		$this->taskID = $session->getQTaskID();
		$this->clientDate = $session->getLocalDate();
		$this->clientTime = $session->getLocalTime();
		$this->clientTimestamp = $session->getLocalTimestamp();		
		$this->stageID = $session->getStageID();
		
		$query = "INSERT INTO actions (userID, projectID, stageID, timestamp, date, time, `clientTimestamp`, `clientDate`, `clientTime`, ip, action, value) 
				  VALUES(:userID,:projectID,:stageID,:timestamp,:date,:time,:clientTimestamp,:clientDate,:clientTime,:ip,:actionName,:value')";

		//VALUES('".$this->getUserID()."','".$this->getProjectID()."','".$this->getStageID()."','".$this->getQuestionID()."','".$this->getTimestamp()."','".$this->getDate()."','".$this->getTime()."','".$this->getLocalTimestamp()."','".$this->getLocalDate()."','".$this->getLocalTime()."','".$this->getIP()."','$this->actionName','$this->value')";

		//echo "query: ".$query;
		$params = array(':userID' => $userID, ':projectID'=>$this->projectID, ':stageID'=>$this->stageID, ':timestamp'=>$this->timestamp, ':date'=>$this->date, ':time'=>$this->time, ':clientTimestamp'=>$this->clientTimestamp, ':clientDate'=>$this->clientDate, ':clientTime'=>$this->clientTime, ':ip'=>$this->ip, ':actionName'=>$this->actionName, ':value'=>$this->value);
		$connection = Connection::getInstance();
		$connection->execute($query,$params);
		$this->actionID = $connection->getLastID();
	}
	
	public static function retrieve($actionID)
	{
		try{
			$connection = Connection::getInstance();
			$query = "SELECT * FROM actions WHERE actionID=:actionID";
			$params = array('actionID' => $this->actionID);
			$results = $connection->execute($query, $params);
			$record = $results->fetch(PDO::FETCH_ASSOC);

				if ($record) {
					$action = new Action();
					$action->date = $record['date'];
					$action->time = $record['time'];
					$action->timestamp = $record['timestamp'];
					$action->userID = $record['userID'];
					$action->projectID = $record['projectID'];
					$action->ip = $record['ip'];
					$action->taskID = $record['taskID'];
					$action->localDate = $record['localDate'];
					$action->localTime = $record['localTime'];
					$action->localTimestamp = $record['localTimestamp'];
					$action->stageID = $record['stageID'];
					$action->value = $record['value'];
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
	
	//TO STRING
	public function __toString()
	{		
		return $this->actionID.",".$this->userID.",".$this->projectID.",".$this->timestamp.",".$this->date.",".$this->time.",".$this->ip.",".$this->actionName.",".$this->value;
	}
}
?>
