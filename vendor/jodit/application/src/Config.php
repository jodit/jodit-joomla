<?php
namespace Jodit;

/**
 * Class Config
 * @property \jodit\Source[] $sources
 * @property string $thumbFolderName
 * @property bool $allowCrossOrigin
 * @property bool $createThumb
 * @property string[] $excludeDirectoryNames
 * @property number $quality
 * @property string $datetimeFormat
 * @package jodit
 */
class Config {
	private $data = [];
	private $defaultOptuions = [];

	/**
	 * @var bool
	 */
	public $debug = true; // must be true

	/**
	 * @var Source[]
	 */
	public $sources = [];

	/**
	 * @var string
	 */
	public $datetimeFormat = 'm/d/Y g:i A';

	/**
	 * @var int
	 */
	public $quality = 90;

	/**
	 * @var int
	 */
	public $defaultPermission = 0775;

	/**
	 * @var bool
	 */
	public $createThumb = true;

	/**
	 * @var string
	 */
	public $thumbFolderName = '_thumbs';

	/**
	 * @var string[]
	 */
	public $excludeDirectoryNames = ['.tmb', '.quarantine'];

	/**
	 * @var string
	 */
	public $maxFileSize = '8mb';

	/**
	 * @var bool
	 */
	public $allowCrossOrigin = false;

	/**
	 * @var array
	 * @see https://github.com/xdan/jodit-connectors#access-control
	 */
	public $accessControl = [];

	/**
	 * @var string
	 */
	public $roleSessionVar = 'JoditUserRole';

	/**
	 * @var string
	 */
	public $defaultRole = 'guest';

	/**
	 * @var bool
	 */
	public $allowReplaceSourceFile = true;

	/**
	 * @var string
	 */
	public $baseurl = '';

	/**
	 * @var string
	 */
	public $root = '';

	/**
	 * @var string[]
	 */
	public $extensions = ['jpg', 'png', 'gif', 'jpeg'];

	/**
	 * @var string[]
	 */
	public $imageExtensions = ['jpg', 'png', 'gif', 'jpeg', 'bmp'];

	/**
	 * @var int
	 */
	public $maxImageWidth = 1900;

	/**
	 * @var int
	 */
	public $maxImageHeight = 1900;

	function __get($key) {
		if (!empty($this->data->{$key})) {
			return $this->data->{$key};
		}
		if ($this->defaultOptuions->{$key}) {
			return $this->defaultOptuions->{$key};
		}

		throw new \ErrorException('Option ' . $key . ' not set', 501);
	}

	/**
	 * Config constructor.
	 *
	 * @param array $data
	 * @param false|array $defaultOptuions
	 */
	function __construct($data, $defaultOptuions = false) {
		$this->baseurl = ((isset($_SERVER['HTTPS']) and $_SERVER['HTTPS']) ? 'https://' : 'http://') . (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '') . '/';

		$this->data = (object)$data;

		foreach ($this->data as $key => $value) {
			switch ($key) {
				case 'sources':
					foreach ($value as $key => $source) {
						$this->sources[$key] = new Source($source, $this);
					}
					break;
				default:
					if (property_exists($this, $key)) {

						$this->{$key} = $value;
					}
			}
		}

		if (!count($this->sources) or !(array_values($this->sources)[0] instanceof Source)) {
			$this->sources = [new Source([], $this)];
		}

		$this->defaultOptuions = (object)($defaultOptuions?:[]);
	}
}