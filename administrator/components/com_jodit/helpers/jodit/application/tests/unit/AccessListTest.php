<?php


class AccessListTest extends \Codeception\Test\Unit
{
    /**
     * @var UnitTester
     */
    protected $tester;
	/**
	 * @var \Jodit\components\AccessControl
	 */
    protected $access;

    protected function _before()
    {
	    $this->access = new \Jodit\components\AccessControl();
    }

    protected function _after()
    {
    }

    // tests
    public function testDenyAccess() {

	    $this->access->setAccessList([
	    	[
				'role' => 'user',
			    'FOLDERS' => false
		    ]
	    ]);

	    $this->tester->expectException('\Exception', function () {
	    	$this->access->checkPermission('user', 'folders');
	    });
	    $this->tester->assertEquals(true, $this->access->checkPermission('user', 'files'));
    }

	public function testAllowAccessForAdmin() {

		$this->access->setAccessList([
			[
				'role' => 'user',
				'FOLDERS' => false,
				'FOLDER_RENAME' => false,
			],
			[
				'role' => 'admin',
				'FOLDERS' => true
			]
		]);

		$this->tester->expectException('\Exception', function () {
			$this->access->checkPermission('user', 'folders');
		});
		$this->tester->expectException('\Exception', function () {
			$this->access->checkPermission('user', 'folderRename');
		});

		$this->tester->assertEquals(true, $this->access->checkPermission('admin', 'folders'));
		$this->tester->assertEquals(true, $this->access->checkPermission('admin', 'folderRename'));
	}

	public function testDenyAccessForAllAndAllowForAdmin() {

		$this->access->setAccessList([
			[
				'role' => '*',
				'FOLDERS' => false,
				'FOLDER_RENAME' => false,
			],
			[
				'role' => 'admin',
				'FOLDERS' => true
			]
		]);

		$this->tester->expectException('\Exception', function () {
			$this->access->checkPermission('user', 'folders');
		});
		$this->tester->expectException('\Exception', function () {
			$this->access->checkPermission('user', 'folderRename');
		});

		$this->tester->assertEquals(true, $this->access->checkPermission('admin', 'folders'));
		$this->tester->expectException('\Exception', function () {
			$this->access->checkPermission('admin', 'folderRename');
		});
	}

	public function testDenyAccessForAll() {

		$this->access->setAccessList([
			[
				'role' => '*',
				'FOLDERS' => false
			],
		]);

		$this->tester->expectException('\Exception', function () {
			$this->access->checkPermission('user', 'folders');
		});

		$this->tester->expectException('\Exception', function () {
			$this->access->checkPermission('admin', 'folders');
		});
	}
	public function testDenyAccessForAllToDirectory() {

		$this->access->setAccessList([
			[
				'FOLDERS' => false,
				'path' => '/images/'
			],
			[
				'role' => 'admin',
				'FOLDERS' => true,
				'path' => '/images/subfolder/folder/'
			],
		]);

		$this->tester->assertEquals(true, $this->access->checkPermission('user', 'folders'));

		$this->tester->expectException('\Exception', function () {
			$this->access->checkPermission('user', 'folders', '/images/');
		});

		$this->tester->expectException('\Exception', function () {
			$this->access->checkPermission('admin', 'folders', '/images/');
		});
		$this->tester->expectException('\Exception', function () {
			$this->access->checkPermission('admin', 'folders', '/images/subfolder/');
		});

		$this->tester->assertEquals(true, $this->access->checkPermission('admin', 'folders', '/images/subfolder/folder/'));
	}

	public function testDenyUploadSomeExtensions() {

		$this->access->setAccessList([
			[
				'FILE_UPLOAD' => false,
				'extensions' => 'exe,zip'
			],
			[
				'role' => 'admin',
				'FILE_UPLOAD' => true,
				'extensions' => 'exe,zip'
			],
			[
				'role' => 'user',
				'FILE_UPLOAD' => true,
				'extensions' => 'exe'
			],
		]);

		$this->tester->assertEquals(true, $this->access->checkPermission('user', 'fileUpload', '/', 'jpg'));

		$this->tester->expectException('\Exception', function () {
			$this->access->checkPermission('user', 'fileUpload', '/', 'zip');
		});

		$this->tester->assertEquals(true, $this->access->checkPermission('admin', 'fileUpload', '/', 'zip'));
		$this->tester->assertEquals(true, $this->access->checkPermission('user', 'fileUpload', '/', 'exe'));
	}
}
