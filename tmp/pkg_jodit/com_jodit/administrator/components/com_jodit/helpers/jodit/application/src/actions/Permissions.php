<?php
/**
 * @package    jodit
 *
 * @author     Valeriy Chupurnov <chupurnov@gmail.com>
 * @copyright  A copyright
 * @license    GNU General Public License version 2 or later; see LICENSE
 * @link       https://xdsoft.net/jodit/
 */


namespace Jodit\actions;

use Exception;
use Jodit\components\AccessControl;
use Jodit\components\Config;
use Jodit\components\Request;
use Jodit\Helper;

trait Permissions {
	/**
	 * @var Config
	 */
	public $config;

	/**
	 * @var Request
	 */
	public $request;

	/**
	 * @return array[]
	 * @throws Exception
	 */
	public function actionPermissions() {
		$result = [];
		$source = $this->config->getSource($this->request->source);

		foreach (AccessControl::$defaultRule as $permission => $tmp) {
			if (preg_match('#^[A-Z_]+$#', $permission)) {
				$allow = false;

				try {
					$this->config->access->checkPermission(
						$this->config->getUserRole(),
						$permission,
						$source->getPath()
					);
					$allow = true;
				} catch (Exception $e) {
				}

				$result['allow' . Helper::camelCase($permission)] = $allow;
			}
		}

		return ['permissions' => $result];
	}
}
