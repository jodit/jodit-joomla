<?php 
$I = new ApiTester($scenario);
$I->wantTo('Check bad action');

$I->sendGET('?action=blabla'); // see file TestApplication.php
$I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
$I->seeResponseIsJson();

$I->seeResponseContainsJson([
	"success" => false,
	"data" => [
		"code" => 404,
	]
]);

$I->assertEquals(true, preg_match('#Action \\\\"blabla\\\\" not found#usi', $I->grabResponse()));

$I->sendGET('?action=<script>alert(1)</script>'); // see file TestApplication.php
$I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
$I->seeResponseIsJson();

$I->seeResponseContainsJson([
	"success" => false,
	"data" => [
		"code" => 404,
	]
]);

$I->assertEquals(true, preg_match('#Bad action#usi', $I->grabResponse()));

