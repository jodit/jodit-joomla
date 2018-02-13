<?php
namespace Jodit;

/**
 * Class Source
 * @package jodit
 * @property string $baseurl
 * @property string $root
 * @property number $maxFileSize
 * @property number $quality
 * @property string $thumbFolderName
 * @property string $defaultPermission
 * @property string[] $imageExtensions
 */
class Source {
	/**
	 * @property string $action
	 */
	public $action;

	private $data = [];
	/**
	 * @var \Jodit\Config
	 */
	private $defaultOptions;

	function __get($key) {
		if (isset($this->data->{$key})) {
			return $this->data->{$key};
		}

		if (isset($this->defaultOptions->{$key})) {
			return $this->defaultOptions->{$key};
		}

		throw new \ErrorException('Option ' . $key . ' not set', 501);
	}

	/**
	 * Source constructor.
	 *
	 * @param $data
	 * @param \Jodit\Config $defaultOptuions
	 */
	function __construct($data, $defaultOptuions) {
		$this->data           = (object)$data;
		$this->defaultOptions = $defaultOptuions;
		$this->request        = new Request();
	}

	/**
	 * Get full path for $source->root with trailing slash
	 *
	 * @return string
	 * @throws \Exception
	 */
	public function getRoot() {
		if ($this->root) {
			if (!is_dir($this->root)) {
				throw new \Exception('Root directory not exists ' . $this->root, 501);
			}
			return realpath($this->root) . DIRECTORY_SEPARATOR;
		}

		throw new \Exception('Set root directory for source', 501);
	}

	/**
	 * Get full path for $_REQUEST[$name] relative path with trailing slash(if directory)
	 *
	 * @param string $relativePath
	 * @return bool|string
	 * @throws \Exception
	 */
	public function getPath ($relativePath = false) {
		$root = $this->getRoot();

		if ($relativePath === false) {
			$relativePath = $this->request->path ?: '';
		}

		//always check whether we are below the root category is not reached
		if (realpath($root . $relativePath) && strpos(realpath($root . $relativePath) . DIRECTORY_SEPARATOR, $root) !== false) {
			$root = realpath($root . $relativePath);
			if (is_dir($root)) {
				$root .= DIRECTORY_SEPARATOR;
			}
		} else {
			throw new \Exception('Path does not exist', 404);
		}

		return $root;
	}
}