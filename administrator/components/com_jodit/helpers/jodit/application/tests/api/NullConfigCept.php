<?php
/** @var \Codeception\Scenario $scenario */

use Codeception\Util\HttpCode;

$I = new ApiTester($scenario);

$I->wantTo('Get all files root and config without source field');
$I->sendGet('?action=files&custom_config=' . rawurlencode(json_encode([
	'sources' => null
])));

$I->seeResponseCodeIs(HttpCode::OK); // 200
$I->seeResponseIsJson();

$I->seeResponseContainsJson([
	"success" => true,
	"data" => [
		"code" => 220
	]
]);

$I->seeResponseJsonMatchesJsonPath('$.data.sources[?(@.name=="default")].files[0].file');
