<?php
/** @var \Codeception\Scenario $scenario */

use Codeception\Util\HttpCode;

$I = new ApiTester($scenario);

$I->wantTo('Remove image from server');

$I->sendGet('?action=fileUploadRemote&source=test&url=' . urlencode('https://xdsoft.net/jodit/stuf/icon-joomla.png'));
$I->seeResponseContainsJson([
	"success" => true,
	"data" => [
		"code" => 220,
	]
]);

$I->sendGet('?action=fileRemove&source=test&name=icon-joomla.png');

$I->seeResponseCodeIs(HttpCode::OK); // 200
$I->seeResponseIsJson();

$I->seeResponseContainsJson([
    "success" => true,
    "data" => [
        "code" => 220,
    ]
]);


$I->sendGet('?action=fileRemove&source=test&name=icon-joomla.png'); // try remove again

$I->seeResponseCodeIs(HttpCode::OK); // 200
$I->seeResponseIsJson();

$I->seeResponseContainsJson([
    "success" => false,
    "data" => [
        "code" => 404,
    ]
]);



