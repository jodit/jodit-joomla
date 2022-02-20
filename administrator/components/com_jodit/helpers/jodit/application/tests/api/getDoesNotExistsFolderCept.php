<?php
/** @var \Codeception\Scenario $scenario */

use Codeception\Util\HttpCode;

$I = new ApiTester($scenario);

$I->wantTo('Get not exists folder from source');
$I->sendGet('?action=files&source=test&path=qwerty/qwerty');
$I->seeResponseCodeIs(HttpCode::OK); // 200
$I->seeResponseIsJson();

$I->seeResponseContainsJson([
    "success" => false,
    "data" => [
        "code" => 404
    ]
]);
