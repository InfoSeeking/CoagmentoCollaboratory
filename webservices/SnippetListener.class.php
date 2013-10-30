<?php
require_once("../core/Snippet.class.php");
require_once("WebService.class.php");

class SnippetListener extends WebService{
	//fetch action from database
	public function retrieve(){
		$id = intval($this->req('id'));
		$obj = Snippet::retrieve($id);
		if($obj != null){
			echo $obj->toXML();
		}
		else{
			die(err("No snippet found"));
		}
	}
	public function create(){
		$obj = new Snippet();		
		$obj->save();
		//return the new object
		echo $obj->toXML();
	}
	public function delete(){
		$id = intval($this->req('id'));
		$result = Snippet::delete($id);
		if($result == 0){
			err("Nothing was deleted");
		}
		else{
			feedback("Deleted");
		}
	}
	public function update(){
		$id = intval($this->req('id'));
		$obj = Snippet::retrieve($id);
	}
}