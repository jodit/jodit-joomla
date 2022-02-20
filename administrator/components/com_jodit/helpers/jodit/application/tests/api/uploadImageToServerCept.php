<?php
/** @var \Codeception\Scenario $scenario */

use Codeception\Util\HttpCode;

$I = new ApiTester($scenario);

$I->wantTo('Check uploading image from another site');

$I->sendPost('?',  [
    'action' => 'fileUpload',
    'source' => 'test'
], ['files' => [
    realpath(__DIR__ . '/../files/regina.png'),
    realpath(__DIR__ . '/../test.png'),
    realpath(__DIR__ . '/../files/test.csv'),
]]);

$I->seeResponseCodeIs(HttpCode::OK); // 200
$I->seeResponseIsJson();

$I->seeResponseContainsJson([
    "success" => true,
    "data" => [
        "code" => 220,
        "files" => [
            "regina.png",
            "test.png",
            "test.csv",
        ],
	    "isImages" => [
	    	true,
	    	true,
	    	false
	    ]
    ]
]);


$I->sendPost('',  [
    'action' => 'fileUpload',
    'source' => 'test'
], ['files' => [
    realpath(__DIR__ . '/../config.php')
]]);

$I->seeResponseCodeIs(HttpCode::OK); // 200
$I->seeResponseIsJson();

$I->seeResponseContainsJson([
    "success" => false,
    "data" => [
        "code" => 403,
    ]
]);



$I->sendPost('',  [
    'action' => 'fileUpload',
    'source' => 'folder1' // see config.php and maxfilesize option
], ['files' => [
    realpath(__DIR__ . '/../test.png')
]]);

$I->seeResponseCodeIs(HttpCode::OK); // 200
$I->seeResponseIsJson();

$I->seeResponseContainsJson([
    "success" => false,
    "data" => [
        "code" => 403,
    ]
]);


$I->sendGet('?action=fileRemove&source=test&name=test.png');
$I->seeResponseIsJson();

$I->seeResponseContainsJson([
    "success" => true,
    "data" => [
        "code" => 220
    ]
]);



