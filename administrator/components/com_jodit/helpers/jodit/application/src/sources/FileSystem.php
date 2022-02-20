<?php

namespace Jodit\sources;

use claviska\SimpleImage;

use Exception;
use Jodit\components\Config;
use Jodit\components\File;
use Jodit\components\Image;
use Jodit\components\Jodit;
use Jodit\Consts;
use Jodit\Helper;
use Jodit\interfaces\IFile;
use Jodit\interfaces\ISource;

/**
 * Class FileSystem
 * @package Jodit\sources
 */
class FileSystem extends ISource {
	/**
	 * @param string $path
	 * @param string $content
	 * @return IFile
	 * @throws Exception
	 */
	public function makeFile($path, $content = null) {
		if ($content !== null) {
			file_put_contents($path, $content);
		}

		return File::create($path);
	}

	/**
	 * @param string $path
	 */
	public function makeFolder($path) {
		mkdir($path, $this->defaultPermission);
	}

	/**
	 * @param IFile $file
	 * @return mixed
	 */
	public function makeThumb(IFile $file) {
		$path = $file->getFolder();

		if (!is_dir($path . $this->thumbFolderName)) {
			$this->makeFolder($path . $this->thumbFolderName);
		}

		$thumbName =
			$path . $this->thumbFolderName . Consts::DS . $file->getName();

		if (!$file->isImage()) {
			$thumbName =
				$path .
				$this->thumbFolderName .
				Consts::DS .
				Helper::makeSafe($file->getName()) .
				'.svg';
		}

		if (!file_exists($thumbName)) {
			if ($file->isSVGImage()) {
				return $file;
			}

			if ($file->isImage()) {
				try {
					$img = new SimpleImage($file->getPath());

					$img->bestFit($this->thumbSize, $this->thumbSize)->toFile(
						$thumbName,
						'image/jpeg',
						$this->quality
					);

					unset($img);
				} catch (Exception $e) {
					return $file;
				}
			} else {
				Image::generateIcon($file, $thumbName, $this);
			}
		}

		return $this->makeFile($thumbName);
	}

	/**
	 * @return mixed
	 * @throws Exception
	 */
	public function items() {
		/**
		 * Read folder and retrun filelist
		 *
		 * @param Config $source
		 *
		 * @return object
		 * @throws Exception
		 */
		$path = $this->getPath();

		$sourceData = (object) [
			'baseurl' => $this->baseurl,
			'path' => str_replace(
				realpath($this->getRoot()) . Consts::DS,
				'',
				$path
			),
			'files' => [],
		];

		try {
			$this->access->checkPermission(
				$this->getUserRole(),
				Jodit::$app->action,
				$path
			);
		} catch (Exception $e) {
			return $sourceData;
		}

		$config = $this;

		$offset = Jodit::$app->request->getField('mods/offset', 0);
		$limit = Jodit::$app->request->getField(
			'mods/limit',
			$this->countInChunk
		);

		$sortBy = (string) Jodit::$app->request->getField(
			'mods/sortBy',
			$this->defaultSortBy
		);

		$files = array_filter(scandir($path), function ($file) use ($path) {
			return !$this->isExcluded($file);
		});

		if ($files === false) {
			throw new Exception('Files not found');
		}

		$files = $this->filterFiles($path, $files);

		$this->sortByMode($files, $sortBy);

		foreach (array_slice($files, $offset, $limit) as $index => $file) {
			/**
			 * @var IFile $file
			 */
			if (!$file->isDirectory()) {
				$item = [
					'file' => $file->getPathByRoot($this),
					'name' => $file->getName(),
					'type' => $file->isImage() ? 'image' : 'file',
				];

				if ($config->createThumb || !$file->isImage()) {
					$item['thumb'] = $this->makeThumb($file)->getPathByRoot(
						$this
					);
				}

				$item['changed'] = date(
					$config->datetimeFormat,
					$file->getTime()
				);

				$item['size'] = Helper::humanFileSize($file->getSize());
				$item['isImage'] = $file->isImage();

				$sourceData->files[] = $item;
			} else {
				$item = [
					'file' => $file->getPathByRoot($this),
					'name' => $file->getName(),
					'thumb' => $this->makeThumb($file)->getPathByRoot($this),
					'type' => 'folder',
				];

				$sourceData->files[] = $item;
			}
		}

		return $sourceData;
	}

	/**
	 * @return mixed
	 */
	public function folders() {
		$path = $this->getPath();

		$sourceData = (object) [
			'name' => $this->sourceName,
			'title' => $this->title,
			'baseurl' => $this->baseurl,
			'path' => str_replace(
				realpath($this->getRoot()) . Consts::DS,
				'',
				$path
			),
			'folders' => [],
		];

		if (Jodit::$app->request->dots !== false) {
			$sourceData->folders[] = $path === $this->getRoot() ? '.' : '..';
		}

		$dir = opendir($path);
		while ($file = readdir($dir)) {
			if (is_dir($path . $file) and !$this->isExcluded($file)) {
				$sourceData->folders[] = $file;
			}
		}

		return $sourceData;
	}

