<?php
/**
 * @package    jodit
 *
 * @author     Valeriy Chupurnov <chupurnov@gmail.com>
 * @license    GNU General Public License version 2 or later; see LICENSE
 * @link       https://xdsoft.net/jodit/
 */

namespace Jodit\components;

use claviska\SimpleImage;
use Exception;
use Jodit\Consts;
use Jodit\Helper;
use Jodit\interfaces\IFile;
use Jodit\interfaces\ISource;

/**
 * Class BaseApplication
 * @package Jodit
 */
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
	 * Check whether the user has the ability to view files
	 * You can define JoditCheckPermissions function in config.php and use it
	 */
	abstract public function checkAuthentication();

	protected function corsHeaders() {
		if (isset($_SERVER['HTTP_ORIGIN'])) {
			header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
		} else {
			header('Access-Control-Allow-Origin: *');
		}

		header('Access-Control-Allow-Credentials: true');
		header(
			'Access-Control-Allow-Headers: Origin,X-Requested-With,Content-Type,Accept'
		);
		header('Access-Control-Max-Age: 86400'); // cache for 1 day

		if ($this->request->getMethod() === 'OPTIONS') {
			if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'])) {
				header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
			}

			exit(0);
		}
	}

	public function display() {
		$version = json_decode(
			file_get_contents(__DIR__ . '/../../package.json')
		)->version;
		header('X-App-version: ' . $version);

		if ($this->config && !$this->config->debug) {
			if (ob_get_length()) {
				ob_end_clean();
			}
			header('Content-Type: application/json');
		} else {
			$this->response->elapsedTime = microtime(true) - $this->startedTime;
		}

		echo json_encode(
			$this->response,
			(!$this->config or $this->config->debug)
				? JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES
				: 0
		);
		die();
	}

	/**
	 * @throws Exception
	 */
	public function execute() {
		$methods = get_class_methods($this);

		if (!in_array('action' . ucfirst($this->action), $methods)) {
			throw new Exception(
				'Action "' . htmlspecialchars($this->action) . '" not found',
				Consts::ERROR_CODE_NOT_EXISTS
			);
		}

		$this->config->access->checkPermission(
			$this->config->getUserRole(),
			$this->action
		);

		$this->response->data = (object) call_user_func_array(
			[$this, 'action' . $this->action],
			[]
		);

		$this->response->success = true;
		$this->response->data->code = 220;

		$this->display();
	}

	/**
	 * Constructor FileBrowser
	 *
	 * @param {array} $config
	 * @throws Exception
	 */

	private $startedTime;

	/**
	 * BaseApplication constructor.
	 *
	 * @param $config
	 *
	 * @throws Exception
	 */
	function __construct($config) {
		$this->startOutputBuffer();

		$this->startedTime = microtime(true);

		$this->response = new Response();

		set_error_handler(function ($ignore, $error, $errorFile, $errorLine) {
			throw new Exception(
				$error .
					((!$this->config or $this->config->debug)
						? ' - file:' . $errorFile . ' line:' . $errorLine
						: ''),
				501
			);
		});

		set_exception_handler([$this, 'exceptionHandler']);

		$this->config = new Config($config, null);
		$this->request = new Request();

		if ($this->config->allowCrossOrigin) {
			$this->corsHeaders();
		}

		$this->action = $this->request->action;

		$this->config->access->setAccessList($this->config->accessControl);
		Jodit::$app = $this;
	}

	protected function startOutputBuffer() {
		ob_start();
	}

	/**
	 * @return object
	 * @throws Exception
	 */
	protected function getImageEditorInfo() {
		$source = $this->config->getSource($this->request->source);
		$path = $source->getPath();

		$file = $this->request->name;

		$box = (object) ['w' => 0, 'h' => 0, 'x' => 0, 'y' => 0];

		if ($this->request->box && is_array($this->request->box)) {
			foreach ($box as $key => &$value) {
				$value = isset($this->request->box[$key])
					? $this->request->box[$key]
					: 0;
			}
		}

		$newName = $this->request->newname
			? Helper::makeSafe($this->request->newname)
			: '';

		if (
			!$path ||
			!$file ||
			!file_exists($path . $file) ||
			!is_file($path . $file)
		) {
			throw new Exception(
				'File not exists',
				Consts::ERROR_CODE_NOT_EXISTS
			);
		}

		$img = new SimpleImage();

		$img->fromFile($path . $file);

		if ($newName) {
			$info = pathinfo($path . $file);

			// if has not same extension
			if (!preg_match('#\.(' . $info['extension'] . ')$#i', $newName)) {
				$newName = $newName . '.' . $info['extension'];
			}

			if (
				!$this->config->allowReplaceSourceFile and
				file_exists($path . $newName)
			) {
				throw new Exception(
					'File ' . $newName . ' already exists',
					Consts::ERROR_CODE_BAD_REQUEST
				);
			}
		} else {
			$newName = $file;
		}

		if (
			file_exists(
				$path . $this->config->thumbFolderName . Consts::DS . $newName
			)
		) {
			unlink(
				$path . $this->config->thumbFolderName . Consts::DS . $newName
			);
		}

		return (object) [
			'path' => $path,
			'file' => $file,
			'box' => $box,
			'newname' => $newName,
			'img' => $img,
			'width' => $img->getWidth(),
			'height' => $img->getHeight(),
		];
	}

	/**
	 * @param Exception $e
	 */
	public function exceptionHandler($e) {
		$this->response->success = false;
		$this->response->data->code = $e->getCode();
		$this->response->data->messages[] = $e->getMessage();

		if (!$this->config or $this->config->debug) {
			do {
				$traces = $e->getTrace();
				$this->response->data->messages[] = implode(' - ', [
					$e->getFile(),
					$e->getLine(),
				]);
				foreach ($traces as $trace) {
					$line = [];
					if (isset($trace['file'])) {
						$line[] = $trace['file'];
					}
					if (isset($trace['function'])) {
						$line[] = $trace['function'];
					}
					if (isset($trace['line'])) {
						$line[] = $trace['line'];
					}
					$this->response->data->messages[] = implode(' - ', $line);
				}
				$e = $e->getPrevious();
			} while ($e);
		}

		$this->display();
	}

	/**
	 * @param ISource $source
	 * @return IFile[]
	 * @throws Exception
	 */
	public function uploadedFiles($source) {
		if (!isset($_FILES[$source->defaultFilesKey])) {
			throw new Exception(
				'Incorrect request',
				Consts::ERROR_CODE_BAD_REQUEST
			);
		}

		$files = $_FILES[$source->defaultFilesKey];
		/**
		 * @var $output File[]
		 */
		$output = [];

		try {
			if (
				isset($files) and
				is_array($files) and
				isset($files['name']) and
				is_array($files['name']) and
				count($files['name'])
			) {
				foreach ($files['name'] as $i => $file) {
					if ($files['error'][$i]) {
						throw new Exception(
							isset(Helper::$uploadErrors[$files['error'][$i]])
								? Helper::$uploadErrors[$files['error'][$i]]
								: 'Error',
							$files['error'][$i]
						);
					}

					$path = $source->getPath();
					$tmp_name = $files['tmp_name'][$i];
					$new_path = $path . Helper::makeSafe($files['name'][$i]);

					if (!move_uploaded_file($tmp_name, $new_path)) {
						if (!is_writable($path)) {
							throw new Exception(
								'Destination directory is not writeble',
								Consts::ERROR_CODE_IS_NOT_WRITEBLE
							);
						}

						throw new Exception(
							'No files have been uploaded',
							Consts::ERROR_CODE_NO_FILES_UPLOADED
						);
					}

					$file = $source->makeFile($new_path);

					try {
						$this->config->access->checkPermission(
							$this->config->getUserRole(),
							$this->action,
							$source->getRoot(),
							pathinfo($file->getPath(), PATHINFO_EXTENSION)
						);
					} catch (Exception $e) {
						$file->remove();
						throw $e;
					}

					if (!$file->isGoodFile($source)) {
						$file->remove();
						throw new Exception(
							'File type is not in white list',
							Consts::ERROR_CODE_FORBIDDEN
						);
					}

					if (
						$source->maxFileSize and
						$file->getSize() >
							Helper::convertToBytes($source->maxFileSize)
					) {
						$file->remove();
						throw new Exception(
							'File size exceeds the allowable',
							Consts::ERROR_CODE_FORBIDDEN
						);
					}

					$output[] = $file;
				}
			}
		} catch (Exception $e) {
			foreach ($output as $file) {
				$file->remove();
			}
			throw $e;
		}

		return $output;
	}

	/**
	 * @return string
	 */
	public function getRoot() {
		return realpath($_SERVER['DOCUMENT_ROOT']) . Consts::DS;
	}
}
