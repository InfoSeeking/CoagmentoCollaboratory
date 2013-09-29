<?php

//This class contains common attributes.
//Getters and Setters can be updated using php magic methods __get and __set.
class Base 
{	
	protected $data = array(); // Location for overloaded data.

	//maybe userID, projectID, stageID, taskID should be static....

	protected $userID;
	protected $projectID;
	protected $stageID;
	protected $taskID;
	protected $timestamp;
	protected $date;
	protected $time;
	protected $localTimestamp = null;
	protected $localDate = null;
	protected $localTime = null;
	protected $inDatabase = false;//whether or not already saved in database
	
	public function __construct() {
		date_default_timezone_set('America/New_York');
	}
	
	public function __destructor() {
  
	}
	
	//Magi method created only to handle overloaded data
	public function __get($name)
    {
        if (array_key_exists($name, $this->data)) {
            return $this->data[$name];
        }

        $trace = debug_backtrace();
        trigger_error(
            'Undefined property via __get(): ' . $name .
            ' in ' . $trace[0]['file'] .
            ' on line ' . $trace[0]['line'],
            E_USER_NOTICE);
        return null;
    }
	
	public function __set($name, $value)
    {
        $this->data[$name] = $value;
    }
	
	public function __isset($name)
    {
        return isset($this->data[$name]);
    }
	
 	//GETTERS
	public function getUserID()
	{
		return $this->userID;
	}
	
	public function getProjectID()
	{
		return $this->projectID;
	}
	
	public function getStageID()
	{
		return $this->stageID;
	}
	
	public function getTaskID()
	{
		return $this->taskID;
	}
	
	
	public function getTimestamp()
	{
		return $this->timestamp;
	}
  
	public function getDate()
	{
		return $this->date;
	}
  
	public function getTime()
	{
		return $this->time;
	}
  	

  	//TODO: figure out how to get local time
	public function getLocalTimestamp()
	{
		return $this->localTimestamp;
	}
  
	public function getLocalDate()
	{
		return $this->localDate;
	}
  
	public function getLocalTime()
	{
		return $this->localTime;
	}
		
	//SETTERS
	public function setUserID($userID)
	{
		 $this->userID = $userID;
	}
	
	public function setProjectID($projectID)
	{
		$this->projectID = $projectID;
	}
	
	public function setStageID($stageID)
	{
		 $this->stageID = $stageID;
	}
	
	public function setTaskID($questionID)
	{
		 $this->taskID = $taskID;
	}
		
	public function setTimestamp($val)
	{
		if($val == NULL){
			$this->timestamp = time();
		}
		else{
			$this->timestamp = $val;
		}
	}
  
	public function setDate($val)
	{
		if($val == NULL){
			$this->date = date("Y-m-d");
		}
		else{
			$this->date = $val;
		}
	}
  
	public function setTime($val)
	{
		if($val == NULL){
			$this->time = date("H:i:s");
		}
		else{
			$this->time = $val;
		}
	}
  
	public function setLocalTimestamp($val)
	{
		if($val == NULL){
			$this->localTimestamp = time();
		}
		else{
			$this->localTimestamp = $val;
		}
	}
  
	public function setLocalDate($val)
	{
		if($val == NULL){
			$this->localDate = date("Y-m-d");
		}
		else{
			$this->localDate = $val;
		}
	}
  
	public function setLocalTime($val)
	{
		if($val == NULL){
			$this->localTime = date("H:i:s");
		}
		else{
			$this->localTime = $val;
		}
	}

	public function updateTimes(){
		//set all times and dates to present
		$this->setDate(NULL);
		$this->setTime(NULL);
		$this->setTimestamp(NULL);
	}
	//returns XML representation of this class
	public function toXML(){}
}
?>
