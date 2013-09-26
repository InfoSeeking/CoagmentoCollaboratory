<?php
require_once("../core/Action.class.php");
class ActionListener{
	//fetch action from database
	public function get(){
		$id = fetchID();
		$obj = Action::retrieve($id);
		echo $obj->toXML();
	}
	public function post(){

		//todo
		$action = "";
		$value = "";
		//check for all possible passed values and set the new object
		if(isset($_POST['action'])){
			$action = $_POST['action'];
		}
		else{
			err("Action not set");
		}
		if(isset($_POST['value'])){
			$value = $_POST['value'];
		}
		else{
			err("Value not set");
		}

		$obj = new Action($action, $value);

		if(isset($_POST['ip'])){
			$obj->setIP($_POST['ip']);
		}
		
		$obj->save();
		//return the new object
		echo $obj->toXML();
	}
	public function delete(){
		$id = fetchID();
		$result = Action::delete($id);
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
	}
}