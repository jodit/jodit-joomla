<?php
/** @var \Codeception\Scenario $scenario */

use Codeception\Util\HttpCode;

$I = new ApiTester($scenario);
$files_root = realpath(__DIR__ . '/../files') . '/folder1/subfolder/';
$filename = 'pexels-pixabay-262113.jpg';
$I->wantTo('Check download file');

$I->sendGet(
	'?action=fileDownload&source=test&name=' .
		$filename .
		'&path=folder1/subfolder'
);

$I->seeResponseCodeIs(HttpCode::OK); // 200
$I->seeHttpHeader('Content-Description', 'File Transfer');
$I->seeHttpHeader('Content-Type', 'application/octet-stream');
$I->seeHttpHeader('Content-Disposition', 'attachment; filename=' . $filename);
$I->seeHttpHeader('Content-Transfer-Encoding', 'binary');
$I->seeHttpHeader('Expires', '0');
$I->seeHttpHeader(
	'Cache-Control',
	'must-revalidate, post-check=0, pre-check=0'
);
$I->seeHttpHeader('Pragma', 'public');
$I->seeHttpHeader('Content-Length', filesize($files_root . $filename));

$I->assertFileExists($files_root . $filename);
