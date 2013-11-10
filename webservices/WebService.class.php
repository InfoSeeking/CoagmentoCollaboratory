<?php
/* parent class for all webservices */
class WebService{
	protected $userID = -1;
	protected $data = NULL;
	public function setData($val){
		$this->data = $val;
	}
	public function setUserID($val){
		$this->userID = $val;
	}
	public function retrieve(){}
	public function create(){}
	public function delete(){}
	public function update(){}

	/* Enforces that a field be passed via data */
	public function req($field){
		if(isset($this->data) && isset($this->data[$field])){
			return $this->data[$field];
		}
		die(err("Field " . $field . " is required"));
	}
	/* Similar to req, but returns null if field not found. Means a field is optional */
	public function opt($field){
		if(isset($this->data) && isset($this->data[$field])) {
			return $this->data[$field];
		}
		return NULL;
	}
}