<?php
require_once("../core/Action.class.php");
class ActionListener{
	//fetch action from database
	public function get(){
		$id = fetchID();
		$obj = Action::retrieve($id);
		echo (string)$obj;
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
		echo (string)$obj;
	}
	public function delete(){
		//todo
	}
	public function put(){
		//todo
	}
}