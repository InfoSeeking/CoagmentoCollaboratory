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
	public static function retrieve($queryID){
		try
		{
			$connection=Connection::getInstance();
			$query = "SELECT * FROM queries WHERE queryID=:queryID";
			$params = array(':queryID' => $queryID);
			$results = $connection->execute($query,$params);		
			$record = $results->fetch(PDO::FETCH_ASSOC);

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
			$params = array(':query' => $this->query, ':source' => $this->source, ':url' => $this->url, ':title' => $this->title, ':topResults' => $this->topResults);
			if($this->inDatabase){
				$query = "UPDATE queries SET `query`=:query, `source`=:source, `url`=:url, `title`=:title, `topResults`=topResults WHERE `queryID`=:queryID";
				$params['queryID'] = $this->queryID;
			}
			else{
				$query = "INSERT INTO queries (query, source, url, title, topResults) VALUES (:query, :source, :url, :title, :topResults)";
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
	public function setQuery($val){$this->query = $val;}
	public function setSource($val){$this->source = $val;}
	public function setUrl($val){$this->url = $val;}
	public function setTitle($val){$this->title = $val;}
	public function setTopResults($val){$this->topResults = $val;}

	public function __toString(){
		return "QueryID: ".$this->queryID." | Query: ".$this->query." | Source: ".$this->source." | Url: ".$this->url . " | Title: " . $this->title . " | Top Results: " . $this->topResults;
	}
}