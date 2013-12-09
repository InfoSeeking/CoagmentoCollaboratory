<?php
require_once("../core/User.class.php");
//I will make a standard XML format for this

$dtype = "xml";

function err($msg){
	global $dtype;
	if($dtype == "xml"){
		echo "<response><error>" . $msg . "</error></response>";
	}
	else if($dtype == "json"){
		echo '{ "error" : "' . $msg . '"}';
	}
}
function feedback($msg){
	global $dtype;
	if($dtype == "xml"){
		echo "<response><feedback>" . $msg . "</feedback></response>";
	}
	else if($dtype == "json"){
		echo '{ "feedback" : "' . $msg . '"}';
	}
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
/* if the path is user, it does not require authentication as the user does not have the private key */
function init(){
	global $dtype;
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
	if(!isset($_POST['userID']) && $path != "user"){
		die(err("No userID supplied"));
	}
	if(!isset($_POST['data'])){
		die(err("No data supplied"));
	}
	if(!isset($_POST['hashed_data']) && $path != "user"){
		die(err("No hashed_data supplied"));
	}

	$uid = intval($_POST['userID']);
	//authentication
	if($path != "user"){
		$u = User::retrieve($uid);
		$key = sha1($_POST['data'] . "|" .  $uid . "|" . $u->getKey());
		if($key != $_POST['hashed_data']){
			die(err("User not authenticated, please follow the documentation on sending requests to the web services"));
		}
	}

	parse_str($_POST['data'], $passed_data);

	switch($path){
		case "action":
		case "snippet":
		case "bookmark":
		case "user":
		case "project":
		case "page":
		case "annotation":
		case "query":
		$class = ucfirst($path) . "Listener";
		$file = $class . ".class.php";
		require_once($file);
		$obj = new $class();
		if(isset($_POST['datatype'])){
			$dt = $_POST['datatype'];
			if($dt == "xml" || $dt = "json"){
				$dtype = $dt;
				$obj->setDataType($dt);
			}
		}
		$obj->setData($passed_data);
		if($path != "user"){
			$obj->setUserID($uid);
		}

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