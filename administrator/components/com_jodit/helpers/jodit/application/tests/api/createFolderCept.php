<?php
/** @var \Codeception\Scenario $scenario */

use Codeception\Util\HttpCode;

$I = new ApiTester($scenario);

$I->wantTo('Try create folder');

$name = 'test' . rand(10000, 100000);

$I->sendGet('?action=folderCreate&source=test&name=' . $name);

$I->seeResponseCodeIs(HttpCode::OK); // 200
$I->seeResponseIsJson();

$I->seeResponseContainsJson([
    "success" => true,
    "data" => [
        "code" => 220,
    ]
]);


$I->sendGet('?action=folderRemove&source=test&name=' . $name); // remove new folder

$I->seeResponseCodeIs(HttpCode::OK); // 200
$I->seeResponseIsJson();

$I->seeResponseContainsJson([
    "success" => true,
    "data" => [
        "code" => 220,
    ]
]);


$I->sendGet('?action=folderCreate&source=test&path=/images/&name=' . $name); // deny create folder for this path

$I->seeResponseCodeIs(HttpCode::OK); // 200
$I->seeResponseIsJson();

$I->seeResponseContainsJson([
	"success" => false,
	"data" => [
		"code" => 403,
	]
]);



