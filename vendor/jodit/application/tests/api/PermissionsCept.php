<?php 
$I = new ApiTester($scenario);
$I->wantTo('check get permissions for path');


$I->sendGET('?action=permissions&source=test');

$I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
$I->seeResponseIsJson();

$I->seeResponseContainsJson([
	"success" => true,
	"data" => [
		"permissions" => [
			"allowFiles" => true,
	        "allowFileMove" => true,
	        "allowFileUpload" => true,
	        "allowFileUploadRemote" => true,
	        "allowFileRemove" => true,
	        "allowFileRename" => true,
	        "allowFolders" => true,
	        "allowFolderMove" => true,
	        "allowFolderRemove" => true,
	        "allowFolderCreate" => true,
	        "allowFolderRename" => true,
	        "allowImageResize" => true,
	        "allowImageCrop" => true,
        ],
        "code" => 220
    ]

]);


$I->sendGET('?action=permissions&source=test&path=/ceicom/');

$I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
$I->seeResponseIsJson();

$I->seeResponseContainsJson([
	"success" => true,
	"data" => [
		"permissions" => [
			"allowFiles" => true,
			"allowFileMove" => false,
			"allowFileUpload" => false,
			"allowFileUploadRemote" => false,
			"allowFileRemove" => true,
			"allowFileRename" => false,
			"allowFolders" => true,
			"allowFolderMove" => true,
			"allowFolderCreate" => false,
			"allowFolderRemove" => true,
			"allowFolderRename" => true,
			"allowImageResize" => true,
			"allowImageCrop" => true,
		],
		"code" => 220
	]

]);

$I->sendGET('?action=permissions');

$I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
$I->seeResponseIsJson();

$I->seeResponseContainsJson([
	"success" => true,
	"data" => [
		"permissions" => [
			"allowFiles" => true,
			"allowFileMove" => true,
			"allowFileUpload" => true,
			"allowFileUploadRemote" => true,
			"allowFileRemove" => true,
			"allowFileRename" => true,
			"allowFolders" => true,
			"allowFolderMove" => true,
			"allowFolderCreate" => true,
			"allowFolderRemove" => true,
			"allowFolderRename" => true,
			"allowImageResize" => true,
			"allowImageCrop" => true,
		],
		"code" => 220
	]

]);


