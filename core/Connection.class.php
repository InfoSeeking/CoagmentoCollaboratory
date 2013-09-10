<?php
require_once('CoagmentoException.class.php');
/*
	Connection Class
	
	Implemented using singleton pattern design.	
*/

class Connection
{
	private static $instance;
	private static $db_selected;
	private $link;
	private $lastID;
	private $db;
		
	public function __construct() {
		$host = "server";
		$username = "userName";
		$password = "password";
		$database = "coagmento_spring2013_study"; //Or other DB instance
				
		try
		{
		//Change with the desired DB engine
			$this->db = new PDO("mysql:host=$host;dbname=$database", $username, $password);
		}
		catch(PDOException $e){
			
			die($e->getCode());
		}
		//Uncomment if you don't want to use PDO
		//$this->link = mysql_connect($host, $username, $password) or die("Cannot connect to the database: ". mysql_error());
        //$this->db_selected = mysql_select_db($database, $this->link) or die ('Cannot connect to the database: ' . mysql_error());
	}
	
	//Returns the current instance of the Connection or it creates one in case it has not been created
	public static function getInstance()
    {
        if (!isset(self::$instance)) {
            $className = __CLASS__;
            self::$instance = new $className;
        }
        return self::$instance;
    }
	
	//Uncomment if you don't want to use PDO
	/*public function commit($query)
	{	
		try{
			$results = mysql_query($query) or die(" ". mysql_error());
			$this->lastID = mysql_insert_id();
			return $results;
		}
		catch(Exception $e){
			//Handle exception
		}
	}*/
	
	//Executing a query safely with PDO object
	public function execute($query,$params)
	{	
		try{
			$statement = $this->db->prepare($query);
			$statement->execute($params);
			$this->lastID = $this->db->lastInsertId(); //Only useful when using INSERT statements
			return $statement;
		}
		catch(PDOException $e){
			die($e->getCode());
		}
	}

	//If inserting new rows in a table with autoincrement primary key, this method returns the last ID generated after INSERT is executed
	public function getLastID()
	{
		return $this->lastID;
	}     
	   	
	public function close()
	{
		//mysql_close($link); //Uncomment if you don't want to use PDO
		$dbh = NULL;
	}
 }
?>
