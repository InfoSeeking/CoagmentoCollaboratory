<?php
require_once("../core/Annotation.class.php");
require_once("WebService.class.php");

class AnnotationListener extends WebService{
	//fetch action from database
	public function retrieve(){
		$id = intval($this->req('id'));
		$obj = Annotation::retrieve($id);
		if($obj != null){
			echo $obj->toXML();
		}
		else{
			die(err("No annotation found"));
		}
	}
	public function create(){
		$obj = new Annotation();		
		$url = $this->req("url");
		$title = $this->req("title");
		$annotation = $this->req("annotation");
		$projID = $this->req("projectID");
		$obj->setUserID($this->userID);
		$obj->setProjectID($projID);
		$obj->setUrl($url);
		$obj->setTitle($title);
		$obj->setAnnotation($annotation);
		$obj->save();
		//return the new object
		echo $obj->toXML();
	}
	public function delete(){
		$id = intval($this->req('id'));
		$result = Annotation::delete($id);
		if($result == 0){
			err("Nothing was deleted");
		}
		else{
			feedback("Deleted");
		}
	}
	public function update(){
		$id = intval($this->req('id'));
		$obj = Annotation::retrieve($id);
	}
}