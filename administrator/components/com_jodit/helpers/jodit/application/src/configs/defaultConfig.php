<?php
/**
 * @package    jodit
 *
 * @author     Valeriy Chupurnov <chupurnov@gmail.com>
 * @copyright  A copyright
 * @license    GNU General Public License version 2 or later; see LICENSE
 * @link       https://xdsoft.net/jodit/
 */

namespace Jodit;

return [
	'defaultFilesKey' => 'files',
	'debug' => true, // must be true
	'sources' => [],
	'datetimeFormat' => 'm/d/Y g:i A',
	'quality' => 90,
	'countInChunk' => 1000000,
	'defaultSortBy' => 'changed-desc',
	'defaultPermission' => 0775,
	'createThumb' => true,
	'thumbSize' => 250,
	'thumbFolderName' => '_thumbs',
	'excludeDirectoryNames' => ['.tmb', '.quarantine'],
	'maxFileSize' => '8mb',
	'maxUploadFileSize' => '8M',
	'memoryLimit' => '256M',
	'timeoutLimit' => 60,
	'allowCrossOrigin' => false,
	'safeThumbsCountInOneTime' => 10,

	'sourceClassName' => 'Jodit\sources\FileSystem',

	/**
	 * @var array
	 * @see https://github.com/xdan/jodit-connectors#access-control
	 */
	'accessControl' => [],
	'roleSessionVar' => 'JoditUserRole',
	'defaultRole' => 'guest',
	'allowReplaceSourceFile' => true,
	'baseurl' => '',
	'root' => '',
	'extensions' => [
		'jpg',
		'png',
		'gif',
		'jpeg',
		'bmp',
		'ico',
		'jpeg',
		'psd',
		'svg',
		'ttf',
		'tif',
		'ai',
		'txt',
		'css',
		'html',
		'js',
		'htm',
		'ini',
		'xml',
		'zip',
		'rar',
		'7z',
		'gz',
		'tar',
		'pps',
		'ppt',
		'pptx',
		'odp',
		'xls',
		'xlsx',
		'csv',
		'doc',
		'docx',
		'pdf',
		'rtf',
		'avi',
		'flv',
		'3gp',
		'mov',
		'mkv',
		'mp4',
		'wmv',
		'webp'
	],
	'imageExtensions' => ['jpg', 'png', 'gif', 'jpeg', 'bmp', 'svg', 'ico', 'webp'],
	'maxImageWidth' => 1900,
	'maxImageHeight' => 1900,
];
