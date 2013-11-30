<?php
require_once("../core/Page.class.php");
require_once("WebService.class.php");

class PageListener extends WebService{
	//fetch bookmark from database
	public function retrieve(){
		
	}

	public function create(){
		$url = $this->req("url");
		$title = $this->req("title");
		$projID = $this->req("projectID");
		$startDate = $this->req("startDate");
		$startTime = $this->req("startTime");

		$obj = new Page();

		$obj->setTitle($title);
		$obj->setUrl($url);
		$obj->setUserID($this->userID);
		$obj->setProjectID($projID);
		$obj->setStartDate($startDate);
		$obj->setStartTime($startTime);
		$obj->save();
		//return the new object
		echo $obj->toXML();
	}

	public function delete(){
	}

	public function update(){
	}
}