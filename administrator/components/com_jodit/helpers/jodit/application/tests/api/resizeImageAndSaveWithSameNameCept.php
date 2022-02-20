<?php
/** @var \Codeception\Scenario $scenario */

use Codeception\Util\HttpCode;

$I = new ApiTester($scenario);

$I->wantTo('Resize image and save it with same name');

$name = 'test' . rand(10000, 20000);
copy(__DIR__ . '/../files/pexels-yuri-manei-2337448.jpg', __DIR__ . '/../files/' . $name . '.jpg');

$I->sendPost('',  [
    'action' => 'imageResize',
    'source' => 'test',
    'box' => [
        'w' => 30,
        'h' => 30,
    ],
    'name' => $name . '.jpg',
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




$path = realpath(__DIR__ . '/../files/' . $name . '.jpg');

$I->assertNotEmpty($path);

$info = getimagesize($path);

$I->assertEquals(30, (int)$info[0]);

unlink($path);
