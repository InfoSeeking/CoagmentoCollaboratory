<?php
require_once('Connection.class.php');
require_once('Base.class.php');
//require_once('Action.class.php');

class Annotation extends Base
{
	protected $annotationID;
  	protected $url;
  	protected $title;
  	protected $annotation;
  	protected $type;
	protected $inDatabase;

	public function __construct(){
		$this->inDatabase = false;
	}
	public static function sqlToObj($record){
		if ($record) {
			$annotation = new Annotation();
			$annotation->annotationID = $record['annotationID'];
			$annotation->title = $record['title'];
			$annotation->projectID = $record['projectID'];
			$annotation->userID = $record['userID'];
			$annotation->url = $record['url'];
			$annotation->annotation = $record['annotation'];
			$annotation->date = $record['date'];
			$annotation->time = $record['time'];
			$annotation->inDatabase = true;
			return $annotation;
		}
	}
	/**
	* Returns an array of all of the annotations belonging to the specified user.
	* @param int $userID
	* @param int $projectID if set, it will only retrieve annotations from that specified project
	* @return array Returns an array of Annotation objects
	*/
	public static function retrieveFromUser($userID, $projectID=FALSE){
		$connection=Connection::getInstance();
		$query = "SELECT * FROM annotations WHERE userID=:userID";
		$params = array(':userID' => $userID);
		if($projectID){
			$query .= " AND projectID=:projectID";
			$params[":projectID"] = $projectID;
		}
		$annotations = [];
		$results = $connection->execute($query,$params);		
		while($record = $results->fetch(PDO::FETCH_ASSOC)){
			array_push($annotations, Annotation::sqlToObj($record));
		}
		return $annotations;
	}
	public static function retrieve($annotationID)
	{
		try
		{
			$connection=Connection::getInstance();
			$query = "SELECT * FROM annotations WHERE annotationID=:annotationID";
			$params = array(':annotationID' => $annotationID);
			$results = $connection->execute($query,$params);		
			$record = $results->fetch(PDO::FETCH_ASSOC);

			if ($record) {
				return Annotation::sqlToObj($record);//return new annotation object from the sql row
			}
			else
				return null;
		}
		catch(Exception $e)
		{
			throw($e);
		}
	}

	public static function delete($annotationID){
		$connection = Connection::getInstance();
		$query = "DELETE FROM annotations WHERE annotationID=:annotationID";
		$params = array('annotationID' => $annotationID);
		$statement = $connection->execute($query, $params);
		return $statement->rowCount();
	}
		
	public function save()
	{
		try
		{
			$this->projectID = $this->getProjectID();
			$connection=Connection::getInstance();
			$params = array(':title' => $this->title,':projectID' => $this->projectID,':userID' => $this->userID,':url' => $this->url,':annotation' => $this->annotation,':date' => $this->date,':time' => $this->time);
			if(!$this->inDatabase){
				$query = "INSERT INTO annotations (`title`,`projectID`,`userID`,`url`,`annotation`,`date`,`time`) VALUES (:title,:projectID,:userID,:url,:annotation,:date,:time)";
			}
			else{
				$query = "UPDATE annotations SET  `title` = :title, `projectID` = :projectID, `userID` = :userID, `url` = :url, `annotation` = :annotation, `date` = :date, `time` = :time, WHERE `annotationID`=:annotationID";
				$params['annotationID'] = $this->annotationID;
			}
			

			$results = $connection->execute($query,$params);
			$this->annotationID = $connection->getLastID();
			$this->inDatabase = true;
		}
		catch(Exception $e)
		{
			throw($e);
		}
		return $this->annotationID;
	}
	
	//GETTERS	
	public function getAnnotationID(){return $this->annotationID;}
	public function getTitle(){return $this->title;}
	public function getUrl(){return $this->url;}
	public function getAnnotation(){return $this->annotation;}

	//SETTERS
	public function setTitle($val){$this->title = $val;}
	public function setUrl($val){$this->url = $val;}
	public function setAnnotation($val){$this->annotation = $val;}
		
	public function __toString()
    {
        return "AnnotationID: " . $this->annotationID  . "," . $this->annotationID . "," . $this->title . "," . $this->projectID . "," . $this->userID . "," .  $this->url . "," . $this->annotation . "," . $this->date . "," . $this->time;
    }

    public function toXML(){
    	return "<resource><annotationID>" . $this->annotationID  . "</annotationID><title>" . $this->title . "</title><projectID>" . $this->projectID . "</projectID><userID>" . $this->userID . "</userID><url>" . $this->url . "</url><annotation>" . $this->annotation . "</annotation><date>" . $this->date . "</date><time>" . $this->time . "</time></resource>";
    }
}
?>