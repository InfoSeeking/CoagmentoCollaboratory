<?php
require_once('Connection.class.php');
require_once('Base.class.php');
//require_once('Action.class.php');

class Page extends Base
{
	protected $pageID;
	protected $questionID;
	protected $url;
	protected $title;
	protected $source;
	protected $query;
	protected $startTimestamp;
	protected $startDate;
	protected $startTime;
	protected $clientStartTimestamp;
	protected $clientStartDate;
	protected $clientStartTime;
	protected $bookmark;
	protected $snippet;
	protected $status;
	protected $valid;
	protected $endTimestamp;
	protected $endDate;
	protected $endTime;
	protected $clientEndTimestamp;
	protected $clientEndDate;
	protected $clientEndTime;
	  	
	
	//Check user credentials.
	public static function retrieve($pageID)
	{
		try
		{
			$connection=Connection::getInstance();
			$query = "SELECT * FROM pages WHERE pageID=:pageID";
			$params = array(':pageID' => $pageID);
			$results = $connection->execute($query,$params);		
			$record = $results->fetch(PDO::FETCH_ASSOC);

			if ($record) {
				$page = new Page();
				$page->pageID = $record['pageID'];
				$page->userID = $record['userID'];
				$page->projectID = $record['projectID'];
				$page->stageID = $record['stageID'];
				$page->questionID = $record['questionID'];
				$page->url = $record['url'];
				$page->title = $record['title'];
				$page->source = $record['source'];
				$page->query = $record['query'];
				$page->startTimestamp = $record['startTimestamp'];
				$page->startDate = $record['startDate'];
				$page->startTime = $record['startTime'];
				$page->clientStartTimestamp = $record['clientStartTimestamp'];
				$page->clientStartDate = $record['clientStartDate'];
				$page->clientStartTime = $record['clientStartTime'];
				$page->bookmark = $record['bookmark'];
				$page->snippet = $record['snippet'];
				$page->status = $record['status'];
				$page->valid = $record['valid'];
				$page->endTimestamp = $record['endTimestamp'];
				$page->endDate = $record['endDate'];
				$page->endTime = $record['endTime'];
				$page->clientEndTimestamp = $record['clientEndTimestamp'];
				$page->clientEndDate = $record['clientEndDate'];
				$page->clientEndTime = $record['clientEndTime'];
				return $page;
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
			$query = "INSERT INTO pages (`userID`,`projectID`,`stageID`,`questionID`,`url`,`title`,`source`,`query`,`startTimestamp`,`startDate`,`startTime`,`clientStartTimestamp`,`clientStartDate`,`clientStartTime`,`bookmark`,`snippet`,`status`,`valid`,`endTimestamp`,`endDate`,`endTime`,`clientEndTimestamp`,`clientEndDate`,`clientEndTime`) VALUES (:userID,:projectID,:stageID,:questionID,:url,:title,:source,:query,:startTimestamp,:startDate,:startTime,:clientStartTimestamp,:clientStartDate,:clientStartTime,:bookmark,:snippet,:status,:valid,:endTimestamp,:endDate,:endTime,:clientEndTimestamp,:clientEndDate,:clientEndTime)";
			$params = array(':userID' => $this->userID,':projectID' => $this->projectID,':stageID' => $this->stageID,':questionID' => $this->questionID,':url' => $this->url,':title' => $this->title,':source' => $this->source,':query' => $this->query,':startTimestamp' => $this->startTimestamp,':startDate' => $this->startDate,':startTime' => $this->startTime,':clientStartTimestamp' => $this->clientStartTimestamp,':clientStartDate' => $this->clientStartDate,':clientStartTime' => $this->clientStartTime,':bookmark' => $this->bookmark,':snippet' => $this->snippet,':status' => $this->status,':valid' => $this->valid,':endTimestamp' => $this->endTimestamp,':endDate' => $this->endDate,':endTime' => $this->endTime,':clientEndTimestamp' => $this->clientEndTimestamp,':clientEndDate' => $this->clientEndDate,':clientEndTime' => $this->clientEndTime);
			$results = $connection->execute($query,$params);
			$this->pageID = $connection->getLastID();
		}
		catch(Exception $e)
		{
			throw($e);
		}
		return $this->pageID;
	}

	public function getPageID(){return $this->pageID;}
	public function getQuestionID(){return $this->questionID;}
	public function getUrl(){return $this->url;}
	public function getTitle(){return $this->title;}
	public function getSource(){return $this->source;}
	public function getQuery(){return $this->query;}
	public function getStartTimestamp(){return $this->startTimestamp;}
	public function getStartDate(){return $this->startDate;}
	public function getStartTime(){return $this->startTime;}
	public function getClientStartTimestamp(){return $this->clientStartTimestamp;}
	public function getClientStartDate(){return $this->clientStartDate;}
	public function getClientStartTime(){return $this->clientStartTime;}
	public function getBookmark(){return $this->bookmark;}
	public function getSnippet(){return $this->snippet;}
	public function getStatus(){return $this->status;}
	public function getValid(){return $this->valid;}
	public function getEndTimestamp(){return $this->endTimestamp;}
	public function getEndDate(){return $this->endDate;}
	public function getEndTime(){return $this->endTime;}
	public function getClientEndTimestamp(){return $this->clientEndTimestamp;}
	public function getClientEndDate(){return $this->clientEndDate;}
	public function getClientEndTime(){return $this->clientEndTime;}

	public function setQuestionID($val){$this->questionID = $val;}
	public function setUrl($val){$this->url = $val;}
	public function setTitle($val){$this->title = $val;}
	public function setSource($val){$this->source = $val;}
	public function setQuery($val){$this->query = $val;}
	public function setStartTimestamp($val){$this->startTimestamp = $val;}
	public function setStartDate($val){$this->startDate = $val;}
	public function setStartTime($val){$this->startTime = $val;}
	public function setClientStartTimestamp($val){$this->clientStartTimestamp = $val;}
	public function setClientStartDate($val){$this->clientStartDate = $val;}
	public function setClientStartTime($val){$this->clientStartTime = $val;}
	public function setBookmark($val){$this->bookmark = $val;}
	public function setSnippet($val){$this->snippet = $val;}
	public function setStatus($val){$this->status = $val;}
	public function setValid($val){$this->valid = $val;}
	public function setEndTimestamp($val){$this->endTimestamp = $val;}
	public function setEndDate($val){$this->endDate = $val;}
	public function setEndTime($val){$this->endTime = $val;}
	public function setClientEndTimestamp($val){$this->clientEndTimestamp = $val;}
	public function setClientEndDate($val){$this->clientEndDate = $val;}
	public function setClientEndTime($val){$this->clientEndTime = $val;}

	public function __toString()
    {
    	return $this->pageID . "," .$this->questionID . "," .$this->url . "," .$this->title . "," .$this->source . "," .$this->query . "," .$this->startTimestamp . "," .$this->startDate . "," .$this->startTime . "," .$this->clientStartTimestamp . "," .$this->clientStartDate . "," .$this->clientStartTime . "," .$this->bookmark . "," .$this->snippet . "," .$this->status . "," .$this->valid . "," .$this->endTimestamp . "," .$this->endDate . "," .$this->endTime . "," .$this->clientEndTimestamp . "," .$this->clientEndDate . "," .$this->clientEndTime;
    }
}
?>