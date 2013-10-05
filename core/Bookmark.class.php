<?php
require_once('Connection.class.php');
require_once('Base.class.php');
//require_once('Action.class.php');

class Bookmark extends Base
{
	protected $bookmarkID;
  	protected $url;
  	protected $title;
  	protected $note;
  	protected $status;
	protected $inDatabase;

	public function __construct(){
		$this->inDatabase = false;
	}
	//Check user credentials.
	public static function retrieveFromUser($userID){
		$connection=Connection::getInstance();
		$query = "SELECT * FROM bookmarks WHERE userID=:userID";
		$params = array(':userID' => $userID);
		$results = $connection->execute($query,$params);		
		$records = $results->fetchAll(PDO::FETCH_ASSOC);
		return $records;
	}
	public static function retrieve($bookmarkID)
	{
		try
		{
			$connection=Connection::getInstance();
			$query = "SELECT * FROM bookmarks WHERE bookmarkID=:bookmarkID";
			$params = array(':bookmarkID' => $bookmarkID);
			$results = $connection->execute($query,$params);		
			$record = $results->fetch(PDO::FETCH_ASSOC);

			if ($record) {
				$bookmark = new Bookmark();
				$bookmark->bookmarkID = $record['bookmarkID'];
				$bookmark->title = $record['title'];
				$bookmark->status = $record['status'];
  				$bookmark->projectID = $record['projectID'];
  				$bookmark->userID = $record['userID'];
  				$bookmark->stageID = $record['stageID'];
  				$bookmark->url = $record['url'];
  				$bookmark->note = $record['note'];
  				$bookmark->type = $record['type'];
				$bookmark->date = $record['date'];
				$bookmark->time = $record['time'];
				$bookmark->timestamp = $record['timestamp'];
				$bookmark->localDate = $record['clientDate'];
				$bookmark->localTime = $record['clientTime'];
				$bookmark->localTimestamp = $record['clientTimestamp'];
				$bookmark->inDatabase = true;
				return $bookmark;
			}
			else
				return null;
		}
		catch(Exception $e)
		{
			throw($e);
		}
	}

	public static function delete($bookmarkID){
		$connection = Connection::getInstance();
		$query = "DELETE FROM bookmarks WHERE bookmarkID=:bookmarkID";
		$params = array('bookmarkID' => $bookmarkID);
		$statement = $connection->execute($query, $params);
		return $statement->rowCount();
	}
		
	public function save()
	{
		try
		{
			$this->projectID = $this->getProjectID();
			$connection=Connection::getInstance();
			$params = array(':title' => $this->title,':status' => $this->status,':projectID' => $this->projectID,':userID' => $this->userID,':stageID' => $this->stageID,':url' => $this->url,':note' => $this->note,':date' => $this->date,':time' => $this->time,':timestamp' => $this->timestamp,':clientDate' => $this->localDate,':clientTime' => $this->localTime,':clientTimestamp' => $this->localTimestamp);
			if(!$this->inDatabase){
				$query = "INSERT INTO bookmarks (`title`,`status`,`projectID`,`userID`,`stageID`,`url`,`note`,`date`,`time`,`timestamp`,`clientDate`,`clientTime`,`clientTimestamp`) VALUES (:title,:status,:projectID,:userID,:stageID,:url,:note,:date,:time,:timestamp,:clientDate,:clientTime,:clientTimestamp)";
			}
			else{
				$query = "UPDATE bookmarks SET  `title` = :title, `status` = :status, `projectID` = :projectID, `userID` = :userID, `stageID` = :stageID, `url` = :url,  `note` = :note, `date` = :date, `time` = :time, `timestamp` = :timestamp, `clientDate` = :clientDate, `clientTime` = :clientTime, `clientTimestamp` = :clientTimestamp WHERE `bookmarkID`=:bookmarkID";
				$params['bookmarkID'] = $this->bookmarkID;
			}
			
			$results = $connection->execute($query,$params);
			$this->bookmarkID = $connection->getLastID();
			$this->inDatabase = true;
		}
		catch(Exception $e)
		{
			throw($e);
		}
		return $this->bookmarkID;
	}
	
	//GETTERS	
	public function getBookmarkID(){return $this->bookmarkID;}
	public function getTitle(){return $this->title;}
	public function getStatus(){return $this->status;}
	public function getUrl(){return $this->url;}
	public function getNote(){return $this->note;}

	//SETTERS
	public function setTitle($val){$this->title = $val;}
	public function setStatus($val){$this->status = $val;}
	public function setUrl($val){$this->url = $val;}
	public function setNote($val){$this->note = $val;}
		
	public function __toString()
    {
        return "BookmarkID: " . $this->bookmarkID  . "," . $this->bookmarkID . "," . $this->title . "," . $this->status . "," . $this->projectID . "," . $this->userID . "," . $this->stageID . "," . $this->url . "," . $this->note . "," . $this->date . "," . $this->time . "," . $this->timestamp . "," . $this->localDate . "," . $this->localTime . "," . $this->localTimestamp;
    }

    public function toXML(){
    	return "<resource><bookmarkID>" . $this->bookmarkID  . "</bookmarkID><title>" . $this->title . "</title><status>" . $this->status . "</status><projectID>" . $this->projectID . "</projectID><userID>" . $this->userID . "</userID><stageID>" . $this->stageID . "</stageID><url>" . $this->url . "</url><note>" . $this->note . "</note><date>" . $this->date . "</date><time>" . $this->time . "</time><timestamp>" . $this->timestamp . "</timestamp><localDate>" . $this->localDate . "</localDate><localTime>" . $this->localTime . "</localTime><localTimestamp>" . $this->localTimestamp . "</localTimestamp></resource>";
    }
}
?>