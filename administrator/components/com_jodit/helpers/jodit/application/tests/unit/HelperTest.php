<?php


class HelperTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    protected function _before()
    {
    }

    protected function _after()
    {
    }

    // tests
    public function testUpperaze()
    {
		$this->assertEquals('FILE_UPLOAD', \Jodit\Helper::Upperize('fileUpload'));
		$this->assertEquals('FILE_UPLOAD', \Jodit\Helper::Upperize('FileUpload'));
		$this->assertEquals('FIL_EUPLOAD', \Jodit\Helper::Upperize('FilEUpload'));
		$this->assertEquals('FILE', \Jodit\Helper::Upperize('File'));
    }

	public function testCamelCase() {
		$this->assertEquals('FileUpload', \Jodit\Helper::CamelCase('FILE_UPLOAD'));
		$this->assertEquals('File', \Jodit\Helper::CamelCase('FILE'));
	}
	public function testNormalizePath() {
		$this->assertEquals('C:/sdfsdf/', \Jodit\Helper::NormalizePath('C:\\sdfsdf\\'));
		$this->assertEquals('C:/sdfsdf/', \Jodit\Helper::NormalizePath('C:/sdfsdf/'));
		$this->assertEquals('C:/sdfsdf/', \Jodit\Helper::NormalizePath('C://\\sdfsdf/'));
	}
}