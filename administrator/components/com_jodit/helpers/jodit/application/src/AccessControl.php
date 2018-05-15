<?php
/**
 * @package    jodit
 *
 * @author     Valeriy Chupurnov <chupurnov@gmail.com>
 * @license    GNU General Public License version 2 or later; see LICENSE
 * @link       https://xdsoft.net/jodit/
 */

namespace Jodit;

class AccessControl {
	private $accessList = [];

	static public $defaultRule = [
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
		'FOLDER_CREATE'       => true,
		'FOLDER_REMOVE'       => true,
		'FOLDER_RENAME'       => true,

		'IMAGE_RESIZE'        => true,
		'IMAGE_CROP'          => true,
	];


	/**
	 * @param array $list
	 */
	public function setAccessList($list) {
		$this->accessList = $list;
	}

	public function checkPermission($role, $action, $path = '/', $fileExtension = '*') {
		if (!$this->isAllow($role, $action, $path, $fileExtension)) {
			throw new \Exception('Access denied', Consts::ERROR_CODE_FORBIDDEN);
		}
		return true;
	}

	/**
	 * @param {string} $role
	 * @param {string} $action
	 */
	public function isAllow($role, $action, $path = '/', $fileExtension = '*') {
		$action = Helper::Upperize($action);

		$allow = null;

		foreach ($this->accessList as $rule) {
			if (!isset($rule['role']) or $rule['role'] === '*' or $rule['role'] === $role) {

				if (isset($rule['path'])) {
					if (strpos(Helper::NormalizePath($path), Helper::NormalizePath($rule['path'])) !== 0) {
						continue;
					}
				}

				if (isset($rule['extensions'])) {
					$allowExtensions = ['*'];
					if (is_string($rule['extensions'])) {
						$rule['extensions'] = preg_split('#[,\s]+#', $rule['extensions']);
					}

					if (is_array($rule['extensions'])) {
						$allowExtensions =  array_map(['\Jodit\Helper', 'Upperize'], $rule['extensions']);
					}

					if (is_callable($rule['extensions'])) {
						$allowExtensions =  call_user_func_array($rule['extensions'], [$action, $rule, $path, $fileExtension]);
					}

					if (!(in_array('*', $allowExtensions) or in_array(strtoupper($fileExtension), $allowExtensions))) {
						continue;
					}
				}

				if (isset($rule[$action])) {
					if (is_callable($rule[$action])) {
						$allow = call_user_func_array($rule[$action], [$action, $rule, $path, $fileExtension]);
					} else {
						$allow = is_bool($rule[$action]) ? $rule[$action] : true;
					}
				}
			}
		}

		if ($allow === null) {
			$allow = isset(static::$defaultRule[$action]) ? static::$defaultRule[$action] : true;
		}

		if ($allow === false) {
			return false;
		}

		return true;
	}
}