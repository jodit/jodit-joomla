<?php
/** @var \Codeception\Scenario $scenario */

use \Codeception\Util\HttpCode;

$I = new ApiTester($scenario);
$I->wantTo('Check bad action');

$I->sendGet('?action=blabla'); // see file TestApplication.php
$I->seeResponseCodeIs(HttpCode::OK); // 200
$I->seeResponseIsJson();

$I->seeResponseContainsJson([
	"success" => false,
	"data" => [
		"code" => 404,
	]
]);

$I->assertEquals(true, preg_match('#Action \\\\"blabla\\\\" not found#usi', $I->grabResponse()));

$I->sendGet('?action=<script>alert(1)</script>'); // see file TestApplication.php
$I->seeResponseCodeIs(HttpCode::OK); // 200
$I->seeResponseIsJson();

$I->seeResponseContainsJson([
	"success" => false,
	"data" => [
		"code" => 404,
	]
]);

$I->assertEquals(true, preg_match('#not found#usi', $I->grabResponse()));

