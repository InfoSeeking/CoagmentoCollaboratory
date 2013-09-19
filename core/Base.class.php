<?php

//This class contains common attributes.
//Getters and Setters can be updated using php magic methods __get and __set.
class Base 
{	
	protected $data = array(); // Location for overloaded data.
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
		$this->timestamp = time();
		return $this->timestamp;
	}
  
	public function getDate()
	{
		$this->date = date("Y-m-d");
		return $this->date;
	}
  
	public function getTime()
	{
		$this->time = date("H:i:s");
		return $this->time;
	}
  	

  	//TODO: figure out how to get local time
	public function getLocalTimestamp()
	{
		$this->localTimestamp = time();
		return $this->localTimestamp;
	}
  
	public function getLocalDate()
	{
		$this->localDate = date("Y-m-d");
		return $this->localDate;
	}
  
	public function getLocalTime()
	{
		$this->localTime = date("H:i:s");
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
		
	public function setTimestamp($timestamp)
	{
		$this->timestamp = $timestamp;
	}
  
	public function setDate($date)
	{
		$this->date = $date;
	}
  
	public function setTime($time)
	{
		$this->time = $time;
	}
  
	public function setLocalTimestamp($localTimestamp)
	{
		$this->localTimestamp = $localTimestamp;
	}
  
	public function setLocalDate($localDate)
	{
		$this->localDate = $localDate;
	}
  
	public function setLocalTime($localTime)
	{
		$this->localTime = $localTime;
	}
}
?>
