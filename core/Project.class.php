<?php
require_once('Connection.class.php');
//require_once('Action.class.php');

/*
	User Class
	Note: Class contain basic methods to login
*/
class Project 
{
	protected $projectID;
  	protected $title;
	protected $description;
	protected $status
	
	
	//Check user credentials.
	public function static retrieve($projectID)
	{
		try
		{
			$connection=Connection::getInstance();
			$query = "SELECT * FROM users WHERE projectID=:projectID";
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
		catch(Exception e)
		{
			throw($e);
		}
	}
		
	public function save()
	{
		try
		{
			$query = "INSERT INTO projects (projectName, status) VALUES (:username,1)";
			$params = array(':projectName'=>$this->projectName);
			$results = $connection->execute($query,$params);
			$this->projectID = $connection->getLastID();
		}
		catch(Exception e)
		{
			throw($e);
		}
		return $this->projectID;
	}
	
	//GETTERS	
	public function getProjectID()
	{
		return $this->projectID;
	}
	
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
	
	public function __toString()
    {
        return "ProjectID: ".$this->projectID." | Title: ".$this->title." | Description: ".$this->description." | Status: ".$this->status;
    }
}
?>