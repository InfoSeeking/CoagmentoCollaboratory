<?php
require_once("../core/Action.class.php");
require_once("WebService.class.php");

class ActionListener extends WebService{
	//fetch action from database
	public function retrieve(){
		$id = intval($this->req('id'));
		$obj = Action::retrieve($id);
		if($obj != null){
			echo $obj->toXML();
		}
		else{
			die(err("No action found"));
		}
	}

	public function create(){
		$action = $this->req("action");
		$value = $this->req("value");
		$ip = $this->opt("ip");
		
		$obj = new Action($action, $value);

		if($ip){
			$obj->setIP($this->data['ip']);
		}

		$obj->setUserID($this->userID);
		
		$obj->save();
		//return the new object
		echo $obj->toXML();
	}
	public function delete(){
		$id = intval($this->req('id'));
		$result = Action::delete($id);
		if($result == 0){
			err("Nothing was deleted");
		}
		else{
			feedback("Deleted");
		}
	}

	public function update(){
		$id = intval($this->req('id'));
		$result = Action::retrieve($id);
		if($result == null){
			die(err("No action found with id " . $id));
		}
		if(isset($this->data['action'])){
			$result->setAction($this->data['action']);
		}
		if(isset($this->data['value']))
			$result->setValue($this->data['value']);
		if(isset($this->data['ip']))
			$result->setIP($this->data['ip']);
		$result->save();
		feedback("Action updated");
	}
}