<?php
require_once('Connection.class.php');
require_once('Base.class.php');


class Project extends Base
{
  	protected $title;
	protected $description;
	protected $status;
	
	//check user credentials
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
		
	public function save()
	{
		try
		{
			$connection=Connection::getInstance();
			$query = "INSERT INTO projects (title, description, status) VALUES (:title, :description, 1)";
			$params = array(':title'=>$this->title, ':description' => $this->description);
			$results = $connection->execute($query,$params);
			$this->projectID = $connection->getLastID();
		}
		catch(Exception $e)
		{
			throw($e);
		}
		return $this->projectID;
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
	
	public function __toString()
    {
        return "ProjectID: ".$this->projectID." | Title: ".$this->title." | Description: ".$this->description." | Status: ".$this->status;
    }
}
?>