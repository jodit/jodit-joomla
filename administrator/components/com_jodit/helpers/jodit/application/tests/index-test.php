<?php
if (!in_array(@$_SERVER['REMOTE_ADDR'], ['172.17.0.1', '127.0.0.1', '::1', '[::1]'])) {
	die('You are not allowed to access this file.');
}

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/TestApplication.php';

$config = require(__DIR__ . "/config.php");

if (isset($_GET['custom_config']) and json_decode($_GET['custom_config'])) {
	$config = array_merge($config, json_decode($_GET['custom_config'], true));
}

ini_set('memory_limit', '256M');

$fileBrowser = new JoditRestTestApplication($config);

try {
	$fileBrowser->checkAuthentication();
	$fileBrowser->execute();
} catch(\Exception $e) {
	$fileBrowser->exceptionHandler($e);
}
