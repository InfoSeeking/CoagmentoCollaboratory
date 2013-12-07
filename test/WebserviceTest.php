<?php
require_once("../webservices/requestTools.php");
echo "<h1>A collection of tests using webservices</h1>";
echo "<p>See code for more details</p>";

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


//check if user has a bookmark
echo "<p>Does the user have a bookmark</p>";
$data = array(
	"type" => "user_test",
	"url" => "https://builder.addons.mozilla.org/user/signin/?next=/addon/new/"
);
$response = sendRequest("http://localhost/coagmentoCollaboratory/webservices/index.php", "bookmark", $data, 10, "retrieve", "a94a8fe5ccb19ba61c4c0873d391e987982fbbd3", "json");
echo $response;


//check if user has a bookmark
echo "<p>Adding annotaiton</p>";
$data = array(
	"annotation" => "test",
	"url" => "http://google.com",
	"title" => "google",
	"projectID" => 2
);
$response = sendRequest("http://localhost/coagmentoCollaboratory/webservices/index.php", "annotation", $data, 10, "create", "a94a8fe5ccb19ba61c4c0873d391e987982fbbd3", "json");
echo $response;