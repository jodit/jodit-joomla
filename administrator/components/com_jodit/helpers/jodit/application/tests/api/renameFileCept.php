<?php
/** @var \Codeception\Scenario $scenario */

use Codeception\Util\HttpCode;

$I = new ApiTester($scenario);
$files_root = realpath(__DIR__ . '/../files') . '/';

$I->wantTo('Check rename file');

$I->sendGet('?action=fileRename&source=test&name=pexels-yuri-manei-2337448.jpg&path=&newname=started.jpg');

$I->seeResponseCodeIs(HttpCode::OK); // 200
$I->seeResponseIsJson();

$I->seeResponseContainsJson([
    "success" => true,
    "data" => [
        "code" => 220,
    ]
]);

$I->assertFileExists($files_root . 'started.jpg');

$I->sendGet('?action=fileRename&source=test&name=started.jpg&path=&newname=pexels-yuri-manei-2337448.jpg.php');
$I->assertFileExists($files_root . 'pexels-yuri-manei-2337448.jpg.php.jpg');

$I->sendGet('?action=fileRename&source=test&name=pexels-yuri-manei-2337448.jpg.php.jpg&path=&newname=pexels-yuri-manei-2337448.jpg');

$I->assertFileNotExists($files_root . 'pexels-yuri-manei-2337448.jpg.php');
$I->assertFileNotExists($files_root . 'pexels-yuri-manei-2337448.jpg.php.jpg');
$I->assertFileNotExists($files_root . 'started.jpg');
$I->assertFileExists($files_root . 'pexels-yuri-manei-2337448.jpg');



