<?php

$config = [
	'root' => realpath(__DIR__ . '/files') . '/',
	'sources' => [
		'test' => [
			'title' => 'Some files',
			'root' => realpath(__DIR__ . '/files') . '/',
			'baseurl' => 'http://localhost:8081/files/',
		],
		'folder1' => [
			'title' => 'Small files',
			'root' => realpath(__DIR__ . '/files/folder1') . '/',
			'baseurl' => 'http://localhost:8081/files/folder1/',
			'maxFileSize' => '1kb',
		],
	],
	'allowCrossOrigin' => true,
	'accessControl' => [],

	'debug' => true,
];

$config['roleSessionVar'] = 'JoditUserRole';

$config['accessControl'][] = [
	'role' => '*',
	'extensions' => '*',
	'path' => '/',
	'FILES' => true,

	'FILE_MOVE' => true,
	'FILE_UPLOAD' => true,
	'FILE_UPLOAD_REMOTE' => true,
	'FILE_REMOVE' => true,
	'FILE_RENAME' => true,
	'FILE_DOWNLOAD' => true,

	'FOLDERS' => true,
	'FOLDER_MOVE' => true,
	'FOLDER_REMOVE' => true,
	'FOLDER_RENAME' => true,

	'IMAGE_RESIZE' => true,
	'IMAGE_CROP' => true,
];

$config['accessControl'][] = [
	'role' => '*',
	'path' => __DIR__ . '/files/images/',

	'FILE_MOVE' => false,
	'FILE_UPLOAD' => false,
	'FILE_UPLOAD_REMOTE' => false,
	'FILE_RENAME' => false,
	'FOLDER_CREATE' => false,
];

return $config;
