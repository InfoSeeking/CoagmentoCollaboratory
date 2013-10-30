<?php
require_once("../core/Action.class.php");
require_once("WebService.class.php");

class BookmarkListener extends WebService{
	//fetch bookmark from database
	public function retrieve(){
		$id = intval($this->req('id'));
		$obj = Action::retrieve($id);
		if($obj != null){
			echo $obj->toXML();
		}
		else{
			die(err("No bookmark found"));
		}
	}

	public function create(){
		$url = $this->req("url");
		$title = $this->req("title");
		$projID = $this->req("projectID");
		$note = $this->opt("note");

		$obj = new Bookmark();

		$obj->setTitle($title);
		$obj->setUrl($url);
		$obj->setUserID($this->userID);
		$obj->setProjectID($projID);
		if($note){
			$obj->setNote($note);
		}

		$obj->save();
		//return the new object
		echo $obj->toXML();
	}

	public function delete(){
		$id = intval($this->req('id'));
		$result = Bookmark::delete($id);
		if($result == 0){
			err("Nothing was deleted");
		}
		else{
			feedback("Deleted");
		}
	}

	public function update(){
		$id = intval($this->req('id'));
		$result = Bookmark::retrieve($id);
		if($result == null){
			die(err("No bookmark found with id " . $id));
		}
		if(isset($this->data['url']))
			$result->setUrl($this->data['url']);
		if(isset($this->data['title']))
			$result->setTitle($this->data['title']);
		if(isset($this->data['note']))
			$result->setNote($this->data['note']);
		if(isset($this->data['projectID']))
			$result->setProjectID($this->data['projectID']);
		
		$result->save();
		feedback("Bookmark updated");
	}
}