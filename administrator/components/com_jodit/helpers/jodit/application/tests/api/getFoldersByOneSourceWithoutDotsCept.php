<?php
/** @var \Codeception\Scenario $scenario */

use Codeception\Util\HttpCode;

$I = new ApiTester($scenario);

$I->wantTo('Get all folders from Test source');

$I->sendGet('?action=folders&source=test&path=folder1&dots=false');
$json = json_decode($I->grabResponse());

$I->assertNotContains('..', $json->data->sources[0]->folders);
