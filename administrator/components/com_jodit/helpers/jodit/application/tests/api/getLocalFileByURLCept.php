<?php
/** @var \Codeception\Scenario $scenario */

use Codeception\Util\HttpCode;

$I = new ApiTester($scenario);

$I->wantTo('Try get filename by URL');

$I->sendPost('',  [
    'action' => 'getLocalFileByUrl',
    'source' => 'test',
    'url' => 'http://localhost:8081/files/pexels-yuri-manei-2337448.jpg'
]);

$I->seeResponseCodeIs(HttpCode::OK); // 200
$I->seeResponseIsJson();

$I->seeResponseContainsJson([
    "success" => true,
    "data" => [
        "code" => 220,
        "path" => '',
        "name" => 'pexels-yuri-manei-2337448.jpg',
        "source" => 'test',
    ]
]);


