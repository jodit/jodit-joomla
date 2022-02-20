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
 * Class Response
 * @package jodit
 */
class Response {
	/**
	 * @var bool
	 */
	public $success = true;

	/**
	 * @var string
	 */
	public $time;

	public $data = [
		'messages' => [],
		'code' => 220,
	];

	/**
	 * @var float|string
	 */
	public $elapsedTime;

	public function __construct () {
		$this->time = date('Y-m-d H:i:s');
		$this->data = (object)$this->data;
	}
}
