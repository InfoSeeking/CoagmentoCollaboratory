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
			echo "Deleted";
		}
	}
	//NOT WORKING TODO
	public function put(){
		//todo
		$id = fetchID();
		$result = Action::retrieve($id);
		if(isset($_PUT['action'])){
			$result->setAction($_PUT['action']);
			echo "ation set";
		}
		if(isset($_PUT['value']))
			$result->setValue($_POST['value']);
		if(isset($_PUT['ip']))
			$result->setIP($_POST['ip']);
		$result->save();
		echo "Action updated";
	}
}