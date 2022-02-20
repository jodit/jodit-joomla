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
use Jodit\Helper;
use Jodit\interfaces\ISource;

$defaultConfig = include __DIR__ . '/../configs/defaultConfig.php';

/**
 * Class Config
 * @property string $title
 * @property string $thumbFolderName
 * @property number $countInChunk
 * @property string $defaultSortBy
 * @property string $maxFileSize
 * @property string $memoryLimit
 * @property number $thumbSize
 * @property number $timeoutLimit
 * @property bool $allowCrossOrigin
 * @property AccessControl $access
 * @property bool $createThumb
 * @property bool $debug
 * @property string[] $excludeDirectoryNames
 * @property number $quality
 * @property string $datetimeFormat
 * @property string $baseurl
 * @property number $defaultPermission
 * @package jodit
 */
class Config {
	/**
	 * @var Config | false
	 */
	private $parent;

	static $defaultOptions;

	private $data = [];

	/**
	 * @var ISource[]
	 */
	public $sources = [];

	public $sourceName = 'default';

	/**
	 * @var AccessControl
	 */
	public $access;

	/**
	 * @param $source
	 * @param Config $param
	 * @param $key
	 * @return \Jodit\interfaces\ISource
	 * @throws Exception
	 */
	private static function makeSource($source, Config $param, $key) {
		$className = !empty($source['sourceClassName'])
			? $source['sourceClassName']
			: $param->sourceClassName;

		if (!$className) {
			$className = self::$defaultOptions['sourceClassName'];
		}

		$instance = new $className($source, $param, $key);

		if ($instance instanceof ISource) {
			return $instance;
		}

		throw new Exception("Class '{$className}' does not implement ISource");
	}

	/**
	 * @return ISource[]
	 * @throws Exception
	 */
	public function getSources() {
		$sources = [];
		$request = Jodit::$app->request;
		$action = Jodit::$app->action;

		foreach ($this->sources as $key => $source) {
			if (
				$request->source &&
				$request->source !== 'default' &&
				$key !== $request->source &&
				$request->path !== './'
			) {
				continue;
			}

			$path = $source->getPath();

			try {
				$this->access->checkPermission(
					$this->getUserRole(),
					$action,
					$path
				);
			} catch (Exception $e) {
				continue;
			}

			$sources[] = $source;
		}

		if (count($sources) === 0) {
			throw new Exception(
				'Need valid source',
				Consts::ERROR_CODE_NOT_EXISTS
			);
		}

		return $sources;
	}

	/**
	 * Get user role
	 * @return string
	 */
	public function getUserRole() {
		return isset($_SESSION[$this->roleSessionVar])
			? $_SESSION[$this->roleSessionVar]
			: $this->defaultRole;
	}

	/**
	 * @param $key
	 * @param $value
	 */
	public function __set($key, $value) {
		$this->data->{$key} = $value;
	}

	/**
	 * @param $key
	 * @return null
	 */
	public function __get($key) {
		if (isset($this->data->{$key})) {
			return $this->data->{$key};
		}

		if ($this->parent) {
			return $this->parent->{$key};
		} else {
			return null;
		}
	}

	/**
	 * Config constructor.
	 *
	 * @param array $data
	 * @param null | false | Config $parent
	 * @param string $sourceName
	 * @throws Exception
	 */
	function __construct($data, $parent = null, $sourceName = 'default') {
		$this->parent = $parent;
		$data = (object) $data;
		$this->data = $data;
		$this->sourceName = $sourceName;
		$this->access = new AccessControl();

		if ($parent === null) {
			if (!$this->baseurl) {
				$this->baseurl =
					((isset($_SERVER['HTTPS']) and $_SERVER['HTTPS'])
						? 'https://'
						: 'http://') .
					(isset($_SERVER['HTTP_HOST'])
						? $_SERVER['HTTP_HOST']
						: '') .
					'/';
			}

			$this->parent = new Config(self::$defaultOptions, false);

			if (
				isset($data->sources) and
				is_array($data->sources) and
				count($data->sources)
			) {
				foreach ($data->sources as $key => $source) {
					$this->sources[$key] = self::makeSource(
						$source,
						$this,
						$key
					);
				}
			} else {
				$this->sources['default'] = self::makeSource(
					[],
					$this,
					'default'
				);
			}
		}
	}

	/**
	 * Get full path for $source->root with trailing slash
	 *
	 * @return string
	 * @throws Exception
	 */
	public function getRoot() {
		if ($this->root) {
			if (!is_dir($this->root)) {
				throw new Exception(
					'Root directory not exists ' . $this->root,
					Consts::ERROR_CODE_NOT_EXISTS
				);
			}

			$root = realpath($this->root);

			return  $root !==  Consts::DS ? $root . Consts::DS : Consts::DS;
		}

		throw new Exception(
			'Set root directory for source',
			Consts::ERROR_CODE_NOT_IMPLEMENTED
		);
	}

	/**
	 * Get full path for $_REQUEST[$name] relative path with trailing slash(if directory)
	 *
	 * @param string|bool $relativePath
	 * @return bool|string
	 * @throws \Exception
	 */
	public function getPath($relativePath = false) {
		$root = $this->getRoot();

		if ($relativePath === false) {
			$relativePath = Jodit::$app->request->path ?: '';
		}

		$path = realpath(Helper::normalizePath($root . $relativePath));

		//always check whether we are below the root category is not reached
		if ($path && strpos($path . Consts::DS, $root) !== false) {
			$root = $path;
			if (is_dir($root)) {
				$root .= Consts::DS;
			}
		} else {
			throw new Exception(
				'Path does not exist',
				Consts::ERROR_CODE_NOT_EXISTS
			);
		}

		return $root;
	}

	/**
	 * Get source by name
	 *
	 * @param string | null $sourceName
	 * @return ISource | null
	 * @throws Exception
	 */
	public function getSource($sourceName) {
		if (!$sourceName || $sourceName === 'default') {
			$sourceName = Helper::arrayKeyFirst($this->sources);
		}

		$source = isset($this->sources[$sourceName])
			? $this->sources[$sourceName]
			: null;

		if (!$source) {
			throw new Exception(
				'Source not found',
				Consts::ERROR_CODE_NOT_EXISTS
			);
		}

		$source->access->checkPermission(
			$source->getUserRole(),
			Jodit::$app->action,
			$source->getPath()
		);

		return $source;
	}

	/**
	 * @param string|null $sourceName
	 * @return $this|ISource
	 * @throws Exception
	 */
	public function getCompatibleSource($sourceName = null) {
		if ($sourceName === 'default') {
			$sourceName = null;
		}

		if ($sourceName) {
			$source = $this->getSource($sourceName);

			if (!$source) {
				throw new Exception(
					'Source not found',
					Consts::ERROR_CODE_NOT_EXISTS
				);
			}

			$this->access->checkPermission(
				$this->getUserRole(),
				Jodit::$app->action,
				$source->getPath()
			);

			return $source;
		}

		if ($sourceName === null || $sourceName === '') {
			foreach ($this->sources as $key => $item) {
				try {
					return $item->getCompatibleSource(false);
				} catch (Exception $e) {
				}
			}
		}

		$this->access->checkPermission(
			$this->getUserRole(),
			Jodit::$app->action,
			$this->getPath()
		);

		return self::makeSource([], $this, 'default');
	}
}

Config::$defaultOptions = $defaultConfig;
