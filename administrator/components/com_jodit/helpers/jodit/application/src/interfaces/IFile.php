<?php
/**
 * @package    jodit
 *
 * @author     Valeriy Chupurnov <chupurnov@gmail.com>
 * @copyright  A copyright
 * @license    GNU General Public License version 2 or later; see LICENSE
 * @link       https://xdsoft.net/jodit/
 */


namespace Jodit\interfaces;


/**
 * Interface IFile
 * @package Jodit\interfaces
 */
abstract class IFile {
	/**
	 * @param $source
	 * @return bool
	 */
	abstract public function isGoodFile($source): bool;
	abstract public function isSafeFile($source): bool;

	/**
	 * @return bool
	 */
	abstract public function isDirectory(): bool;

	abstract public function remove();
	abstract public function send();

	/**
	 * @return string
	 */
	abstract public function getPath();

	/**
	 * @return string
	 */
	abstract public function getFolder();

	/**
	 * @return string
	 */
	abstract public function getName(): string;

	/**
	 * @return string
	 */
	abstract public function getExtension();

	/**
	 * @return string
	 */
	abstract public function getBasename();

	/**
	 * @return int
	 */
	abstract public function getSize();

	/**
	 * @return false|int
	 */
	abstract public function getTime();



	/**
	 * @param ISource $source
	 * @return string
	 */
	abstract public function getPathByRoot($source);

	/**
	 * @return bool
	 */
	abstract public function isImage();

	/**
	 * @return bool
	 */
	abstract public function isSVGImage();
}
