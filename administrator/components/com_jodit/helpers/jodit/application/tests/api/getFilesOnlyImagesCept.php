<?php
/** @var \Codeception\Scenario $scenario */

use Codeception\Util\HttpCode;

$I = new ApiTester($scenario);

$I->wantTo('Get files only images');
$I->sendGet('?action=files&mods[onlyImages]=true');
$I->dontSeeResponseJsonMatchesJsonPath('$.data.sources[?(@.name=="test")].files[?(@.type=="file")]');

$I->sendGet('?action=files&mods[onlyImages]=false');
$I->seeResponseJsonMatchesJsonPath('$.data.sources[?(@.name=="test")].files[?(@.type=="file")]');
