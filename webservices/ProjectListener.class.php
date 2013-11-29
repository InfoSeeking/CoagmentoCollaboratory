<?php
require_once("../core/Project.class.php");
require_once("WebService.class.php");

class ProjectListener extends WebService{
	//fetch action from database
	public function retrieve(){
		$projID = -1;
		$type = $this->opt("type");
		if(!$type){
			$type = "single";
		}
		if($type == "single"){
			$projID = $this->req("projectID");
		}
		else if($type == "user"){
			//get all projects from one user
			$projects = Project::retrieveAllFromUser($this->userID);
			if($this->datatype == "xml"){
				echo "<resources>";
				foreach($projects as $p){
					echo $p->toXML();
				}
				echo "</resources>";
			}
			else if($this->datatype == "json"){
				$first = true;
				echo "[";
				foreach($projects as $p){
					if(!$first){
						echo ",";
					}
					else{
						$first = false;
					}
					echo $p->toJSON();
				}
				echo "]";
			}
		}
		else{
			die(err("Unknown type of retrieval"));
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