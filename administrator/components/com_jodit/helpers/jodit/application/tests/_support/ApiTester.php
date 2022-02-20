<?php

use Codeception\Actor;
use Codeception\Lib\Friend;

/**
 * Inherited Methods
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method Friend haveFriend($name, $actorClass = NULL)
 *
 * @SuppressWarnings(PHPMD)
 */
class ApiTester extends Actor {
	use _generated\ApiTesterActions;

	/**
	 * Define custom actions here
	 */
	public function recurseCopy(string $src, string $dst) {
		$dir = opendir($src);
		@mkdir($dst);

		while (false !== ($file = readdir($dir))) {
			if ($file !== '.' && $file !== '..') {
				if (is_dir($src . '/' . $file)) {
					$this->recurseCopy($src . '/' . $file, $dst . '/' . $file);
				} else {
					copy($src . '/' . $file, $dst . '/' . $file);
				}
			}
		}

		closedir($dir);
	}

	/**
	 * @param string $dirPath
	 */
	public function recurseRemove(string $dirPath) {
		if (is_dir($dirPath)) {
			$objects = scandir($dirPath);
			foreach ($objects as $object) {
				if ($object !== '.' && $object !== '..') {
					if (
						filetype($dirPath . DIRECTORY_SEPARATOR . $object) ===
						'dir'
					) {
						$this->recurseRemove(
							$dirPath . DIRECTORY_SEPARATOR . $object
						);
					} else {
						unlink($dirPath . DIRECTORY_SEPARATOR . $object);
					}
				}
			}

			reset($objects);
			rmdir($dirPath);
		}
	}
}
