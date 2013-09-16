<?php
require_once('Connection.class.php');
require_once('Base.class.php');
require_once('Session.class.php');
//require_once('Action.class.php');

class Snippet extends Base
{
	protected $snippetID;
  	protected $questionID;
  	protected $url;
  	protected $title;
  	protected $snippet;
  	protected $note;
  	protected $type;
  	protected $status;
	
	//Check user credentials.
	public static function retrieve($snippetID)
	{
		try
		{
			$connection=Connection::getInstance();
			$query = "SELECT * FROM snippets WHERE snippetID=:snippetID";
			$params = array(':snippetID' => $snippetID);
			$results = $connection->execute($query,$params);		
			$record = $results->fetch(PDO::FETCH_ASSOC);

			if ($record) {
				$snippet = new Snippet();
				$snippet->snippetID = $record['snippetID'];
				$snippet->title = $record['title'];
				$snippet->status = $record['status'];
  				$snippet->projectID = $record['projectID'];
  				$snippet->userID = $record['userID'];
  				$snippet->stageID = $record['stageID'];
  				$snippet->questionID = $record['questionID'];
  				$snippet->url = $record['url'];
  				$snippet->snippet = $record['snippet'];
  				$snippet->note = $record['note'];
  				$snippet->type = $record['type'];
  				$snippet->status = $record['status'];
				$snippet->date = $record['date'];
				$snippet->time = $record['time'];
				$snippet->timestamp = $record['timestamp'];
				$snippet->localDate = $record['clientDate'];
				$snippet->localTime = $record['clientTime'];
				$snippet->localTimestamp = $record['clientTimestamp'];
				return $snippet;
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
			$session = Session::getInstance();
			$this->userID = $session->getUserID();
			$this->projectID = $session->getProjectID();
			$this->localTimestamp = $session->getLocalTimestamp();
			$this->localDate = $session->getLocalDate();
			$this->localTime = $session->getLocalTime();
			$this->Timestamp = $session->getTimestamp();
			$this->Date = $session->getDate();
			$this->Time = $session->getTime();
			
			$connection=Connection::getInstance();
			$query = "INSERT INTO snippets (`title`,`status`,`projectID`,`userID`,`stageID`,`questionID`,`url`,`snippet`,`note`,`type`,`date`,`time`,`timestamp`,`clientDate`,`clientTime`,`clientTimestamp`) VALUES (:title,:status,:projectID,:userID,:stageID,:questionID,:url,:snippet,:note,:type,:date,:time,:timestamp,:clientDate,:clientTime,:clientTimestamp)";
			$params = array(':title' => $this->title,':status' => $this->status,':projectID' => $this->projectID,':userID' => $this->userID,':stageID' => $this->stageID,':questionID' => $this->questionID,':url' => $this->url,':snippet' => $this->snippet,':note' => $this->note,':type' => $this->type,':date' => $this->date,':time' => $this->time,':timestamp' => $this->timestamp,':clientDate' => $this->localDate,':clientTime' => $this->localTime,':clientTimestamp' => $this->localTimestamp);
			$results = $connection->execute($query,$params);
			$this->snippetID = $connection->getLastID();
		}
		catch(Exception $e)
		{
			throw($e);
		}
		return $this->snippetID;
	}
	
	//GETTERS	
	public function getSnippetID(){return $this->snippetID;}
	public function getTitle(){return $this->title;}
	public function getStatus(){return $this->status;}
	public function getProjectID(){return $this->projectID;}
	public function getUserID(){return $this->userID;}
	public function getStageID(){return $this->stageID;}
	public function getQuestionID(){return $this->questionID;}
	public function getUrl(){return $this->url;}
	public function getSnippet(){return $this->snippet;}
	public function getNote(){return $this->note;}
	public function getType(){return $this->type;}
	public function getDate(){return $this->date;}
	public function getTime(){return $this->time;}
	public function getTimestamp(){return $this->timestamp;}
	public function getClientDate(){return $this->localDate;}
	public function getClientTime(){return $this->localTime;}
	public function getClientTimestamp(){return $this->localTimestamp;}

	//SETTERS
	public function setSnippetID($val){$this->snippetID = $val;}
	public function setTitle($val){$this->title = $val;}
	public function setStatus($val){$this->status = $val;}
	public function setProjectID($val){$this->projectID = $val;}
	public function setUserID($val){$this->userID = $val;}
	public function setStageID($val){$this->stageID = $val;}
	public function setQuestionID($val){$this->questionID = $val;}
	public function setUrl($val){$this->url = $val;}
	public function setSnippet($val){$this->snippet = $val;}
	public function setNote($val){$this->note = $val;}
	public function setType($val){$this->type = $val;}
	public function setDate($val){$this->date = $val;}
	public function setTime($val){$this->time = $val;}
	public function setTimestamp($val){$this->timestamp = $val;}
	public function setClientDate($val){$this->localDate = $val;}
	public function setClientTime($val){$this->localTime = $val;}
	public function setClientTimestamp($val){$this->localTimestamp = $val;}
		
	public function __toString()
    {
        return "SnippetID: " . $this->snippetID  . "," . $this->snippetID . "," . $this->title . "," . $this->status . "," . $this->projectID . "," . $this->userID . "," . $this->stageID . "," . $this->questionID . "," . $this->url . "," . $this->snippet . "," . $this->note . "," . $this->type . "," . $this->date . "," . $this->time . "," . $this->timestamp . "," . $this->localDate . "," . $this->localTime . "," . $this->localTimestamp;
    }
}
?>