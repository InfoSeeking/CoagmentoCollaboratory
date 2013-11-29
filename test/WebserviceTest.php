<?php
require_once("../webservices/requestTools.php");

$key = "40bd001563085fc35165329ea1ff5c5ecbdbbeef"; /* change the key, will no longer authenticate */
$data = array(
	'action' => 'Test action',
	'value' => 'Test action value'
);

echo "<p>Sending authenticated request to webservice to create action</p>";

$response = sendRequest("http://localhost/coagmentoCollaboratory/webservices/index.php", "action", $data, 1, "create", $key);

echo $response;

echo "<p>Action created</p>";

$data = array(
	"username" => "test",
	"password" => "1234"
);

echo "<p> Logging in </p>";
$response = sendRequest("http://localhost/coagmentoCollaboratory/webservices/index.php", "user", $data, 0, "retrieve", "", "json");
echo $response;

echo "<p>Getting projects for user</p>";
$data = array(
	"type" => "user"
);
$response = sendRequest("http://localhost/coagmentoCollaboratory/webservices/index.php", "project", $data, 10, "retrieve", "a94a8fe5ccb19ba61c4c0873d391e987982fbbd3", "json");
echo $response;