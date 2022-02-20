<?php

namespace Jodit\actions;

use Jodit\components\Config;
use Jodit\components\Request;
use Jodit\Consts;
use Jodit\Helper;
use Exception;
use Jodit\interfaces\IFile;
use Jodit\interfaces\ISource;

/**
 * Trait File
 * @package Jodit\actions
 */
trait File {
	/**
	 * @var Request
	 */
	public $request;

	/**
	 * @var Config
	 */
	public $config;

	/**
	 * Load remote image by URL to self host
	 * @throws Exception
	 */
	public function actionFileUploadRemote() {
		$url = $this->request->url;

		if (!$url) {
			throw new Exception(
				'Need url parameter',
				Consts::ERROR_CODE_BAD_REQUEST
			);
		}

		$result = parse_url($url);

		if (!isset($result['host']) || !isset($result['path'])) {
			throw new Exception(
				'Not valid URL',
				Consts::ERROR_CODE_BAD_REQUEST
			);
		}

		$filename = Helper::makeSafe(basename($result['path']));

		if (!$filename) {
			throw new Exception(
				'Not valid URL',
				Consts::ERROR_CODE_BAD_REQUEST
			);
		}

		$source = $this->config->getCompatibleSource($this->request->source);

		Helper::downloadRemoteFile($url, $source->getRoot() . $filename);

		$file = $source->makeFile($source->getRoot() . $filename);

		try {
			if (!$file->isGoodFile($source)) {
				throw new Exception('Bad file', Consts::ERROR_CODE_FORBIDDEN);
			}

			$this->config->access->checkPermission(
				$this->config->getUserRole(),
				$this->action,
				$source->getRoot(),
				$file->getExtension()
			);
		} catch (Exception $e) {
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
	 * @throws Exception
	 */
	public function actionFileUpload() {
		$source = $this->config->getCompatibleSource($this->request->source);

		$root = $source->getRoot();
		$path = $source->getPath();

		$this->config->access->checkPermission(
			$this->config->getUserRole(),
			$this->action,
			$path
		);

		$messages = [];

		$files = $this->uploadedFiles($source);

		$isImages = [];

		$files = array_map(function ($file) use ($source, $root, &$isImages) {
			$messages[] = 'File ' . $file->getName() . ' was uploaded';
			$isImages[] = $file->isImage();
			return str_replace($root, '', $file->getPath());
		}, $files);

		if (!count($files)) {
			throw new Exception(
				'No files have been uploaded',
				Consts::ERROR_CODE_NO_FILES_UPLOADED
			);
		}

		return [
			'baseurl' => $source->baseurl,
			'messages' => $messages,
			'files' => $files,
			'isImages' => $isImages,
		];
	}

	/**
	 * Remove file
	 *
	 * @throws Exception
	 */
	public function actionFileRemove() {
		$this->config
			->getSource($this->request->source)
			->fileRemove($this->request->name);
	}

	/**
	 * @param ISource $source
	 * @return IFile[]
	 */
	abstract protected function uploadedFiles($source);

	/**
	 * Move file
	 * @throws Exception
	 */
	public function actionFileMove() {
		$this->config
			->getSource($this->request->source)
			->movePath($this->request->from);
	}

	/**
	 * Rename file
	 * @throws Exception
	 */
	public function actionFileRename() {
		$this->config
			->getSource($this->request->source)
			->renamePath($this->request->name, $this->request->newname);
	}

	/**
	 * Get filepath by URL for local files
	 * @throws Exception
	 */
	public function actionGetLocalFileByUrl() {
		$url = $this->request->url;

		if (!$url) {
			throw new Exception(
				'Need full url',
				Consts::ERROR_CODE_BAD_REQUEST
			);
		}

		$parts = parse_url($url);

		if (empty($parts['path'])) {
			throw new Exception('Empty url', Consts::ERROR_CODE_BAD_REQUEST);
		}

		foreach ($this->config->getSources() as $source) {
			$result = $source->resolveFileByUrl($url);

			if ($result) {
				return $result;
			}
		}

		throw new Exception(
			'File does not exist or is above the root of the connector',
			Consts::ERROR_CODE_FAILED
		);
	}

	/**
	 * Send file by path, source and name
	 */
	public function actionFileDownload() {
		$this->config
			->getSource($this->request->source)
			->fileDownload($this->request->name);
	}
}
