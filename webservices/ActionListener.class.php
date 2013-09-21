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
	}
	public function delete(){
		//todo
	}
	public function put(){
		//todo
	}
}