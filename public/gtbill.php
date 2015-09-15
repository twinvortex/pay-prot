<?php

require __DIR__ . '/../includes/Htpasswd.php'; // add htpasswd manager class
require __DIR__ . '/../includes/Response.php'; // add response functions
require __DIR__ . '/../includes/Logger.php'; // add logger function

$config = (object) require __DIR__ . '/../includes/config.php';

$htpasswd = new Htpasswd($config->passwd_file); // the location of the htpassword

$res = new Response($config->use_encryption, $config->encryption_key); // add a new response
$logger = new Logger($config->log, $config->log_file); // log to file, it's true by default -> can be modified in config.php file

$ip_error = true;

$request = (object) $_REQUEST; // set request to be an object
$requestData = print_r($_REQUEST, 1);

foreach($config->allowed_gtbill_ips as $ip) {
    if($_SERVER['REMOTE_HOST'] == $ip) {
        $ip_error = false;
        break;
    } else {
        $ip_error = true;
    }
}

if($ip_error)
    return $res->response($logger->log('0:Invalid IP address', $requestData));

switch($request->action) {
	case 'Check':
		if(empty($request->Username))
			return $res->response($logger->log('0:Incomplete information provided', $requestData));

		if($htpasswd->userExists($request->Username)) {
			return $res->response($logger->log('1:User exists', $requestData));
		} else {
			return $res->response($logger->log('0:User does not exist', $requestData));
		}

		break;

	case 'Add':
	case 'ReAdd':
		if($request->key != $config->gtbill_key)
			return $res->response($logger->log('0:Invalid gtbill key', $requestData));

		if(empty($request->Username) || empty($request->Password))
			return $res->response($logger->log('0:Incomplete information provided', $requestData));

		if($htpasswd->userExists($request->Username)) {
			return $res->response($logger->log('1:User exists', $requestData));
		}

		if($htpasswd->addUser($request->Username, $request->Password)) {
			return $res->response($logger->log('1:User added successfully', $requestData));
		} else {
			return $res->response($logger->log('0:Unable to add user to password file', $requestData));
		}

		break;

	case 'Cancel':
	case 'Deactivate':
		if(empty($request->Username))
			return $res->response($logger->log('0:Incomplete information provided', $requestData));

		if(!$htpasswd->userExists($request->Username))
			return $res->response($logger->log('0:Unable to find user to cancel/deactivate', $requestData));

		if($htpasswd->deleteUser($request->Username))
			return $res->response($logger->log('1:User cancelled/deactivated successfully', $requestData));

		break;

	case 'Password':
		if(empty($request->Username))
			return $res->response($logger->log('0:Incomplete information provided', $requestData));

		if($htpasswd->updateUser($request->Username, $request->Password))
			return $res->response($logger->log('1:User\'s password changed successfully', $requestData));

		break;

	default:
		return $res->response($logger->log('0:No valid action was provided', $requestData));
		break;
}
