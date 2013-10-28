<?php
require_once("../core/Action.class.php");
require_once("WebService.class.php");

class ActionListener extends WebService{
	//fetch action from database
	public function retrieve(){
		$id = intval($this->data['id']);
		$obj = Action::retrieve($id);
		if($obj != null){
			echo $obj->toXML();
		}
		else{
			die(err("No action found"));
		}
	}
	public function create(){

		//todo
		$action = "";
		$value = "";
		//check for all possible passed values and set the new object
		if(isset($this->data['action'])){
			$action = $this->data['action'];
		}
		else{
			err("Action not set");
		}
		if(isset($this->data['value'])){
			$value = $this->data['value'];
		}
		else{
			err("Value not set");
		}

		$obj = new Action($action, $value);

		if(isset($this->data['ip'])){
			$obj->setIP($this->data['ip']);
		}
		
		$obj->save();
		//return the new object
		echo $obj->toXML();
	}
	public function delete(){
		$id = intval($this->data['id']);
		$result = Action::delete($id);
		if($result == 0){
			err("Nothing was deleted");
		}
		else{
			feedback("Deleted");
		}
	}
	//NOT WORKING TODO
	public function update(){
		$id = intval($this->data['id']);
		$result = Action::retrieve($id);
		if($result == null){
			die(err("No action found with id " . $id));
		}
		if(isset($PUT['action'])){
			$result->setAction($this->data['action']);
		}
		if(isset($PUT['value']))
			$result->setValue($this->data['value']);
		if(isset($_PUT['ip']))
			$result->setIP($this->data['ip']);
		$result->save();
		feedback("Action updated");
	}
}