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
}