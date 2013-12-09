<?php
require_once("../core/Query.class.php");
require_once("WebService.class.php");

class QueryListener extends WebService{
	//fetch bookmark from database
	public function retrieve(){
		
	}

	public function create(){
		$url = $this->req("url");
		$title = $this->req("title");
		$projID = $this->req("projectID");
		$date = $this->req("date");
		$time = $this->req("time");

		$obj = new Query();
		$ret = $obj->setQuery($url);
		if($ret === false){
			die(err("Not a query page"));
		}
		$obj->setTitle($title);
		$obj->setUrl($url);
		$obj->setUserID($this->userID);
		$obj->setProjectID($projID);
		$obj->setTime($time);
		$obj->setDate($date);
		$obj->save();
		//return the new object
		echo $obj->toXML();
	}

	public function delete(){
	}

	public function update(){
	}
}