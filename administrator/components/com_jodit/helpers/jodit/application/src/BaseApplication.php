<?php
namespace Jodit;

use abeautifulsite\SimpleImage;

abstract class BaseApplication {

	/**
	 * @property Response $response
	 */
	public $response;

	/**
	 * @property Request $request
	 */
	public $request;


	/**
	 * @property string $action
	 */
	public $action;

	/**
	 * @var Config
	 */
	public $config;

	/**
	 * @var \Jodit\AccessControl
	 */
	public $accessControl;

	/**
	 * Check whether the user has the ability to view files
	 * You can define JoditCheckPermissions function in config.php and use it
	 */
	abstract public function checkAuthentication ();

	protected function corsHeaders() {
		if (isset($_SERVER['HTTP_ORIGIN'])) {
			header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
		} else {
			header("Access-Control-Allow-Origin: *");
		}

		header('Access-Control-Allow-Credentials: true');
		header('Access-Control-Allow-Headers: Origin,X-Requested-With,Content-Type,Accept');
		header('Access-Control-Max-Age: 86400');    // cache for 1 day

		if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
			if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'])) {
				header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
			}

			exit(0);
		}

	}

	public function display () {

		if ($this->config && !$this->config->debug) {
			if (ob_get_length()) {
				ob_end_clean();
			}
			header('Content-Type: application/json');
		}

		// replace full path from message
		if ($this->config) {
			foreach ($this->config->sources as $source) {
				if (isset($this->response->data->messages)) {
					foreach ($this->response->data->messages as &$message) {
						$message = str_replace($source->root, '/', $message);
						$message = str_replace(__DIR__, '/', $message);
					}
				}
			}
		}

		echo json_encode($this->response, (!$this->config or $this->config->debug) ? JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES: 0);
	}

	/**
	 * Get user role
	 *
	 * @return string
	 */
	public function getUserRole() {
		return isset($_SESSION[$this->config->roleSessionVar]) ? $_SESSION[$this->config->roleSessionVar] : $this->config->defaultRole;
	}

	public function execute () {
		$methods =  get_class_methods($this);

		if (!preg_match('#^[a-z_A-Z0-9]+$#', $this->action) or strlen($this->action) > 50) {
			throw new \Exception('Bad action', 404);
		}

		if (in_array('action' . ucfirst($this->action), $methods)) {
			$this->accessControl->checkPermission($this->getUserRole(), $this->action);
			$this->response->data =  (object)call_user_func_array([$this, 'action' . $this->action], []);
		} else {
			throw new \Exception('Action "' . $this->action . '" not found', 404);
		}

		$this->response->success = true;
		$this->response->data->code = 220;
		$this->display();
	}

	/**
	 * Constructor FileBrowser
	 *
	 * @param {array} $config
	 * @throws \Exception
	 */

	/**
	 * BaseApplication constructor.
	 *
	 * @param $config
	 *
	 * @throws \Exception
	 */
	function __construct ($config) {
		ob_start();

		error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT);
		ini_set('display_errors', 'on');

		$this->response  = new Response();

		set_error_handler(function ($errno, $errstr, $errfile, $errline) {
			throw new \Exception($errstr .  ((!$this->config or $this->config->debug) ? ' - file:' . $errfile . ' line:' . $errline : ''), 501);
		});

		set_exception_handler([$this, 'exceptionHandler']);

		$this->config  = new Config($config);

		if ($this->config->allowCrossOrigin) {
			$this->corsHeaders();
		}


		$this->request  = new Request();

		$this->action  = $this->request->action;

		if (!$this->config->debug) {
			error_reporting(0);
			ini_set('display_errors', 'off');
		}

		if ($this->request->source && $this->request->source !== 'default' && empty($this->config->sources[$this->request->source])) {
			throw new \Exception('Need valid parameter source key', 400);
		}

		$this->accessControl = new AccessControl();
		$this->accessControl->setAccessList($this->config->accessControl);
	}

	/**
	 * Get default(first) source or by $_REQUEST['source']
	 *
	 * @return \Jodit\Source
	 */
	public function getSource() {
		$source = null;

		if (isset($this->config->sources) and count($this->config->sources)) {
			if (!$this->request->source || empty($this->config->sources[$this->request->source])) {
				$source =  array_values($this->config->sources)[0];
			} else {
				$source = $this->config->sources[$this->request->source];
			}
		}

		return $source instanceof Source ? $source : new Source([], $this->config);
	}


	/**
	 * Check file extension
	 *
	 * @param {string} $file
	 * @param {Source} $source
	 * @return bool
	 */
	protected function isGoodFile($file, Source $source) {
		$info = pathinfo($file);

		if (!isset($info['extension']) or (!in_array(strtolower($info['extension']), $source->extensions))) {
			return false;
		}

		if (in_array(strtolower($info['extension']), $source->imageExtensions) and !Helper::isImage($file)) {
			return false;
		}

		return true;
	}

	protected function getImageEditorInfo() {
		$source = $this->getSource();
		$path = $source->getPath();

		$file = $this->request->name;

		$box = (object)[
			'w' => 0,
			'h' => 0,
			'x' => 0,
			'y' => 0,
		];

		if ($this->request->box && is_array($this->request->box)) {
			foreach ($box as $key=>&$value) {
				$value = isset($this->request->box[$key]) ? $this->request->box[$key] : 0;
			}
		}

		$newName = $this->request->newname ?  Helper::makeSafe($this->request->newname) : '';

		if (!$path || !$file || !file_exists($path . $file) || !is_file($path . $file)) {
			throw new \Exception('Source file not set or not exists', 404);
		}

		$img = new SimpleImage();


		$img->load($path . $file);


		if ($newName) {
			$info = pathinfo($path . $file);

			// if has not same extension
			if (!preg_match('#\.(' . $info['extension'] . ')$#i', $newName)) {
				$newName = $newName . '.' . $info['extension'];
			}

			if (!$this->config->allowReplaceSourceFile and file_exists($path . $newName)) {
				throw new \Exception('File ' . $newName . ' already exists', 400);
			}
		} else {
			$newName = $file;
		}

		if (file_exists($path . $this->config->thumbFolderName . DIRECTORY_SEPARATOR . $newName)) {
			unlink($path . $this->config->thumbFolderName . DIRECTORY_SEPARATOR . $newName);
		}

		$info = $img->get_original_info();

		return (object)[
			'path' => $path,
			'file' => $file,
			'box' => $box,
			'newname' => $newName,
			'img' => $img,
			'width' => $info['width'],
			'height' => $info['height'],
		];
	}

	/**
	 * Error handler
	 *
	 * @param {int} errno contains the level of the error raised, as an integer.
	 * @param {string} errstr contains the error message, as a string.
	 * @param {string} errfile which contains the filename that the error was raised in, as a string.
	 * @param {string} errline which contains the line number the error was raised at, as an integer.
	 */
	public function errorHandler ($errorNumber, $errorMessage, $file, $line) {
		$this->response->success = false;
		$this->response->data->code = $errorNumber;
		$this->response->data->messages[] = $errorMessage . ((!$this->config or $this->config->debug) ? ' - file:' . $file . ' line:' . $line : '');

		$this->display();
		return true;
	}

	/**
	 * @param \Exception $exception
	 */
	public function exceptionHandler ($exception) {
		$this->errorHandler($exception->getCode(), $exception->getMessage(), $exception->getFile(), $exception->getLine());
	}
}