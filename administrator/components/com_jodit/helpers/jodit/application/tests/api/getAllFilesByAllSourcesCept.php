<?php
/** @var \Codeception\Scenario $scenario */

use Codeception\Util\HttpCode;

$I = new ApiTester($scenario);

$I->wantTo('Get all items from all sources');
$I->sendGet('?action=files');
$I->seeResponseCodeIs(HttpCode::OK); // 200
$I->seeResponseIsJson();

$I->seeResponseContainsJson([
    "success" => true,
    "data" => [
        "code" => 220
    ]
]);

$I->seeResponseJsonMatchesJsonPath('$.data.sources[?(@.name=="test")].files[0].file');
$I->seeResponseJsonMatchesJsonPath('$.data.sources[?(@.name=="folder1")].files[0].file');
$I->seeResponseJsonMatchesJsonPath('$.data.sources[?(@.name=="folder1")].files[0].isImage');
$I->seeResponseJsonMatchesJsonPath('$.data.sources[?(@.name=="folder1")].files[0].changed');
$I->seeResponseJsonMatchesJsonPath('$.data.sources[?(@.name=="folder1")].files[0].thumb');
