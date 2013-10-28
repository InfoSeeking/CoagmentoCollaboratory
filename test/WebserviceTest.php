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