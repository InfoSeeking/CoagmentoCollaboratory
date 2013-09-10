<?php
require_once('Connection.class.php');
/*
	Query Class
*/
class Query{
	protected $queryID;
	protected $query; //actual query text
	protected $source;
	protected $url;
	protected $title;
	protected $timestamp;
	protected $topResults;

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
				return $query;
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
			$query = "INSERT INTO queries (query, source, url, title, topResults) VALUES (:query, :source, :url, :title, :topResults)";
			$params = array(':query' => $this->query, ':source' => $this->source, ':url' => $this->url, ':title' => $this->title, ':topResults' => $this->topResults);
			$results = $connection->execute($query,$params);
			$this->queryID = $connection->getLastID();
		}
		catch(Exception e)
		{
			throw($e);
		}
	}

}