	/**
	 * @param string $file
	 * @return bool
	 */
	public function isExcluded($file) {
		return $file === '.' ||
			$file === '..' ||
			($this->createThumb && $file === $this->thumbFolderName) ||
			in_array($file, $this->excludeDirectoryNames);
	}

	/**
	 * @param string $path
	 * @return array
	 */
	private function getTree($path) {
		$dir = opendir($path);
		$tree = [];

		$this->access->checkPermission(
			$this->getUserRole(),
			'FOLDER_TREE',
			$path
		);

		while ($file = readdir($dir)) {
			if (is_dir($path . $file) and !$this->isExcluded($file)) {
				$tree[] = [
					'name' => $file,
					'path' => $path . $file,
					'sourceName' => $this->sourceName,
					'children' => $this->getTree($path . $file . '/'),
				];
			}
		}

		return $tree;
	}

	/**
	 * @param string $fromName
	 * @param string $newName
	 */
	public function renamePath($fromName, $newName) {
		$fromName = Helper::makeSafe($fromName);
		$fromPath = $this->getPath() . $fromName;

		$action = is_file($fromPath) ? 'FILE_RENAME' : 'FOLDER_RENAME';

		$this->access->checkPermission(
			$this->getUserRole(),
			$action,
			$fromPath
		);

		$newName = Helper::makeSafe($newName);
		$destinationPath = $this->getPath() . $newName;

		$this->access->checkPermission(
			$this->getUserRole(),
			$action,
			$destinationPath
		);

		if (!$fromPath) {
			throw new Exception(
				'Need source path',
				Consts::ERROR_CODE_BAD_REQUEST
			);
		}

		if (!$destinationPath) {
			throw new Exception(
				'Need destination path',
				Consts::ERROR_CODE_BAD_REQUEST
			);
		}

		if (!is_file($fromPath) and !is_dir($fromPath)) {
			throw new Exception(
				'Path not exists',
				Consts::ERROR_CODE_NOT_EXISTS
			);
		}

		if (is_file($fromPath)) {
			$ext = strtolower(pathinfo($fromPath, PATHINFO_EXTENSION));
			$newExt = strtolower(
				pathinfo($destinationPath, PATHINFO_EXTENSION)
			);
			if ($newExt !== $ext) {
				$destinationPath .= '.' . $ext;
			}
		}

		if (is_file($destinationPath) or is_dir($destinationPath)) {
			throw new Exception(
				'New ' . basename($destinationPath) . ' already exists',
				Consts::ERROR_CODE_BAD_REQUEST
			);
		}

		rename($fromPath, $destinationPath);
	}

	/**
	 * Move file or directory to another folder
	 * @throws Exception
	 */
	public function movePath($from) {
		$destinationPath = $this->getPath();
		$sourcePath = $this->getPath($from);

		$action = is_file($sourcePath) ? 'FILE_MOVE' : 'FOLDER_MOVE';

		$this->access->checkPermission(
			$this->getUserRole(),
			$action,
			$destinationPath
		);

		$this->access->checkPermission(
			$this->getUserRole(),
			$action,
			$sourcePath
		);

		if (!$sourcePath) {
			throw new Exception(
				'Need source path',
				Consts::ERROR_CODE_BAD_REQUEST
			);
		}

		if (!$destinationPath) {
			throw new Exception(
				'Need destination path',
				Consts::ERROR_CODE_BAD_REQUEST
			);
		}

		if (is_file($sourcePath) or is_dir($sourcePath)) {
			rename($sourcePath, $destinationPath . basename($sourcePath));
		} else {
			throw new Exception('Not file', Consts::ERROR_CODE_NOT_EXISTS);
		}
	}

	/**
	 * Remove file
	 * @param string $target
	 * @throws Exception
	 */
	public function fileRemove($target) {
		$file_path = false;

		$path = $this->getPath();

		$this->access->checkPermission(
			$this->getUserRole(),
			'FILE_REMOVE',
			$path
		);

		if (
			realpath($path . $target) &&
			strpos(realpath($path . $target), $this->getRoot()) !== false
		) {
			$file_path = realpath($path . $target);
		}

		if (!$file_path || !file_exists($file_path)) {
			throw new Exception(
				'File or directory not exists ' . $path . $target,
				Consts::ERROR_CODE_NOT_EXISTS
			);
		}

		if (is_file($file_path)) {
			$file = $this->makeFile($file_path);

			if (!$file->remove()) {
				$error = (object) error_get_last();

				throw new Exception(
					'Delete failed! ' . $error->message,
					Consts::ERROR_CODE_IS_NOT_WRITEBLE
				);
			}
		} else {
			throw new Exception(
				'It is not a file!',
				Consts::ERROR_CODE_IS_NOT_WRITEBLE
			);
		}
	}

