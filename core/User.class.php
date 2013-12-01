<?php
require_once('Connection.class.php');
require_once('Action.class.php');

/*
	User Class
	Note: Class contain basic methods to login
*/
class User 
{
	protected $userID;
  	protected $userName;
	protected $password;
	protected $status;
	protected $key;

	// //Constructor
	// public function __User() {
		// parent::__construct();
	// }
		
	//Check user credentials.
	public static function login($userName, $password)
	{
		$connection=Connection::getInstance();
		$query = "SELECT * FROM users WHERE username=:userName AND password=sha1(:password) AND status=1";
		$params = array(':userName' => $userName, ':password'=>$password);
		$results = $connection->execute($query,$params);		
		$record = $results->fetch(PDO::FETCH_ASSOC);

		if ($record) {
			$user = new User();
			$user->userID = $record['userID'];
			$user->userName = $record['username'];
			$user->status = $record['status'];
			$user->key = $record['api_key'];
			return $user;
		}
		else{
			return NULL;
		}
	}
	

	public static function retrieve($userID){
		$connection=Connection::getInstance();
		$query = "SELECT * FROM users WHERE userID=:userID";
		$params = array(':userID' => $userID);
		$results = $connection->execute($query,$params);		
		$record = $results->fetch(PDO::FETCH_ASSOC);

		if ($record) {
			$user = new User();
			$user->userID = $record['userID'];
			$user->userName = $record['username'];
			$user->status = $record['status'];
			$user->key = $record['api_key'];
			return $user;
		}
		else{
			return NULL;
		}
	}
	
	public static function retrieveUsersFromProject($projectID){
		$connection=Connection::getInstance();
		$query = "SELECT u.* FROM users u, project_membership pm WHERE pm.projectID=:projectID AND u.userID = pm.userID";
		$params = array(':projectID' => $projectID);
		$results = $connection->execute($query,$params);		
		
		$users = [];
		while($record = $results->fetch(PDO::FETCH_ASSOC)){
			$user = new User();
			$user->userID = $record['userID'];
			$user->userName = $record['username'];
			$user->status = $record['status'];
			$user->key = $record['api_key'];
			array_push($users, $user);
		}
		return $users;
	}

	/*
	returns -1 if could not insert, otherwise returns user id
	*/
	public function save()
	{
		$connection=Connection::getInstance();
		$query = "INSERT INTO users (username, password, status) VALUES (:username,sha1(:password),:status)";
		//echo $query." ".$this->userName ." ".$this->password ." ".$this->status ."<br/>";
		$params = array(':username' => $this->userName, ':password' => $this->password, ':status' => $this->status);
		$results = $connection->execute($query,$params);
		if($results->rowCount() == 0){
			//user could not be inserted, probably existing username
			return -1;
		}
		$this->userID = $connection->getLastID();
		return $this->userID;
	}
	
	//GETTERS	
	
	public function getUserID()
	{
		return $this->userID;
	}
	
	public function getUserName()
	{
		return $this->userName;
	}
	
	public function getPassword()
	{
		return $this->password;
	}
	
	public function getStatus()
	{
		return $this->status;
	}

	public function getKey(){
		return $this->key;
	}
	
	
	//SETTERS
	public function setUserName($userName)
	{
		$this->userName = $userName;
	}
	
	public function setPassword($password)
	{
		$this->password = $password;
	}
	
	public function setStatus($status)
	{
		$this->status = $status;
	}

	public function toXML(){
		printf("<resource><userID>%d</userID><key>%s</key><userName>%s</userName></resource>", $this->userID, $this->key, $this->userName);
	}

	public function toJSON(){
		printf('{"userID" : %d, "username": "%s", "key" : "%s"}', $this->userID, $this->userName, $this->key);
	}

	public function __toString()
    {
        return "UserID: ".$this->userID." | Username: ".$this->userName." | Status: ".$this->status;
    }
}
?>