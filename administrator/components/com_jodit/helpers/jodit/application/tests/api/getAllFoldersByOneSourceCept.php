<?php
/** @var \Codeception\Scenario $scenario */

use Codeception\Util\HttpCode;

$I = new ApiTester($scenario);

$I->wantTo('Get all folders from Test source');
$I->sendGet('?action=folders&source=test&path=folder1');
$I->seeResponseCodeIs(HttpCode::OK); // 200
$I->seeResponseIsJson();

$I->seeResponseContainsJson([
    "success" => true,
    "data" => [
        "code" => 220
    ]
]);

$I->seeResponseJsonMatchesJsonPath('$.data.sources[0].folders');
$I->dontSeeResponseJsonMatchesJsonPath('$.data.sources[1].folders');
