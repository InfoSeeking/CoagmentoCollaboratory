<?php
session_start();
/*
	Session Class
	Wrapper class for the $_SESSION variable
	Contains useful data accessible from all classes
*/
class Session 
{	
	private static $instance;
	
	public function __construct(){
		$this->projectID = NULL;

	}
	public function isSessionActive()
	{
		return (count($_SESSION)>0);	
	}
	
	public function destroySession()
	{
		session_destroy();
	}
	
	//Use magic methods to set session variables in $_SESSION
	public function __set($name, $value)
    {
		$_SESSION[$name] = $value;      
    }
	
	//Use magic methods to get session variables in $_SESSION
	public function __get($name)
    {
        if (array_key_exists($name, $_SESSION)) {
            return $_SESSION[$name];
        }

        $trace = debug_backtrace();
        trigger_error(
            'Undefined property via __get(): ' . $name .
            ' in ' . $trace[0]['file'] .
            ' on line ' . $trace[0]['line'],
            E_USER_NOTICE);
        return null;
    }
	
	public static function getInstance()
    {
        if (!isset(self::$instance)) {
            $className = __CLASS__;
            self::$instance = new $className;
        }
        return self::$instance;
    }
	
	public function setUserID($val){
		$this->userID = $val;
	}
	public function setProjectID($val){
		$this->projectID = $val;
	}

    public function getDate(){
    	return date("Y-m-d");
    }
	public function getTime(){
		return date("H:i:s");
	}
	public function getTimestamp(){
		return time();
	}
	//TODO: figure out local time
	public function getLocalDate(){
		return date("Y-m-d");
	}
	public function getLocalTime(){
		return date("H:i:s");
	}
	public function getLocalTimestamp(){
		return time();
	}
	public function getUserID(){
		return $this->userID;
	}
	public function getProjectID(){
		return $this->projectID;
	}
	public function getIP(){
		return $_SERVER['REMOTE_ADDR'];
	}
	//TODO: implement these
	public function getStageID(){
		return 0;
	}
	public function getQTaskID(){
		return 0;
	}
}
?>
