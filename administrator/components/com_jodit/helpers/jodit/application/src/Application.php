<?php
/**
 * @package    jodit
 *
 * @author     Valeriy Chupurnov <chupurnov@gmail.com>
 * @license    GNU General Public License version 2 or later; see LICENSE
 * @link       https://xdsoft.net/jodit/
 */

namespace Jodit;

abstract class Application extends BaseApplication{

	/**
	 * Load all files from folder ore source or sources
	 */
	public function actionFiles() {
		$sources = [];

		$currentSource = $this->getSource();

		foreach ($this->config->sources as $key => $source) {
			if ($this->request->source && $this->request->source !== 'default' && $currentSource !== $source && $this->request->path !== './') {
				continue;
			}

			if ($this->accessControl->isAllow($this->getUserRole(), $this->action, $source->getPath())) {
				$sources[$key] = $this->read($source);
			}


		}

		return [
			'sources' => $sources
		];
	}

	/**
	 * Load all folders from folder ore source or sources
	 */
	public function actionFolders() {
		$sources = [];
		foreach ($this->config->sources as $key => $source) {
			if ($this->request->source && $this->request->source !== 'default' && $key !== $this->request->source && $this->request->path !== './') {
				continue;
			}

			$path = $source->getPath();

			try {
				$this->accessControl->checkPermission($this->getUserRole(), $this->action, $path);
			} catch (\Exception $e) {
				continue;
			}

			$sourceData = (object)[
				'baseurl' => $source->baseurl,
				'path' =>  str_replace(realpath($source->getRoot()) . Consts::DS, '', $path),
				'folders' => [],
			];

			$sourceData->folders[] = $path == $source->getRoot() ? '.' : '..';

			$dir = opendir($path);
			while ($file = readdir($dir)) {
				if (
					$file != '.' &&
					$file != '..' &&
					is_dir($path . $file) and
					(
						!$this->config->createThumb ||
						$file !== $this->config->thumbFolderName
					) and
					!in_array($file, $this->config->excludeDirectoryNames)
				) {
					$sourceData->folders[] = $file;
				}
			}

			$sources[$key] = $sourceData;
		}

		return [
			'sources' => $sources
		];
	}

	/**
	 * Load remote image by URL to self host
	 * @throws \Exception
	 */
	public function actionFileUploadRemote() {
		$url = $this->request->url;

		if (!$url) {
			throw new \Exception('Need url parameter', Consts::ERROR_CODE_BAD_REQUEST);
		}

		$result = parse_url($url);

		if (!isset($result['host']) || !isset($result['path'])) {
			throw new \Exception('Not valid URL', Consts::ERROR_CODE_BAD_REQUEST);
		}

		$filename = Helper::makeSafe(basename($result['path']));

		if (!$filename) {
			throw new \Exception('Not valid URL', Consts::ERROR_CODE_BAD_REQUEST);
		}

		$source = $this->config->getCompatibleSource($this->request->source);

		Helper::downloadRemoteFile($url, $source->getRoot() . $filename);

		$file = new File($source->getRoot() . $filename);

		try {
			if (!$file->isGoodFile($source)) {
				throw new \Exception('Bad file', Consts::ERROR_CODE_FORBIDDEN);
			}

			$this->accessControl->checkPermission($this->getUserRole(), $this->action, $source->getRoot(), $file->getExtension());
		} catch (\Exception $e) {
			$file->remove();
			throw $e;
		}

		return [
			'newfilename' => $file->getName(),
			'baseurl' => $source->baseurl,
		];
	}

	/**
	 * Upload images
	 *
	 * @return array
	 * @throws \Exception
	 */
	public function actionFileUpload() {

		$source = $this->config->getCompatibleSource($this->request->source);

		$root = $source->getRoot();
		$path = $source->getPath();

		$this->accessControl->checkPermission($this->getUserRole(), $this->action, $path);

		$messages = [];

		$files = $this->move($source);

		$isImages = [];
		$files = array_map(function (File $file) use ($source, $root, &$isImages) {
			$messages[] = 'File ' . $file->getName() . ' was uploaded';
			$isImages[] = $file->isImage();
			return str_replace($root, '', $file->getPath());
		}, $files);

		if (!count($files)) {
			throw new \Exception('No files have been uploaded', Consts::ERROR_CODE_NO_FILES_UPLOADED);
		}

		return [
			'baseurl' => $source->baseurl,
			'messages' => $messages,
			'files' => $files,
			'isImages' => $isImages
		];
	}

