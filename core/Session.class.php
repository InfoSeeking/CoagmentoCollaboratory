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
	
}
?>
