<?php
$I = new ApiTester($scenario);

$I->wantTo('Try get filename by URL');

$I->sendPOST('',  [
    'action' => 'getLocalFileByUrl',
    'source' => 'test',
    'url' => 'http://localhost:8181/files/artio.jpg'
]);

$I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
$I->seeResponseIsJson();

$I->seeResponseContainsJson([
    "success" => true,
    "data" => [
        "code" => 220,
        "path" => '',
        "name" => 'artio.jpg',
        "source" => 'test',
    ]
]);