	/**
	 * Remove file
	 *
	 * @throws \Exception
	 */
	public function actionFileRemove() {
		$source = $this->getSource();

		$file_path = false;

		$path = $source->getPath();

		$this->accessControl->checkPermission($this->getUserRole(), $this->action, $path);

		$target = $this->request->name;

		if (
			realpath($path . $target) &&
			strpos(realpath($path . $target), $source->getRoot()) !== false
		) {
			$file_path = realpath($path . $target);
		}

		if (!$file_path || !file_exists($file_path)) {
			throw new \Exception('File or directory not exists ' . $path . $target, Consts::ERROR_CODE_NOT_EXISTS);
		}

		if (is_file($file_path)) {
			$file = new File($file_path);
			if (!$file->remove()) {
				$error = (object)error_get_last();
				throw new \Exception('Delete failed! ' . $error->message, Consts::ERROR_CODE_IS_NOT_WRITEBLE);
			}
		} else {
			throw new \Exception('It is not a file!', Consts::ERROR_CODE_IS_NOT_WRITEBLE);
		}
	}

	/**
	 * Remove folder
	 *
	 * @throws \Exception
	 */
	public function actionFolderRemove() {
		$source = $this->getSource();

		$file_path = false;

		$path = $source->getPath();

		$this->accessControl->checkPermission($this->getUserRole(), $this->action, $path);

		$target = $this->request->name;

		if (realpath($path . $target) && strpos(realpath($path . $target), $source->getRoot()) !== false) {
			$file_path = realpath($path . $target);
		}

		if ($file_path && file_exists($file_path)) {
			if (is_dir($file_path)) {
				$thumb = $file_path . Consts::DS . $source->thumbFolderName . Consts::DS;
				if (is_dir($thumb)) {
					Helper::deleteDir($thumb);
				}
				Helper::deleteDir($file_path);
			} else {
				throw new \Exception('It is not a directory!', Consts::ERROR_CODE_IS_NOT_WRITEBLE);
			}
		} else {
			throw new \Exception('Directory not exists', Consts::ERROR_CODE_NOT_EXISTS);
		}
	}

	/**
	 * Create directory
	 * @throws \Exception
	 */
	public function actionFolderCreate() {
		$source = $this->getSource();
		$destinationPath = $source->getPath();

		$this->accessControl->checkPermission($this->getUserRole(), $this->action, $destinationPath);

		$folderName = Helper::makeSafe($this->request->name);

		if ($destinationPath) {
			if ($folderName) {
				if (!realpath($destinationPath . $folderName)) {
					mkdir($destinationPath . $folderName, $source->defaultPermission);
					if (is_dir($destinationPath . $folderName)) {
						return ['messages' => ['Directory successfully created']];
					}
					throw new \Exception('Directory was not created', Consts::ERROR_CODE_NOT_EXISTS);
				}
				throw new \Exception('Directory already exists', Consts::ERROR_CODE_NOT_ACCEPTABLE);
			}
			throw new \Exception('The name for new directory has not been set', Consts::ERROR_CODE_NOT_ACCEPTABLE);
		}
		throw new \Exception('The destination directory has not been set', Consts::ERROR_CODE_NOT_ACCEPTABLE);
	}

	/**
	 * Move file or directory to another folder
	 *
	 * @throws \Exception
	 */
	public function actionMove() {
		$source = $this->getSource();
		$destinationPath = $source->getPath();
		$sourcePath = $source->getPath($this->request->from);

		$this->accessControl->checkPermission($this->getUserRole(), $this->action, $destinationPath);
		$this->accessControl->checkPermission($this->getUserRole(), $this->action, $sourcePath);

		if ($sourcePath) {
			if ($destinationPath) {
				if (is_file($sourcePath) or is_dir($sourcePath)) {
					rename($sourcePath, $destinationPath . basename($sourcePath));
				} else {
					throw new \Exception('Not file', Consts::ERROR_CODE_NOT_EXISTS);
				}
			} else {
				throw new \Exception('Need destination path', Consts::ERROR_CODE_BAD_REQUEST);
			}
		} else {
			throw new \Exception('Need source path', Consts::ERROR_CODE_BAD_REQUEST);
		}
	}

