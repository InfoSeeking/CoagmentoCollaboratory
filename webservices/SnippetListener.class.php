<?php
require_once("../core/Snippet.class.php");
class SnippetListener{
	//fetch action from database
	public function get(){
		$id = fetchID();
		$obj = Snippet::retrieve($id);
		if($obj != null){
			echo $obj->toXML();
		}
		else{
			die(err("No snippet found"));
		}
	}
	public function post(){
		$obj = new Snippet();
		
		$obj->save();
		//return the new object
		echo $obj->toXML();
	}
	public function delete(){
		$id = fetchID();
		$result = Snippet::delete($id);
		if($result == 0){
			err("Nothing was deleted");
		}
		else{
			feedback("Deleted");
		}
	}
	//NOT WORKING TODO
	public function put(){
		//get PUT data
		/*
		$PUT = [];
		parse_str(file_get_contents("php://input"),$PUT);
		var_dump($PUT);
		$id = fetchID();
		$result = Action::retrieve($id);
		if($result == null){
			die(err("No action found with id " . $id));
		}
		if(isset($PUT['action'])){
			$result->setAction($PUT['action']);
		}
		if(isset($PUT['value']))
			$result->setValue($PUT['value']);
		if(isset($_PUT['ip']))
			$result->setIP($PUT['ip']);
		$result->save();
		feedback("Action updated");
		*/
	}
	//This function can be used to set values in the Snippet object $obj using the key/value pairs in the associative array $ARR
	//This is so the post and put methods are not redundant
	public function setValues($obj, $ARR){
		if(isset($ARR["title"]))
			$obj->setTitle($ARR["title"]);
		
		
	}
}