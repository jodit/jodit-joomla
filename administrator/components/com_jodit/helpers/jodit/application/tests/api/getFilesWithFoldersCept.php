<?php
/** @var \Codeception\Scenario $scenario */

use Codeception\Util\HttpCode;

$I = new ApiTester($scenario);

$I->wantTo('Get items with folders');

$I->sendGet('?action=files&mods[withFolders]=true&source=test');
$I->seeResponseJsonMatchesJsonPath(
	'$.data.sources[?(@.name=="test")].files[?(@.type=="folder")]'
);

$I->sendGet(
	'?action=files&mods[withFolders]=true&mods[foldersPosition]=top&source=test'
);
$resp = json_decode($I->grabResponse());
$I->assertEquals($resp->data->sources[0]->files[0]->type, 'folder');

$I->sendGet(
	'?action=files&mods[withFolders]=true&mods[foldersPosition]=bottom&source=test'
);
$resp = json_decode($I->grabResponse());
$I->assertEquals(
	$resp->data->sources[0]->files[count($resp->data->sources[0]->files) - 1]
		->type,
	'folder'
);
