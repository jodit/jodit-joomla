<?php
/**
 * @package    jodit
 *
 * @author     Valeriy Chupurnov <chupurnov@gmail.com>
 * @copyright  A copyright
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 * @link       https://xdsoft.net/jodit/
 */

use Joomla\CMS\MVC\Controller\BaseController;

defined('_JEXEC') or die;

/**
 * Jodit Controller.
 *
 * @package  jodit
 * @since    1.0
 */
class JoditController extends BaseController {
	function filebrowser() {
		$params = \JComponentHelper::getComponent('com_jodit')->getParams();
		$document = JFactory::getDocument();
		$document->setMimeEncoding('application/json');

		$user = JFactory::getUser();

		$access = [
			'core.manage.FILES',
			'core.edit.FILE_MOVE',
			'core.create.FILE_UPLOAD',
			'core.create.FILE_UPLOAD_REMOTE',
			'core.delete.FILE_REMOVE',
			'core.edit.FILE_RENAME',

			'core.manage.FOLDERS',
			'core.create.FOLDER_CREATE',
			'core.edit.FOLDER_MOVE',
			'core.delete.FOLDER_REMOVE',
			'core.edit.FOLDER_RENAME',

			'core.edit.IMAGE_RESIZE',
			'core.edit.IMAGE_CROP',
		];

		$accessControl = [];
		foreach ($access as $permission) {
			$accessControl[preg_replace('#[^A-Z_]#', '', $permission)] = !!$user->authorise(strtolower($permission), 'com_jodit');
		}


		$base = (!trim($params->get('root')) or !realpath(JPATH_ROOT . '/' . $params->get('root')))?  '/images' : '/' . ltrim($params->get('root'), '/\\\s\t\n\r');
		$base = ltrim(preg_replace(['#\\\\#', '#[/]{2,}#'], '/', $base), '/');
		$base = rtrim($base, '/');

		$config = [
			'baseurl' => JURI::root(true) . ($base ? '/' . $base . '/' : '/'),
			'createThumb' => true,
			'root' => realpath(JPATH_ROOT . '/' . $base) ?: realpath(JPATH_ROOT . '/images/') ?: JPATH_ROOT,
			'debug' => false,
			'datetimeFormat' => $params->get('dateformat', 'm/d/Y g:i A'),
			'accessControl' => [
				$accessControl
			],
		];


		$fileBrowser = new JoditApplication($config);

		try {
			$fileBrowser->action = jFactory::getApplication()->input->get('action');
			$fileBrowser->execute();
		} catch(\ErrorException $e) {
			$fileBrowser->exceptionHandler($e);
		}

		die;
	}
}
