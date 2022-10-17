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
	'FOLDER_CREATE' => true,
	'FOLDER_REMOVE' => true,
	'FOLDER_RENAME' => true,
	'FOLDER_TREE' => true,

	'IMAGE_RESIZE' => true,
	'IMAGE_CROP' => true,

	'GENERATE_PDF' => true,
];
