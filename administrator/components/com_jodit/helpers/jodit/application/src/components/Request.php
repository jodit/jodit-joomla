<?php
/**
 * @package    jodit
 *
 * @author     Valeriy Chupurnov <chupurnov@gmail.com>
 * @license    GNU General Public License version 2 or later; see LICENSE
 * @link       https://xdsoft.net/jodit/
 */

namespace Jodit\components;

/**
 * Class Request
 * @property string $action
 * @property string $source
 * @property string $name
 * @property string $newname
 * @property string $path
 * @property string $url
 * @property array $box
 */
class Request {
	private $rawData = [];

	public function __construct () {
		$data = file_get_contents('php://input');

		if ($data) {
			switch ($_SERVER['CONTENT_TYPE']) {
				case 'application/json':
					$this->rawData = json_decode($data, true);
					break;
				default:
					parse_str($data, $this->rawData);
			}
		}
	}

	/**
	 * @param $key
	 * @param null $default_value
	 * @return mixed|null
	 */
	public function get ($key, $default_value = null) {
		if (isset($_REQUEST[$key])) {
			return $this->prepareValue($_REQUEST[$key]);
		}

		if (isset($this->rawData[$key])) {
			return $this->prepareValue($this->rawData[$key]);
		}

		return $default_value;
	}

	/**
	 * @param $str
	 */
	private function prepareValue($str) {
		if ($str === 'false' || $str === 'true') {
			return $str === 'true';
		}

		if (is_numeric($str)) {
			return floatval($str);
		}

		return $str;
	}

	/**
	 * @param $key
	 * @return mixed|null
	 */
	public function __get ($key) {
		return $this->get($key);
	}

	/**
	 * @param $keys
	 * @param null $default_value
	 * @return array|mixed
	 */
	public function post ($keys, $default_value = null) {
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

	/**
	 * @return string
	 */
	public function getMethod() {
		return strtoupper(getenv('REQUEST_METHOD'));
	}

	/**
	 * @param string $keys
	 * @param null $default_value
	 * @return bool|mixed|null
	 */
	public function getField(string $keys, $default_value = null) {
		$keys_chain = explode('/', $keys);
		$result = $this->get($keys_chain[0]);

		if ($result == null) {
			return $default_value;
		}

		$result = (array)$result;

		foreach (array_slice($keys_chain, 1) as $key) {
			if ($key and is_array($result) && isset($result[$key])) {
				$result = $result[$key];
			} else {
				return $default_value;
			}
		}

		return $this->prepareValue($result);
	}
}
