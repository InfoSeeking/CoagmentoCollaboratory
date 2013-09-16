<?php
require_once('Connection.class.php');
require_once('Session.class.php');
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

	// //Constructor
	// public function __User() {
		// parent::__construct();
	// }
		
	//Check user credentials.
	public static function login($userName, $password)
	{
		$connection=Connection::getInstance();
		$query = "SELECT * FROM users WHERE username=:userName AND password=:password AND status=1";
		$params = array(':userName' => $userName, ':password'=>$password);
		$results = $connection->execute($query,$params);		
		$record = $results->fetch(PDO::FETCH_ASSOC);

		if ($record) {
			$user = new User();
			$user->userID = $record['userID'];
			$user->userName = $record['username'];
			$user->status = $record['status'];
			
			
			Session::getInstance()->setUserID($user->userID);

			$action = new Action('user_state', 'login');
			$action->save();

			return $user;
		}
		else{
			return NULL;
		}
	}
	
	public static function logout(){
		Session:getInstance()->setUserID(NULL);
	}

	public static function retrieve(){
		$connection=Connection::getInstance();
		$userID = Session::getInstance()->getUserID();
		$query = "SELECT * FROM users WHERE userID=:userID";
		$params = array(':userID' => $userID);
		$results = $connection->execute($query,$params);		
		$record = $results->fetch(PDO::FETCH_ASSOC);

		if ($record) {
			$user = new User();
			$user->userID = $record['userID'];
			$user->userName = $record['username'];
			$user->status = $record['status'];
			return $user;
		}
		else{
			return NULL;
		}
	}
	

	/*
	returns -1 if could not insert, otherwise returns user id
	*/
	public function save()
	{
		$connection=Connection::getInstance();
		$query = "INSERT INTO users (username, password, status) VALUES (:username,:password,:status)";
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

	public function __toString()
    {
        return "UserID: ".$this->userID." | Username: ".$this->userName." | Status: ".$this->status;
    }
}
?>