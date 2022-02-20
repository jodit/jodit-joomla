<?php
/** @var \Codeception\Scenario $scenario */

use Codeception\Util\HttpCode;

$I = new ApiTester($scenario);

$I->wantTo('Check generate pdf from HTML');

$I->sendGet('?action=generatePdf&html=' . urlencode('<p>asdsadsadas</p>
<p>das</p>
<p>d</p>
<p>sada<img src="https://xdsoft.net/jodit/finder/files/pexels-bia-sousa-2603201.jpg" width="300px"></p>'));

$I->seeResponseCodeIs(HttpCode::OK); // 200
$I->seeHttpHeader('Content-Type', 'application/pdf');
$I->seeHttpHeader('Content-Length', '1731501');
$I->seeHttpHeader('Content-Disposition', 'attachment; filename="document.pdf"');
file_put_contents('ddd.pdf', $I->grabResponse());
