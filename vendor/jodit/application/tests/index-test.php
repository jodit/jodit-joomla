<?php
if (!in_array(@$_SERVER['REMOTE_ADDR'], ['127.0.0.1', '::1'])) {
	die('You are not allowed to access this file.');
}

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/TestApplication.php';


$config = require(__DIR__ . "/config.php");


$fileBrowser = new JoditRestTestApplication($config);

try {
	$fileBrowser->checkAuthentication();
	$fileBrowser->execute();
} catch(\Exception $e) {
	$fileBrowser->exceptionHandler($e);
}