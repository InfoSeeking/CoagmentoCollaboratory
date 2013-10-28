<?php

/* these are general methods meant to provide a starting point for sending authenticated requests to the webservices */

/**
* @param string $url of the webservice location (without trailing slash)
* @param string $path the suffix of where you want the request to go (e.g. "bookmark" or "action")
* @param array $data all of the data to be sent in the data field of the POST request
* @return string the raw output of the API
*/
function sendRequest($url, $path, $data, $userID, $action, $privateKey){
	$data_str = http_build_query($data);
	$hashed_data = sha1($data_str . "|" . $userID . "|" . $privateKey);
	$postData = array("data" => $data_str, "userID" => $userID, "action" => $action, "hashed_data" => $hashed_data);

	$endpoint = $url . "/" . $path;
	$options = array(
	    'http' => array(
	        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
	        'method'  => 'POST',
	        'content' => http_build_query($postData),
	    ),
	);
	$context  = stream_context_create($options);
	$result = file_get_contents($endpoint, false, $context);
	return $result;
}
