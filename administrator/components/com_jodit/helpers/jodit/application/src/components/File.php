<?php

/**
 * @package    jodit
 *
 * @author     Valeriy Chupurnov <chupurnov@gmail.com>
 * @license    GNU General Public License version 2 or later; see LICENSE
 * @link       https://xdsoft.net/jodit/
 */

namespace Jodit\components;

use Exception;
use Jodit\Consts;
use Jodit\interfaces\IFile;

/**
 * Class Files
 */
class File extends IFile {
	/**
	 * @param string $path
	 * @return File
	 * @throws Exception
	 */
	public static function create($path) {
		return new File($path);
	}

	private $path = '';

	/**
	 * @param string $path
	 * @throws Exception
	 */
	protected function __construct($path) {
		$path = realpath($path);

		if (!$path) {
			throw new Exception(
				'File not exists',
				Consts::ERROR_CODE_NOT_EXISTS
			);
		}

		$this->path = $path;
	}

	/**
	 * Check file extension
	 *
	 * @param Config $source
	 * @return bool
	 */
	public function isGoodFile($source): bool {
		$ext = $this->getExtension();

		if (!$ext or !in_array($ext, $source->extensions)) {
			return false;
		}

		return true;
	}

	/**
	 * File is safe
	 * @param $source
	 * @return bool
	 */
	public function isSafeFile($source): bool {
		$ext = $this->getExtension();

		if (!$this->isGoodFile($source)) {
			return false;
		}

		if (in_array($ext, $source->imageExtensions) && !$this->isImage()) {
			return false;
		}

		return true;
	}

	/**
	 * @return bool
	 */
	public function isDirectory(): bool {
		return is_dir($this->path);
	}

	/**
	 * Remove file
	 * @throws Exception
	 */
	public function remove() {
		$file = basename($this->path);
		$thumb =
			dirname($this->path) .
			Consts::DS .
			Jodit::$app->config->getSource(Jodit::$app->request->source)
				->thumbFolderName .
			Consts::DS .
			$file;

		if (file_exists($thumb)) {
			unlink($thumb);

			if (!count(glob(dirname($thumb) . Consts::DS . '*'))) {
				rmdir(dirname($thumb));
			}
		}

		return unlink($this->path);
	}

	/**
	 * @return string
	 */
	public function getPath() {
		return str_replace('\\', Consts::DS, $this->path);
	}

	/**
	 * @return string
	 */
	public function getFolder() {
		return dirname($this->getPath()) . Consts::DS;
	}

	/**
	 * @return string
	 */
	public function getName(): string {
		$parts = explode(Consts::DS, $this->getPath());
		return array_pop($parts) ?: '';
	}

	/**
	 * Get file extension
	 *
	 * @return string
	 */
	public function getExtension() {
		$parts = explode('.', $this->getName());
		return mb_strtolower(array_pop($parts) ?: '');
	}

	/**
	 * Get file basename(urf8 basename analogue)
	 *
	 * @return string
	 */
	public function getBasename() {
		$parts = explode('.', $this->getName());
		array_pop($parts);
		return implode('.', $parts);
	}

	/**
	 * @return int
	 */
	public function getSize() {
		return filesize($this->getPath());
	}

	/**
	 * @return false|int
	 */
	public function getTime() {
		return filemtime($this->getPath());
	}

	/**
	 * @param Config $source
	 * @return string
	 * @throws Exception
	 */
	public function getPathByRoot($source): string {
		$path = preg_replace('#[\\\\/]#', '/', $this->getPath());
		$root = preg_replace('#[\\\\/]#', '/', $source->getPath());

		return str_replace($root, '', $path);
	}

	/**
	 * Check by mimetype what file is image
	 * @return bool
	 */

	private $__isFile = null;
	public function isImage(): bool {
		if (is_bool($this->__isFile)) {
			return $this->__isFile;
		}

		try {
			if ($this->isSVGImage()) {
				$this->__isFile = true;
				return true;
			}

			if (
				!function_exists('exif_imagetype') &&
				!function_exists('Jodit\exif_imagetype') &&
				!function_exists('Jodit\components\exif_imagetype')
			) {
				/**
				 * @param $filename
				 * @return false|mixed
				 */
				function exif_imagetype($filename) {
					if ((list(, , $type) = getimagesize($filename)) !== false) {
						return $type;
					}

					return false;
				}
			}

			$this->__isFile = in_array(exif_imagetype($this->getPath()), [
				IMAGETYPE_GIF,
				IMAGETYPE_JPEG,
				IMAGETYPE_PNG,
				IMAGETYPE_BMP,
				IMAGETYPE_WEBP,
			]);
		} catch (Exception $e) {
			$this->__isFile = false;
		}

		return $this->__isFile;
	}

	/**
	 * Check file is SVG image
	 * @return bool
	 */
	public function isSVGImage(): bool {
		return $this->getExtension() === 'svg';
	}

	/**
	 * Send file for download
	 */
	public function send() {
		header('Content-Description: File Transfer');
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename=' . $this->getName());
		header('Content-Transfer-Encoding: binary');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');
		header('Content-Length: ' . $this->getSize());
		ob_clean();
		flush();
		readfile($this->getPath());
		exit();
	}
}
