<?php
/** @var \Codeception\Scenario $scenario */

use Codeception\Util\HttpCode;

$I = new ApiTester($scenario);

$I->wantTo('Check uploading remote image from another site');

$I->sendGet('?action=fileUploadRemote&source=test&url=' . urlencode('http://xdsoft.net/jodit/stuf/icon-joomla.png1'));
$I->seeResponseCodeIs(HttpCode::OK); // 200
$I->seeResponseIsJson();

$I->seeResponseContainsJson([
    "success" => false,
    "data" => [
        "code" => 400
    ]
]);

$I->sendGet('?action=fileUploadRemote&source=test&url=' . urlencode('icon-joomla.png'));
$I->seeResponseCodeIs(HttpCode::OK); // 200
$I->seeResponseIsJson();

$I->seeResponseContainsJson([
    "success" => false,
    "data" => [
        "code" => 400
    ]
]);


$I->sendGet('?action=fileUploadRemote&source=test&url=' . urlencode('http://xdsoft.net/jodit/stuf/icon-joomla.png'));
$I->seeResponseCodeIs(HttpCode::OK); // 200
$I->seeResponseIsJson();

$I->seeResponseContainsJson([
    "success" => true,
    "data" => [
        "code" => 220
    ]
]);

$I->seeResponseJsonMatchesXpath('//data/newfilename');


$I->sendGet('?action=fileRemove&source=test&name=icon-joomla.png');
$I->seeResponseIsJson();

$I->seeResponseContainsJson([
    "success" => true,
    "data" => [
        "code" => 220
    ]
]);





