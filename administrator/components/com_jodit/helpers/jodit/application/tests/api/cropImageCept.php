<?php
/** @var \Codeception\Scenario $scenario */

use Codeception\Util\HttpCode;

$I = new ApiTester($scenario);

$I->wantTo('Crop image');

$name = 'test' . rand(10000, 20000);

$I->sendPost('',  [
    'action' => 'imageCrop',
    'source' => 'test',
    'box' => [
        'w' => 30,
        'h' => 30,
        'x' => 5,
        'y' => 5,
    ],
    'name' => 'pexels-yuri-manei-2337448.jpg',
    'newname' => $name
]);

$I->seeResponseCodeIs(HttpCode::OK); // 200
$I->seeResponseIsJson();

$I->seeResponseContainsJson([
    "success" => true,
    "data" => [
        "code" => 220,
    ]
]);


// remove new file
$I->sendGet('?action=fileRemove&source=test&name=' . $name . '.jpg');
$I->seeResponseCodeIs(HttpCode::OK); // 200
$I->seeResponseIsJson();

$I->seeResponseContainsJson([
    "success" => true,
    "data" => [
        "code" => 220,
    ]
]);