	/**
	 * Resize image
	 *
	 * @throws \Exception
	 */
	public function actionImageResize() {
		$source = $this->getSource();

		$this->accessControl->checkPermission($this->getUserRole(), $this->action, $source->getPath());

		$info = $this->getImageEditorInfo();

		if (!$info->box || (int)$info->box->w <= 0) {
			throw new \Exception('Width not specified', Consts::ERROR_CODE_BAD_REQUEST);
		}

		if (!$info->box || (int)$info->box->h <= 0) {
			throw new \Exception('Height not specified', Consts::ERROR_CODE_BAD_REQUEST);
		}


		$info->img
			->resize((int)$info->box->w, (int)$info->box->h)
			->save($info->path . $info->newname, $source->quality);
	}

	public function actionImageCrop() {
		$source = $this->getSource();

		$this->accessControl->checkPermission($this->getUserRole(), $this->action, $source->getPath());

		$info = $this->getImageEditorInfo();

		if ((int)$info->box->x < 0 || (int)$info->box->x > (int)$info->width) {
			throw new \Exception('Start X not specified', Consts::ERROR_CODE_BAD_REQUEST);
		}

		if ((int)$info->box->y < 0 || (int)$info->box->y > (int)$info->height) {
			throw new \Exception('Start Y not specified', Consts::ERROR_CODE_BAD_REQUEST);
		}

		if ((int)$info->box->w <= 0) {
			throw new \Exception('Width not specified', Consts::ERROR_CODE_BAD_REQUEST);
		}

		if ((int)$info->box->h <= 0) {
			throw new \Exception('Height not specified', Consts::ERROR_CODE_BAD_REQUEST);
		}

		$info->img
			->crop((int)$info->box->x, (int)$info->box->y, (int)$info->box->x + (int)$info->box->w, (int)$info->box->y + (int)$info->box->h)
			->save($info->path . $info->newname, $source->quality);

	}

	/**
	 * Get filepath by URL for local files
	 *
	 * @metod actionGetFileByURL
	 */
	public function actionGetLocalFileByUrl() {
		$url = $this->request->url;
		if (!$url) {
			throw new \Exception('Need full url', Consts::ERROR_CODE_BAD_REQUEST);
		}

		$parts = parse_url($url);

		if (empty($parts['path'])) {
			throw new \Exception('Empty url', Consts::ERROR_CODE_BAD_REQUEST);
		}

		$found = false;
		$path = '';
		$root = '';

		$key = 0;

		foreach ($this->config->sources as $key => $source) {
			if ($this->request->source && $this->request->source !== 'default' && $key !== $this->request->source && $this->request->path !== './') {
				continue;
			}

			$base = parse_url($source->baseurl);

			$path = preg_replace('#^(/)?' . $base['path'] . '#', '', $parts['path']);


			$root = $source->getPath();

			if (file_exists($root . $path) && is_file($root . $path)) {
				$file = new File($root . $path);
				if ($file->isGoodFile($source)) {
					$found = true;
					break;
				}
			}
		}

		if (!$found) {
			throw new \Exception('File does not exist or is above the root of the connector', Consts::ERROR_CODE_FAILED);
		}

		return [
			'path' => str_replace($root, '', dirname($root . $path) . Consts::DS),
			'name' => basename($path),
			'source' => $key
		];
	}

	public function actionPermissions() {
		$result = [];
		$source = $this->getSource();

		foreach (AccessControl::$defaultRule as $permission => $tmp) {
			if (preg_match('#^[A-Z_]+$#', $permission)) {
				$allow = false;
				try {
					$this->accessControl->checkPermission($this->getUserRole(), $permission, $source->getPath());
					$allow = true;
				} catch (\Exception $e) {
				}
				$result['allow' . Helper::CamelCase($permission)] = $allow;
			}
		}

		return [
			'permissions' => $result
		];
	}
}