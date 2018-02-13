<?
$config = [
    'sources' => [
        'test' => [
            'root' => realpath(__DIR__ . '/files') . '/',
            'baseurl' => 'http://localhost:8181/files/',
            'extensions' => ['jpg', 'png', 'gif', 'jpeg']
        ],
        'folder1' => [
            'root' => realpath(__DIR__ .  '/files/folder1') . '/',
            'baseurl' => 'http://localhost:8181/files/folder1/',
            'extensions' => ['jpg', 'png', 'gif', 'jpeg'],
            'maxFileSize' => '1kb'
        ]
    ],
    'allowCrossOrigin' => true,
	'accessControl' => [],
	'debug' => true
];

$config['roleSessionVar'] = 'JoditUserRole';

$config['accessControl'][] = array(
	'role'                => '*',
	'extensions'          => '*',
	'path'                => '/',
	'FILES'               => true,
	'FILE_MOVE'           => true,
	'FILE_UPLOAD'         => true,
	'FILE_UPLOAD_REMOTE'  => true,
	'FILE_REMOVE'         => true,
	'FILE_RENAME'         => true,

	'FOLDERS'             => true,
	'FOLDER_MOVE'         => true,
	'FOLDER_REMOVE'       => true,
	'FOLDER_RENAME'       => true,

	'IMAGE_RESIZE'        => true,
	'IMAGE_CROP'          => true,
);

$config['accessControl'][] = array(
	'role'                => '*',
	'path'                => __DIR__ . '/files/ceicom/',

	'FILE_MOVE'           => false,
	'FILE_UPLOAD'         => false,
	'FILE_UPLOAD_REMOTE'  => false,
	'FILE_RENAME'         => false,
	'FOLDER_CREATE'       => false,
);

return $config;