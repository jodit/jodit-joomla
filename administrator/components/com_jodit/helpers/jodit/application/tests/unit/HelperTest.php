<?php

use Codeception\Test\Unit;
use Jodit\Helper;

/**
 * Class HelperTest
 */
class HelperTest extends Unit {
	/**
	 * @var UnitTester $tester
	 */
	protected $tester;

	// tests
	public function testUpperaze() {
		$this->assertEquals('FILE_UPLOAD', Helper::upperize('fileUpload'));
		$this->assertEquals(
			'FILE_UPLOAD',
			Helper::upperize('FileUpload')
		);
		$this->assertEquals(
			'FIL_EUPLOAD',
			Helper::upperize('FilEUpload')
		);
		$this->assertEquals('FILE', Helper::upperize('File'));
	}

	public function testCamelCase() {
		$this->assertEquals(
			'FileUpload',
			Helper::camelCase('FILE_UPLOAD')
		);
		$this->assertEquals('File', Helper::camelCase('FILE'));
	}
	public function testNormalizePath() {
		$this->assertEquals(
			'C:/sdfsdf/',
			Helper::normalizePath('C:\\sdfsdf\\')
		);
		$this->assertEquals(
			'C:/sdfsdf/',
			Helper::normalizePath('C:/sdfsdf/')
		);
		$this->assertEquals(
			'C:/sdfsdf/',
			Helper::normalizePath('C://\\sdfsdf/')
		);
	}
}
