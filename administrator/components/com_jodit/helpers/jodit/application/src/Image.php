<?php
/**
 * @package    jodit
 *
 * @author     Valeriy Chupurnov <chupurnov@gmail.com>
 * @license    GNU General Public License version 2 or later; see LICENSE
 * @link       https://xdsoft.net/jodit/
 */
namespace Jodit;

use abeautifulsite\SimpleImage;

class Image {
	static $colors = [
		[228, 84, 83],
		[237, 234, 67],
		[122, 223, 237],
		[228, 84, 83],
		[245, 170, 43],
		[174, 196, 70],
		[212, 110, 173],
		[241, 197, 222],
		[222, 145, 154],
		[143, 205, 190],
		[148, 16, 76],
		[146, 165, 171],
		[0, 106, 180],
		[0, 106, 180],
	];

    static function luminate($color, $percent) {
		foreach ($color as &$value) {
			$value = min(max(0, self::luminateValue($value, $percent)), 255);
		}

		return $color;
	}

    static function luminateValue($value, $percent) {
		// no change
		if ($percent == 50) {
			return $value;
		}

		// ratio = value from 0 to 2
		$ratio = $percent * 2 / 100;

		// darken color
		if ($percent < 50) {
			return $value * $ratio;
		}

		// lighten color

		// reverse ratio
		$ratio = 2 - $ratio;

		$diff  = (255 - $value) * $ratio;

		return 255 - $diff;
	}

	static function ImageRectangleWithRoundedCorners(&$im, $x1, $y1, $x2, $y2, $radius, $color) {
		imagefilledrectangle($im, $x1+$radius, $y1, $x2-$radius, $y2, $color);
		imagefilledrectangle($im, $x1, $y1+$radius, $x2, $y2-$radius, $color);
		imagefilledellipse($im, $x1+$radius, $y1+$radius, $radius*2, $radius*2, $color);
		imagefilledellipse($im, $x2-$radius, $y1+$radius, $radius*2, $radius*2, $color);
		imagefilledellipse($im, $x1+$radius, $y2-$radius, $radius*2, $radius*2, $color);
		imagefilledellipse($im, $x2-$radius, $y2-$radius, $radius*2, $radius*2, $color);
	}

	static function generateIcon(File $file, $iconname, $width = 100, $height = 100) {
		$im     = imagecreatetruecolor($width, $height);
		imageantialias ( $im , true);

		$black = imagecolorallocate($im, 0, 0, 0);
		imagecolortransparent($im, $black);
		$word = $file->getExtension();
		$code = ord($word[0]) % count(self::$colors);
		$color = self::$colors[$code];
		$darkColor = self::luminate($color, 30);
		$shadowColor = self::luminate($color, 45);

		$main  = imagecolorallocate($im, $color[0], $color[1], $color[2]);
		$dark = imagecolorallocate($im, $darkColor[0], $darkColor[1], $darkColor[2]);
		$shadow = imagecolorallocate($im, $shadowColor[0], $shadowColor[1], $shadowColor[2]);
		$white  = imagecolorallocate($im, 255, 255, 255);

		$offset = $width / 4;

		// canvas
		self::ImageRectangleWithRoundedCorners($im,  $width / 5, 0, $width, $height, 10, $main);

		// label shadow
		imagefilledpolygon($im, [
			$width - $width / 5, $height / 2 + 3,
			$width, $height / 2 + $height / 6 - 2,
			$width, $height - 10,
			$width - 10, $height,
			$width / 2 + 10, $height,
			$width / 5, $height - $width / 6,
		], 6, $shadow);
		imagefilledellipse($im, $width - 10, $height - 10, 10 * 2, 10 * 2, $shadow);

		// label
		self::ImageRectangleWithRoundedCorners($im, 0, $height / 2, $width - $width / 5,$height - $width / 6, 5, $dark);

		// crease shadow
		imagefilledpolygon($im, [
			$width - $offset, $offset - 5,
			$width, $offset - 5,
			$width, $offset + 10,
		], 3, $shadow);

		// crease
		self::ImageRectangleWithRoundedCorners($im, $width - $offset, -$height + $offset, 2 * $width - $offset, $offset, 10, $dark);

		// transparent right top angle
		imagefilledpolygon($im, [
			$width - $offset, 0,
			$width, 0,
			$width, $offset,
		], 3, $black);



		// text
		$box = imagettfbbox ( 20 , 0, __DIR__ . '/assets/arial.ttf', strtoupper($word));
		$px     = (($width - $width / 5) - ($box[2] - $box[0])) / 2;
		imagettftext($im, 20, 0, $px, $height - $height / 4.5, $white, __DIR__ . '/assets/arial.ttf', strtoupper($word));


		imagepng($im, $iconname);
		imagecolordeallocate($im, $black );
		imagecolordeallocate($im, $main );
		imagecolordeallocate($im, $dark );
		imagecolordeallocate($im, $shadow );
		imagecolordeallocate($im, $white );
		imagedestroy($im);
	}

	/**
	 * @param \Jodit\File $file
	 *
	 * @return \Jodit\File
	 */
	static function getThumb(File $file, Config $config) {
		$path = $file->getFolder();

		if (!is_dir($path . $config->thumbFolderName)) {
			mkdir($path . $config->thumbFolderName, 0777);
		}

		$thumbName = $path . $config->thumbFolderName . Consts::DS . $file->getName();
		if (!$file->isImage()) {
			$thumbName = $path . $config->thumbFolderName . Consts::DS . $file->getName() . '.png';
		}

		if (!file_exists($thumbName)) {
			if ($file->isImage()) {
				try {
					$img = new SimpleImage($file->getPath());
					$img
						->best_fit(150, 150)
						->save($thumbName, $config->quality);
				} catch (\Exception $e) {
					return $file;
				}
			} else {
				self::generateIcon($file, $thumbName);
			}
		}

		return new File($thumbName);
	}
}