<?php
/** @var \Codeception\Scenario $scenario */

use Codeception\Util\HttpCode;

$I = new ApiTester($scenario);

$I->wantTo('Get limited items by source');
$I->sendGet('?action=files&mods[limit]=4&source=test');

$resp = json_decode($I->grabResponse());

$I->assertEquals(count($resp->data->sources[0]->files), 4);

$I->sendGet('?action=files&mods[limit]=2&source=test');

$resp = json_decode($I->grabResponse());

$I->assertEquals(count($resp->data->sources[0]->files), 2);
