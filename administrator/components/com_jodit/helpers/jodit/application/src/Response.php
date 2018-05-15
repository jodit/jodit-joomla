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
 * Class Response
 * @package jodit
 */
class Response {
	public $success = true;
	public $time;

	public $data = [
		'messages' => [],
		'code' => 220,
	];

	function __construct() {
		$this->time = date('Y-m-d H:i:s');
		$this->data = (object)$this->data;
	}
}