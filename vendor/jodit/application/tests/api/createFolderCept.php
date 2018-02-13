<?php
$I = new ApiTester($scenario);

$I->wantTo('Try create folder');

$name = 'test' . rand(10000, 100000);

$I->sendGET('?action=folderCreate&source=test&name=' . $name);

$I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
$I->seeResponseIsJson();

$I->seeResponseContainsJson([
    "success" => true,
    "data" => [
        "code" => 220,
    ]
]);


$I->sendGET('?action=folderRemove&source=test&name=' . $name); // remove new folder

$I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
$I->seeResponseIsJson();

$I->seeResponseContainsJson([
    "success" => true,
    "data" => [
        "code" => 220,
    ]
]);


$I->sendGET('?action=folderCreate&source=test&path=/ceicom/&name=' . $name); // deny create folder for this path

$I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
$I->seeResponseIsJson();

$I->seeResponseContainsJson([
	"success" => false,
	"data" => [
		"code" => 403,
	]
]);



