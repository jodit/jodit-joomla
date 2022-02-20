<?php
/** @var \Codeception\Scenario $scenario */

use Codeception\Util\HttpCode;

$I = new ApiTester($scenario);
$files_root = realpath(__DIR__ . '/../files') . '/';

$I->wantTo('Check rename file');

try {
	$I->recurseCopy($files_root . 'folder1', $files_root . 'temp');

	$I->sendGet(
		'?action=folderRename&source=test&name=temp&path=/&newname=folder2'
	);

	$I->seeResponseCodeIs(HttpCode::OK); // 200
	$I->seeResponseIsJson();

	$I->seeResponseContainsJson([
		'success' => true,
		'data' => [
			'code' => 220,
		],
	]);

	$I->assertFileExists($files_root . 'folder2');

	$I->sendGet(
		'?action=folderRename&source=test&name=temp&path=/&newname=folder2'
	);

	$I->seeResponseContainsJson([
		'success' => false,
		'data' => [
			'code' => 404,
		],
	]);

	$I->sendGet(
		'?action=folderRename&source=test&name=folder2&path=/&newname=docs'
	);

	// Because `docs` already exists
	$I->seeResponseContainsJson([
		'success' => false,
		'data' => [
			'code' => 400,
		],
	]);

	$I->sendGet(
		'?action=folderRename&source=test&name=folder2&path=/&newname=temp'
	);

	$I->assertFileExists($files_root . 'temp');
} finally {
	if (realpath($files_root . 'folder2')) {
		$I->recurseRemove($files_root . 'folder2');
	}

	if (realpath($files_root . 'temp')) {
		$I->recurseRemove($files_root . 'temp');
	}
}
