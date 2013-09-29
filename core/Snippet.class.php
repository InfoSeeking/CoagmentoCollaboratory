<?php
require_once('Connection.class.php');
require_once('Base.class.php');
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
	public static function retrieveUserSnippets($userID){
		$connection=Connection::getInstance();
		$query = "SELECT * FROM snippets WHERE snippetID=:snippetID";
		$params = array(':snippetID' => $snippetID);
		$results = $connection->execute($query,$params);		
		$record = $results->fetch(PDO::FETCH_ASSOC);
	}
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

	public static function delete($snippetID){
		$connection = Connection::getInstance();
		$query = "DELETE FROM snippets WHERE snippetID=:snippetID";
		$params = array('snippetID' => $snippetID);
		$statement = $connection->execute($query, $params);
		return $statement->rowCount();
	}
		
	public function save()
	{
		try
		{
			$this->projectID = $this->getProjectID();
			
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
	public function getQuestionID(){return $this->questionID;}
	public function getUrl(){return $this->url;}
	public function getSnippet(){return $this->snippet;}
	public function getNote(){return $this->note;}
	public function getType(){return $this->type;}

	//SETTERS
	public function setTitle($val){$this->title = $val;}
	public function setStatus($val){$this->status = $val;}
	public function setQuestionID($val){$this->questionID = $val;}
	public function setUrl($val){$this->url = $val;}
	public function setSnippet($val){$this->snippet = $val;}
	public function setNote($val){$this->note = $val;}
	public function setType($val){$this->type = $val;}
		
	public function __toString()
    {
        return "SnippetID: " . $this->snippetID  . "," . $this->snippetID . "," . $this->title . "," . $this->status . "," . $this->projectID . "," . $this->userID . "," . $this->stageID . "," . $this->questionID . "," . $this->url . "," . $this->snippet . "," . $this->note . "," . $this->type . "," . $this->date . "," . $this->time . "," . $this->timestamp . "," . $this->localDate . "," . $this->localTime . "," . $this->localTimestamp;
    }

    public function toXML(){
    	return "<resource><snippetID>" . $this->snippetID  . "</snippetID><title>" . $this->title . "</title><status>" . $this->status . "</status><projectID>" . $this->projectID . "</projectID><userID>" . $this->userID . "</userID><stageID>" . $this->stageID . "</stageID><questionID>" . $this->questionID . "</questionID><url>" . $this->url . "</url><snippet>" . $this->snippet . "</snippet><note>" . $this->note . "</note><type>" . $this->type . "</type><date>" . $this->date . "</date><time>" . $this->time . "</time><timestamp>" . $this->timestamp . "</timestamp><localDate>" . $this->localDate . "</localDate><localTime>" . $this->localTime . "</localTime><localTimestamp>" . $this->localTimestamp . "</localTimestamp></resource>";
    }
}
?>