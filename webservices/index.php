<?php
require_once("../core/User.class.php");
//I will make a standard XML format for this

$PASSED_DATA = []; //data passed in the 'data' POST field

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

$path = $_SERVER['PATH_INFO'];
$URL_PARTS = explode("/", $path);

if(sizeof($URL_PARTS) > 1){
	$path = $URL_PARTS[1];
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

parse_str($_POST['data'], $PASSED_DATA);
var_dump($PASSED_DATA);

$uid = intval($_POST['userID']);
//authentication
$u = User::retrieve($uid);
$key = sha1($_POST['data'] . "|" .  $_POST['userID'] . "|" . $u->getKey());
if($key != $_POST['hashed_data']){
	die(err("User not authenticated, please follow the documentation on sending requests to the web services"));
}

exit("Authentic");

switch($path){
	case "action":
	case "snippet":
	$class = ucfirst($path) . "Listener";
	$file = $class . ".class.php";
	require_once($file);
	$obj = new $class();
	$obj->setData($_POST['data']);
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

?>