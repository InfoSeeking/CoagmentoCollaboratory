<?php
require_once("../core/User.class.php");
require_once("WebService.class.php");

class UserListener extends WebService{
	//fetch action from database
	public function retrieve(){
		$uname = $this->req("username");
		$pass = $this->req("password");
		$u = User::login($uname, $pass);
		if($u != null){
			if($this->datatype == "xml"){
				echo $u->toXML();
			}
			else if($this->datatype == "json"){
				echo $u->toJSON();
			}
		}
		else{
			die(err("Could not login"));
		}
	}

	public function create(){
		//to be implemented
	}
	public function delete(){
		//to be implemented
	}
	public function update(){
		//to be implemented
	}
}