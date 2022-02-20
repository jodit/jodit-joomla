<?php
/**
 * @package    jodit
 *
 * @author     Valeriy Chupurnov <chupurnov@gmail.com>
 * @license    GNU General Public License version 2 or later; see LICENSE
 * @link       https://xdsoft.net/jodit/
 */

namespace Jodit;

use Jodit\components\BaseApplication;
use Jodit\actions\Folder;
use Jodit\actions\Files;
use Jodit\actions\File;
use Jodit\actions\Image;
use Jodit\actions\Permissions;
use Jodit\actions\GenerateDocs;

/**
 * Class Application
 * @package Jodit
 */
abstract class Application extends BaseApplication {
	use Files;
	use Folder;
	use File;
	use Image;
	use Permissions;
	use GenerateDocs;
}
