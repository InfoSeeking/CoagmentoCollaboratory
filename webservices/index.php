<?php
require_once("../core/User.class.php");
//I will make a standard XML format for this



function err($msg){
	echo "<response><error>" . $msg . "</error></response>";
}
function feedback($msg){
	echo "<response><feedback>" . $msg . "</feedback></response>";
}

function fetchID(){
	global $URL_PARTS;
	if(sizeof($URL_PARTS) >= 3){
		if(ctype_digit($URL_PARTS[2]))
		{
			return intval($URL_PARTS[2]);
		}
		else{
			die(err("Id is not an integer"));
		}

	}
	else{
		die(err("No id supplied"));
	}
}

/* called on startup */
function init(){
	$u = NULL;//user object
	$uid = -1;//user id
	$passed_data = []; //data passed in the 'data' POST field
	$path = $_SERVER['PATH_INFO'];
	$url_parts = explode("/", $path);

	if(sizeof($url_parts) > 1){
		$path = $url_parts[1];
	}
	else{
		die(err("No path supplied"));
	}

	if(!isset($_POST['action'])){
		die(err("No action supplied"));
	}
	if(!isset($_POST['userID'])){
		die(err("No userID supplied"));
	}
	if(!isset($_POST['data'])){
		die(err("No data supplied"));
	}
	if(!isset($_POST['hashed_data'])){
		die(err("No hashed_data supplied"));
	}

	$uid = intval($_POST['userID']);
	//authentication
	$u = User::retrieve($uid);
	$key = sha1($_POST['data'] . "|" .  $uid . "|" . $u->getKey());
	if($key != $_POST['hashed_data']){
		die(err("User not authenticated, please follow the documentation on sending requests to the web services"));
	}

	parse_str($_POST['data'], $passed_data);

	switch($path){
		case "action":
		case "snippet":
		$class = ucfirst($path) . "Listener";
		$file = $class . ".class.php";
		require_once($file);
		$obj = new $class();
		$obj->setData($passed_data);
		$obj->setUserID($uid);

		switch($_POST['action']){
			case "retrieve":
			$obj->retrieve();
			break;
			case "create":
			$obj->create();
			break;
			case "delete":
			$obj->delete();
			break;
			case "update":
			$obj->update();
			break;	
		}
		break;
	}
}

init();
?>