	/**
	 * Download file
	 * @param string $target
	 * @throws Exception
	 */
	public function fileDownload($target) {
		$file_path = false;

		$path = $this->getPath();

		$this->access->checkPermission(
			$this->getUserRole(),
			'FILE_DOWNLOAD',
			$path
		);

		if (
			realpath($path . $target) &&
			strpos(realpath($path . $target), $this->getRoot()) !== false
		) {
			$file_path = realpath($path . $target);
		}

		if (!$file_path || !file_exists($file_path)) {
			throw new Exception(
				'File or directory not exists ' . $path . $target,
				Consts::ERROR_CODE_NOT_EXISTS
			);
		}

		if (is_file($file_path)) {
			$file = $this->makeFile($file_path);

			if (!$file->send()) {
				$error = (object) error_get_last();

				throw new Exception(
					'Download failed! ' . $error->message,
					Consts::ERROR_CODE_IS_NOT_WRITEBLE
				);
			}
		} else {
			throw new Exception(
				'It is not a file!',
				Consts::ERROR_CODE_IS_NOT_WRITEBLE
			);
		}
	}

	/**
	 * Remove folder
	 *
	 * @throws Exception
	 */
	public function folderRemove($name) {
		$file_path = false;

		$path = $this->getPath();

		$this->access->checkPermission(
			$this->getUserRole(),
			'FOLDER_REMOVE',
			$path
		);

		if (
			realpath($path . $name) &&
			strpos(realpath($path . $name), $this->getRoot()) !== false
		) {
			$file_path = realpath($path . $name);
		}

		if ($file_path && file_exists($file_path)) {
			if (is_dir($file_path)) {
				$thumb =
					$file_path .
					Consts::DS .
					$this->thumbFolderName .
					Consts::DS;

				if (is_dir($thumb)) {
					Helper::removeDirectory($thumb);
				}

				Helper::removeDirectory($file_path);
			} else {
				throw new Exception(
					'It is not a directory!',
					Consts::ERROR_CODE_IS_NOT_WRITEBLE
				);
			}
		} else {
			throw new Exception(
				'Directory not exists',
				Consts::ERROR_CODE_NOT_EXISTS
			);
		}
	}

	/**
	 * @param string $url
	 * @return mixed
	 */
	public function resolveFileByUrl($url) {
		$base = parse_url($this->baseurl);
		$parts = parse_url($url);

		$path = preg_replace(
			'#^(/)?' . $base['path'] . '#',
			'',
			$parts['path']
		);

		$root = $this->getPath();

		if (file_exists($root . $path) && is_file($root . $path)) {
			$file = $this->makeFile($root . $path);

			if ($file->isGoodFile($this)) {
				return [
					'path' => str_replace(
						$root,
						'',
						dirname($root . $path) . Consts::DS
					),
					'name' => basename($path),
					'source' => $this->sourceName,
				];
			}
		}

		return null;
	}

	/**
	 * @param string $path
	 * @param array<string> $files
	 * @return array<IFile>
	 * @throws Exception
	 */
	private function filterFiles($path, $files) {
		$result = [];

		$withFolders = Jodit::$app->request->getField(
			'mods/withFolders',
			false
		);

		$onlyImages = Jodit::$app->request->getField('mods/onlyImages', false);

		foreach ($files as $index => $fileName) {
			$file = $this->makeFile($path . $fileName);

			if (
				($file->isDirectory() && $withFolders) ||
				($file->isGoodFile($this) && (!$onlyImages || $file->isImage()))
			) {
				$result[] = $file;
			}
		}

		return $result;
	}

	/**
	 * @param array<IFile> $files
	 * @param string $sortBy
	 */
	private function sortByMode(array &$files, string $sortBy) {
		switch ($sortBy) {
			case 'name-asc':
				sort($files);
				break;

			case 'name-desc':
				rsort($files);
				break;

			case 'changed-desc':
			case 'changed-asc':
			case 'size-asc':
			case 'size-desc':
				usort($files, function ($fileA, $fileB) use ($sortBy) {
					switch ($sortBy) {
						case 'changed-desc':
						case 'changed-asc':
							$a = $fileA->getTime();
							$b = $fileB->getTime();

							return $sortBy === 'changed-asc'
								? $a - $b
								: $b - $a;

						case 'size-desc':
						case 'size-asc':
							$a = $fileA->getSize();
							$b = $fileB->getSize();

							return $sortBy === 'size-asc' ? $a - $b : $b - $a;
					}

					return 0;
				});

				break;

			default:
				rsort($files);
		}

		$foldersPosition = Jodit::$app->request->getField(
			'mods/foldersPosition',
			'default'
		);

		if ($foldersPosition !== 'default') {
			usort($files, function ($fileA, $fileB) use (
				$sortBy,
				$foldersPosition
			) {
				if ($fileA->isDirectory() && !$fileB->isDirectory()) {
					return $foldersPosition === 'top' ? -1 : 1;
				}

				if (!$fileA->isDirectory() && $fileB->isDirectory()) {
					return $foldersPosition === 'top' ? 1 : -1;
				}

				if ($fileA->isDirectory() && $fileB->isDirectory()) {
					return $fileA > $fileB ? 1 : -1;
				}
			});
		}
	}
}
