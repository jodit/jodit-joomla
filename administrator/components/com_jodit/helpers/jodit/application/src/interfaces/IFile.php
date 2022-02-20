<?php

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
	abstract public function isGoodFile($source);

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
	abstract public function getName();

	/**
	 * @return int
	 */
	abstract public function getSize();

	/**
	 * @return string
	 */
	abstract public function getTime();

	/**
	 * @return string
	 */
	abstract public function getExtension();

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
