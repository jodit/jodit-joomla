<?php

use Codeception\Test\Unit;
use Jodit\components\Config;
use Jodit\components\Jodit;
require_once __DIR__ . '/../TestApplication.php';

class JoditUnitTestApp extends JoditRestTestApplication {
	protected function startOutputBuffer () {}
}


/**
 * Class HelperTest
 */
class ConfigTest extends Unit {
	/**
	 * @var UnitTester $tester
	 */
	protected $tester;

	protected function _before () {
		Jodit::$app = new JoditUnitTestApp([]);
		$this->defaultConfig = include __DIR__ . '/../../src/configs/defaultConfig.php';
	}

	// tests
	public function testInheritOption() {
		$config = new Config([], null, 'default');
		$this->assertEquals($config->maxFileSize, $this->defaultConfig['maxFileSize']);
	}

	public function testOverrideOption() {
		$config = new Config([
			'maxFileSize' => '14M'
		], null, 'default');

		$this->assertEquals($config->maxFileSize, '14M');
	}

	public function testSources() {
		$config = new Config([
			'sources' => [
				'default' => [
					'maxUploadFileSize' => '123M',
					'root' => __DIR__
				]
			]
		], null, 'default');

		$this->assertEquals($config->getSource('default')->maxFileSize, $this->defaultConfig['maxFileSize']);
		$this->assertEquals($config->getSource('default')->maxUploadFileSize, '123M');
		$this->assertEquals($config->getSource('default')->getRoot(), __DIR__ . '/');
	}

	public function testFindCompatibleConfig() {
		$config = new Config([
			'sources' => [
				'default' => [
					'maxUploadFileSize' => '123M',
					'root' => __DIR__
				]
			]
		], null, 'default');

		$compatible = $config->getCompatibleSource('');

		$this->assertNotEquals($compatible, $config);
		$this->assertEquals($compatible->getRoot(), $config->getSource('default')->getRoot());
		$this->assertEquals($compatible->parent, $config);
	}
}
