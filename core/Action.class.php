<?php
require_once('Connection.class.php');
require_once('Session.class.php');
//require_once('Base.class.php');
/*
	Action Class
	
	It keeps login of user actions
*/

class Action
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
		$user = Session::getInstance()->user;
		$userID = $user->getUserID();
		$this->date = $session->getDate();
		$this->time = $session->getTime();
		$this->timestamp = $session->getTimestamp();
		$this->userID = $session->getUserID();
		$this->projectID = $session->getProjectID();
		$this->ip = $session->getIP();
		$this->taskID = $session->getQTaskID();
		$this->localDate = $session->getLocalDate();
		$this->localTime = $session->getLocalTime();
		$this->localTimestamp = $session->getLocalTimestamp();		
		$this->stageID = $session->getStageID();
		
		$query = "INSERT INTO actions (userID, projectID, stageID, timestamp, date, time, `clientTimestamp`, `clientDate`, `clientTime`, ip, action, value) 
				  VALUES(:userID,:projectID,:stageID,:timestamp,:date,:time,:clientTimestamp,:clientDate,:clientTime,:ip,:actionName,:value')";

		//VALUES('".$this->getUserID()."','".$this->getProjectID()."','".$this->getStageID()."','".$this->getQuestionID()."','".$this->getTimestamp()."','".$this->getDate()."','".$this->getTime()."','".$this->getLocalTimestamp()."','".$this->getLocalDate()."','".$this->getLocalTime()."','".$this->getIP()."','$this->actionName','$this->value')";

		//echo "query: ".$query;
		$params = array(':userID' => $userID, ':projectID'=>$projectID, ':stageID'=>$stageID, ':timestamp'=>$timestamp, ':date'=>$date, ':time'=>$time, ':clientTimestamp'=>$clientTimestamp, ':clientDate'=>$clientDate, ':clientTime'=>$clientTime, ':ip'=>$ip, ':actionName'=>$actionName, ':value'=>$value);
		$connection = Connection::getInstance();
		$connection->execute($query,$params);
		$this->actionID = $connection->getLastID();
	}
	
	public static function retrieve($actionID)
	{
		//Implement retrieve
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
