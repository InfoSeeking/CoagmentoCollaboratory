<?php
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

if(!isset($_POST['type'])){
	die(err("No type supplied"));
}

parse_str($_POST['data'], $PASSED_DATA);
var_dump($PASSED_DATA);

//TODO authenticate

switch($path){
	case "action":
	case "snippet":
	$class = ucfirst($path) . "Listener";
	$file = $class . ".class.php";
	require_once($file);
	$obj = new $class();
	
	switch($_POST['type']){
		case "GET":
		$obj->get();
		break;
		case "POST":
		$obj->post();
		break;
		case "DELETE":
		$obj->delete();
		break;
		case "PUT":
		$obj->put();
		break;	
	}
	break;
}

?>