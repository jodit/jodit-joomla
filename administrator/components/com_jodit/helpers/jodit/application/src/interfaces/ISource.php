<?php

namespace Jodit\interfaces;


use Jodit\components\Config;

/**
 * Interface ISource
 * @package Jodit\interfaces
 */
abstract class ISource extends Config {
	/**
	 * @return mixed
	 */
	abstract public function items();

	/**
	 * @return mixed
	 */
	abstract public function folders();

	/**
	 * @param string $path
	 * @return mixed
	 */
	abstract public function makeFolder($path);

	/**
	 * @param IFile $file
	 * @return mixed
	 */
	abstract public function makeThumb(IFile $file);

	/**
	 * @param string $file
	 * @return bool
	 */
	abstract public function isExcluded($file);


	/**
	 * @param $fromName
	 * @return mixed
	 */
	abstract protected function movePath($fromName);

	/**
	 * @param string $fromName
	 * @param string $newName
	 * @return mixed
	 */
	abstract public function renamePath(
		$fromName,
		$newName
	);

	/**
	 * @param string $target
	 * @return mixed
	 */
	abstract public function fileRemove($target);

	/**
	 * @param string $target
	 * @return mixed
	 */
	abstract public function fileDownload($target);

	/**
	 * @param string $name
	 * @return mixed
	 */
	abstract public function folderRemove($name);

	/**
	 * @param string $url
	 * @return mixed
	 */
	abstract public function resolveFileByUrl($url);

	/**
	 * @param string $path
	 * @param string $content
	 * @return IFile
	 */
	abstract public function makeFile($path, $content = null);
}
