<?php
require_once('Connection.class.php');
require_once('Base.class.php');
/*
	Query Class
*/
class Query extends Base{
	protected $queryID;
	protected $query; //actual query text
	protected $source;
	protected $url;
	protected $title;
	protected $timestamp;
	protected $topResults;

	public function __construct(){
		$this->inDatabase = false;
	}
	public static function sqlToObj($record){
		if ($record) {
			$query = new Query();
			$query->queryID = $record['queryID'];
			$query->query = $record['query'];
			$query->source = $record['source'];
			$query->url = $record['url'];
			$query->title = $record['title'];
			$query->timestamp = $record['timestamp'];
			$query->topResults = $record['topResults'];
			$query->inDatabase = true;
			return $query;
		}
	}
	public static function retrieve($queryID){
		try
		{
			$connection=Connection::getInstance();
			$query = "SELECT * FROM queries WHERE queryID=:queryID";
			$params = array(':queryID' => $queryID);
			$results = $connection->execute($query,$params);		
			$record = $results->fetch(PDO::FETCH_ASSOC);

			if ($record) {
				return Query::sqlToObj($record);
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
	* Returns an array of all of the queries belonging to the specified user.
	* @param int $userID
	* @param int $projectID if set, it will only retrieve queries from that specified project
	* @return array Returns an array of Snippet objects
	*/
	public static function retrieveFromUser($userID, $projectID=FALSE){
		$connection=Connection::getInstance();
		$query = "SELECT * FROM queries WHERE userID=:userID";
		$params = array(':userID' => $userID);
		if($projectID){
			$query .= " AND projectID=:projectID";
			$params[":projectID"] = $projectID;
		}
		$queries = [];
		$results = $connection->execute($query,$params);		
		while($record = $results->fetch(PDO::FETCH_ASSOC)){
			array_push($queries, Query::sqlToObj($record));
		}
		return $queries;
	}

	public function save()
	{
		try
		{
			$params = array(':userID' => $this->userID,':projectID' =>$this->projectID, ':time' => $this->time, ':date' => $this->date, ':query' => $this->query, ':source' => $this->source, ':url' => $this->url, ':title' => $this->title, ':topResults' => $this->topResults);
			if($this->inDatabase){
				$query = "UPDATE queries SET `userID`=:userID,`projectID`=:projectID, `date`=:date, `time`=:time, `query`=:query, `source`=:source, `url`=:url, `title`=:title, `topResults`=topResults WHERE `queryID`=:queryID";
				$params['queryID'] = $this->queryID;
			}
			else{
				$query = "INSERT INTO queries (userID, `date`, `time`, `projectID`, query, source, url, title, topResults) VALUES (:userID,:date,:time,:projectID,:query, :source, :url, :title, :topResults)";
			}
			
			$connection = Connection::getInstance();
			$results = $connection->execute($query,$params);
			$this->queryID = $connection->getLastID();
		}
		catch(Exception $e)
		{
			throw($e);
		}
		return $this->queryID;
	}

	public static function delete($queryID){
		$connection = Connection::getInstance();
		$query = "DELETE FROM queries WHERE queryID=:queryID";
		$params = array('queryID' => $queryID);
		$statement = $connection->execute($query, $params);
		return $statement->rowCount();
	}

	//Getters
	public function getQueryID(){return $this->queryID;}
	public function getQuery(){return $this->query;}
	public function getSource(){return $this->source;}
	public function getUrl(){return $this->url;}
	public function getTitle(){return $this->title;}
	public function getTopResults(){return $this->topResults;}


	//setters

	/**
	* extracts the query from the url and sets it
	* @param url String the url which the user is visiting
	* @return mixed Returns false if the url was not a search engine, otherwise it returns the query
	*/
	public function setQuery($url){
		// Parse the URL to extract the source
		$url = str_replace("http://", "", $url); // Remove 'http://' from the reference
		$url = str_replace("com/", "com.", $url);
		$url = str_replace("org/", "org.", $url);
		$url = str_replace("edu/", "edu.", $url);
		$url = str_replace("gov/", "gov.", $url);
		$url = str_replace("us/", "us.", $url);
		$url = str_replace("ca/", "ca.", $url);
		$url = str_replace("uk/", "uk", $url);
		$url = str_replace("es/", "es.", $url);
		$url = str_replace("net/", "net.", $url);

		$queryString = false;
		$se_stuff = array();
		$se_stuff[] = array("google.com", "q", "Google");
		$se_stuff[] = array("google.co.uk", "q", "Google");
		$se_stuff[] = array("ask.com", "q", "Ask.com");
		$se_stuff[] = array("ask.co.uk", "ask", "Ask.co.uk");
		$se_stuff[] = array("comcast.net", "?cat=Web&con=betaa&q", "Comcast");
		$se_stuff[] = array("yahoo", "p", "Yahoo");
		$se_stuff[] = array("yahoo.co.uk", "p", "Yahoo");
		$se_stuff[] = array("aol.com", "query", "AOL");
		$se_stuff[] = array("msn.com", "q", "MSN");
		$se_stuff[] = array("live.com", "q", "Live");	
		$se_stuff[] = array("bing.com", "q", "Bing");	
		$se_stuff[] = array("netscape.com", "query", "Netscape");
		$se_stuff[] = array("netzero.net", "query", "NetZero");
		$se_stuff[] = array("altavista.com", "q", "Altavista");
		$se_stuff[] = array("mywebsearch.com", "searchfor", "Mywebsearch");
		$se_stuff[] = array("alltheweb.com", "q", "Alltheweb");
		$se_stuff[] = array("cnn.com", "query", "CNN");
		$se_stuff[] = array("myspace.com", "q", "MySpace");
		$se_stuff[] = array("wikipedia.org", "search", "Wikipedia");
		$se_stuff[] = array("en.wikipedia.org", "search", "Wikipedia");
		$se_stuff[] = array("searchme.com", "q", "Searchme");

		for($i=0, $size = sizeof($se_stuff); $i < $size; $i++)
		{
			if (stristr($url,$se_stuff[$i][0]) )
			{
				$symbol = $se_stuff[$i][1];
				$temp1 = explode("$symbol=", $url, 2);
				if(sizeof($temp1) == 1){
					return false;
				}
				$temp2 = explode("&", $temp1[1]);
				$string = $temp2[0];
				$queryString = urldecode($string);
			}
		}
		if($queryString){
			$this->query = $queryString;
		}
		return $queryString;
	}
	public function setSource($val){$this->source = $val;}
	public function setUrl($val){$this->url = $val;}
	public function setTitle($val){$this->title = $val;}
	public function setTopResults($val){$this->topResults = $val;}



	public function __toString(){
		return "QueryID: ".$this->queryID." | Query: ".$this->query." | Source: ".$this->source." | Url: ".$this->url . " | Title: " . $this->title . " | Top Results: " . $this->topResults;
	}
}