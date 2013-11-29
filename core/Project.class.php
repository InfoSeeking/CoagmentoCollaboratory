<?php
require_once('Connection.class.php');
require_once('Base.class.php');


class Project extends Base
{
  	protected $title;
	protected $description;
	protected $status;
	
	public function __construct(){
		$this->inDatabase = false;
	}

	/* 
		TODO: 
		- add retrieval functions for pages,bookmarks,snippets collected from a project (or put them in respective classes) 
		- add methods for modifying project memberships (if administrator)
		- enforce that there should always be at least one administrator
	*/
	public static function retrieve($projectID)
	{
		try
		{
			$connection=Connection::getInstance();
			$query = "SELECT * FROM projects WHERE projectID=:projectID";
			$params = array(':projectID' => $projectID);
			$results = $connection->execute($query,$params);		
			$record = $results->fetch(PDO::FETCH_ASSOC);

			if ($record) {
				$project = new Project();
				$project->projectID = $record['projectID'];
				$project->title = $record['title'];
				$project->description = $record['description'];
				$project->status = $record['status'];
						
				return $project;
			}
			else
				return null;
		}
		catch(Exception $e)
		{
			throw($e);
		}
	}

	/**
	* Retrieves all projects which a given user is a member of
	* @param userID int the user's id
	*/
	public static function retrieveAllFromUser($userID){
		try
		{
			$connection=Connection::getInstance();
			$query = "SELECT p.* FROM projects p, project_membership pm WHERE pm.userID = :userID AND pm.projectID = p.projectID";
			$params = array(':userID' => $userID);
			$results = $connection->execute($query,$params);		
			$projects = [];
			while($record = $results->fetch(PDO::FETCH_ASSOC)){
				$project = new Project();
				$project->projectID = $record['projectID'];
				$project->title = $record['title'];
				$project->description = $record['description'];
				$project->status = $record['status'];
				array_push($projects, $project);
			}
			return $projects;
		}
		catch(Exception $e)
		{
			throw($e);
		}
	}
	
	/**
	* Add a user to this project
	*/
	public function addUser($userID){
		//TODO
	}
	/**
	* Retrieve a list of the id's of the users who are members of this project
	*/
	public function getUsers(){
		//TODO
	}
	public function save()
	{
		try
		{
			$params = array(':title'=>$this->title, ':description' => $this->description);
			if($this->inDatabase){
				$query = "UPDATE projects SET `title`=:title, `description`=:description, `status`=1 WHERE `projectID`=:projectID";
				$params[':projectID'] = $this->projectID;
			}
			else{
				$query = "INSERT INTO projects (title, description, status) VALUES (:title, :description, 1)";
			}
			
			
			$connection=Connection::getInstance();
			$results = $connection->execute($query,$params);
			$this->projectID = $connection->getLastID();
		}
		catch(Exception $e)
		{
			throw($e);
		}
		return $this->projectID;
	}

	public static function delete($projectID){
		$connection = Connection::getInstance();
		$query = "DELETE FROM projects WHERE projectID=:projectID";
		$params = array('projectID' => $projectID);
		$statement = $connection->execute($query, $params);
		return $statement->rowCount();
	}
	//GETTERS	
	
	public function getTitle()
	{
		return $this->title;
	}

	public function getDescription()
	{
		return $this->description;
	}
	
	public function getStatus()
	{
		return $this->status;
	}
	
	
	//SETTERS
	public function setTitle($title)
	{
		$this->title = $title;
	}
	
	public function setDescription($description)
	{
		$this->description = $description;
	}
	
	public function setStatus($status)
	{
		$this->status = $status;
	}
	public function toXML(){
		printf('<resource><projectID>%d</projectID><title>%s</title><description>%s</description>', $this->projectID, $this->title, $this->description);
	}
	public function toJSON(){
		printf('{"projectID" : %d, "title": "%s", "description" : "%s"}', $this->projectID, $this->title, $this->description);
	}
	public function __toString()
    {
        return "ProjectID: ".$this->projectID." | Title: ".$this->title." | Description: ".$this->description." | Status: ".$this->status;
    }
}
?>