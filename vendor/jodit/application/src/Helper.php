<?php
namespace Jodit;

abstract class Helper {
	static $upload_errors = [
		0 => 'There is no error, the file uploaded with success',
		1 => 'The uploaded file exceeds the upload_max_filesize directive in php.ini',
		2 => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
		3 => 'The uploaded file was only partially uploaded',
		4 => 'No file was uploaded',
		6 => 'Missing a temporary folder',
		7 => 'Failed to write file to disk.',
		8 => 'A PHP extension stopped the file upload.',
	];


	/**
	 * Convert number bytes to human format
	 *
	 * @param $bytes
	 * @param int $decimals
	 * @return string
	 */
	static function humanFileSize($bytes, $decimals = 2) {
		$size = ['B','kB','MB','GB','TB','PB','EB','ZB','YB'];
		$factor = floor((strlen($bytes) - 1) / 3);
		return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . $size[(int)$factor];
	}

	/**
	 * Converts from human readable file size (kb,mb,gb,tb) to bytes
	 *
	 * @param {string|int} human readable file size. Example 1gb or 11.2mb
	 * @return int
	 */
	static function convertToBytes($from) {
		if (is_numeric($from)) {
			return (int)$from;
		}

		$number = substr($from, 0, -2);
		$formats = ["KB", "MB", "GB", "TB"];
		$format = strtoupper(substr($from, -2));

		return in_array($format, $formats) ? (int)($number * pow(1024, array_search($format, $formats) + 1)) : (int)$from;
	}

	static function translit ($str) {
		$str = (string)$str;

		$replace = [
			'а'=>'a','б'=>'b','в'=>'v','г'=>'g','д'=>'d','е'=>'e','ё'=>'yo','ж'=>'zh','з'=>'z','и'=>'i','й'=>'y',
			'к'=>'k','л'=>'l','м'=>'m','н'=>'n','о'=>'o','п'=>'p','р'=>'r','с'=>'s','т'=>'t','у'=>'u','ф'=>'f',
			'х'=>'h','ц'=>'ts','ч'=>'ch','ш'=>'sh','щ'=>'shch','ъ'=>'','ы'=>'i','ь'=>'','э'=>'e','ю'=>'yu','я'=>'ya',
			' '=>'-',
			'А'=>'A','Б'=>'B','В'=>'V','Г'=>'G','Д'=>'D','Е'=>'E','Ё'=>'Yo','Ж'=>'Zh','З'=>'Z','И'=>'I','Й'=>'Y',
			'К'=>'K','Л'=>'L','М'=>'M','Н'=>'N','О'=>'O','П'=>'P','Р'=>'R','С'=>'S','Т'=>'T','У'=>'U','Ф'=>'F',
			'Х'=>'H','Ц'=>'Ts','Ч'=>'CH','Ш'=>'Sh','Щ'=>'Shch','Ъ'=>'','Ы'=>'I','Ь'=>'','Э'=>'E','Ю'=>'Yu','Я'=>'Ya',
		];

		$str = strtr($str, $replace);

		return $str;
	}

	static function makeSafe($file) {
		$file = rtrim(self::translit($file), '.');
		$regex = ['#(\.){2,}#', '#[^A-Za-z0-9\.\_\- ]#', '#^\.#'];
		return trim(preg_replace($regex, '', $file));
	}

	/**
	 * Check by mimetype what file is image
	 *
	 * @param string $path
	 *
	 * @return bool
	 */
	static function isImage($path) {
		try {
			if (!function_exists('exif_imagetype')) {
				function exif_imagetype($filename) {
					if ((list(, , $type) = getimagesize($filename)) !== false) {
						return $type;
					}

					return false;
				}
			}

			return in_array(exif_imagetype($path), [IMAGETYPE_GIF, IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_BMP]);
		} catch (\Exception $e) {
			return false;
		}
	}


	/**
	 * Download remote file on server
	 *
	 * @param string $url
	 * @param string $destinationFilename
	 * @throws \Exception
	 */
	static function downloadRemoteFile($url, $destinationFilename) {
		if (!ini_get('allow_url_fopen')) {
			throw new \Exception('allow_url_fopen is disable', 501);
		}

		if (!function_exists('curl_init')) {
			$raw = file_get_contents($url);
		} else {

			$ch = curl_init($url);

			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);// таймаут4

			$response = parse_url($url);
			curl_setopt($ch, CURLOPT_REFERER, $response['scheme'] . '://' . $response['host']);
			curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:45.0) Gecko/20100101 Firefox/45.0');

			$raw = curl_exec($ch);

			curl_close($ch);
		}

		file_put_contents($destinationFilename, $raw);

		if (!self::isImage($destinationFilename)) {
			unlink($destinationFilename);
			throw new \Exception('Bad image ' . $destinationFilename, 406);
		}
	}

	/**
	 * @param $string
	 *
	 * @return string
	 */
	static function Upperize($string) {
		$string = preg_replace('#([a-z])([A-Z])#', '\1_\2', $string);
		return strtoupper($string);
	}

	/**
	 * @param $string
	 *
	 * @return string
	 */
	static function CamelCase($string) {
		$string = preg_replace_callback('#([_])(\w)#', function ($m) {
			return strtoupper($m[2]);
		}, strtolower($string));

		return ucfirst($string);
	}

	/**
	 * @param string $dirPath
	 */
	static function deleteDir($dirPath) {
		if (!is_dir($dirPath)) {
			throw new InvalidArgumentException("$dirPath must be a directory");
		}

		if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
			$dirPath .= '/';
		}

		$files = glob($dirPath . '*', GLOB_MARK);

		foreach ($files as $file) {
			if (is_dir($file)) {
				self::deleteDir($file);
			} else {
				unlink($file);
			}
		}

		rmdir($dirPath);
	}

	static public function NormalizePath($path) {
		return preg_replace('#[\\\\/]+#', '/', $path);
	}
}