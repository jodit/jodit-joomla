<?php
/**
 * @package    jodit
 *
 * @author     Valeriy Chupurnov <chupurnov@gmail.com>
 * @license    GNU General Public License version 2 or later; see LICENSE
 * @link       https://xdsoft.net/jodit/
 */

namespace Jodit;

/**
 * Class Request
 * @package jodit
 * @property string $action
 * @property string $source
 * @property string $name
 * @property string $newname
 * @property string $path
 * @property string $url
 * @property array $box
 */
class Request {
	private $_raw_data = [];
	function __construct() {
		$data = file_get_contents('php://input');
		if ($data) {
			switch ($_SERVER["CONTENT_TYPE"]) {
				case 'application/json':
					$this->_raw_data =  json_decode($data, true);
					break;
				default:
					parse_str($data, $this->_raw_data);

			}
		}
	}

	function get($key, $default_value = null) {
		if (isset($_REQUEST[$key])) {
			return $_REQUEST[$key];
		}
		if (isset($this->_raw_data[$key])) {
			return $this->_raw_data[$key];
		}
		return $default_value;
	}

	function __get($key) {
		return $this->get($key);
	}

	function post($keys, $default_value = null) {
		$keys_chain = explode('/', $keys);
		$result = $_POST;

		foreach ($keys_chain as $key) {
			if ($key and isset($result[$key])) {
				$result = $result[$key];
			} else {
				$result = $default_value;
				break;
			}
		}

		return $result;
	}
}