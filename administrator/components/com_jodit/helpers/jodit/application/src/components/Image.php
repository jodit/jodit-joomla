<?php
/**
 * @package    jodit
 *
 * @author     Valeriy Chupurnov <chupurnov@gmail.com>
 * @license    GNU General Public License version 2 or later; see LICENSE
 * @link       https://xdsoft.net/jodit/
 */
namespace Jodit\components;

use Jodit\interfaces\IFile;
use Jodit\interfaces\ISource;

/**
 * Class Image
 * @package Jodit
 */
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

	/**
	 * @param int[] $color
	 * @param float $percent
	 * @return int[]
	 */
	public static function luminate($color, $percent) {
		foreach ($color as &$value) {
			$value = (int)min(max(0, self::luminateValue($value, $percent)), 255);
		}

		return $color;
	}

	/**
	 * @param $value
	 * @param $percent
	 * @return float|int
	 */
	static function luminateValue($value, $percent) {
		// no change
		if ($percent == 50) {
			return $value;
		}

		// ratio = value from 0 to 2
		$ratio = ($percent * 2) / 100;

		// darken color
		if ($percent < 50) {
			return $value * $ratio;
		}

		// lighten color

		// reverse ratio
		$ratio = 2 - $ratio;

		$diff = (255 - $value) * $ratio;

		return 255 - $diff;
	}

	/**
	 * @param $r
	 * @param $g
	 * @param $b
	 * @return string
	 */
	public static function fromRGB($r, $g, $b) {
		$r = dechex($r);
		if (strlen($r) < 2) {
			$r = '0' . $r;
		}

		$g = dechex($g);
		if (strlen($g) < 2) {
			$g = '0' . $g;
		}

		$b = dechex((int)$b);
		if (strlen($b) < 2) {
			$b = '0' . $b;
		}

		return '#' . $r . $g . $b;
	}

	/**
	 * @param IFile $file
	 * @param string $iconName
	 * @param ISource $source
	 * @param int $width
	 * @param int $height
	 */
	public static function generateIcon(
		IFile $file,
		$iconName,
		ISource $source,
		$width = 100,
		$height = 100
	) {
		$word = $file->isDirectory()
			? 'folder'
			: strtoupper($file->getExtension());

		$code = ord($word[0]) % count(self::$colors);
		$color = self::$colors[$code];
		$darkColor = self::luminate($color, 30);
		$shadowColor = self::luminate($color, 45);

		$main = self::fromRGB($color[0], $color[1], $color[2]);
		$dark = self::fromRGB($darkColor[0], $darkColor[1], $darkColor[2]);
		$shadow = self::fromRGB(
			$shadowColor[0],
			$shadowColor[1],
			$shadowColor[2]
		);

		$labelX = 13;
		$labelY = 55;
		$labelWidth = strlen($word) < 5 ? 54 : 70;
		$labelHeight = 22;
		$textX = $labelX + $labelWidth / 2;
		$textY = $labelY + $labelHeight / 2 + 2;

		$label = $file->isDirectory()
			? ''
			: <<<HTML
		<g>
			<rect x="{$labelX}" y="{$labelY}" width="{$labelWidth}" height="{$labelHeight}" rx="4" fill="{$dark}"/>
			<text
          x="{$textX}"
          y="{$textY}"
          dominant-baseline="middle"
          text-anchor="middle"
          fill="white"
          font-family="Arial"
          font-size="16"
      >
      	{$word}
      </text>
		</g>
		<path d="M64.5 56.5L80 72V82.54V82.54C79.7186 86.7384 76.2078 90 72 90V90H52L20.5 77L64.5 56.5Z" fill="{$shadow}" fill-opacity="0.5"/>
HTML;

		$svg = <<<HTML
	<svg width="{$width}" height="{$height}" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
		<path d="M20 19C20 14.5817 23.5817 11 28 11H56L80 34.5V82C80 86.4183 76.4183 90 72 90H28C23.5817 90 20 86.4183 20 82V19Z" fill="{$main}"/>
		{$label}
		<path d="M79.5 34L80 36.5V42L64 33.5L60.5 31L79.5 34Z" fill="{$shadow}" fill-opacity="0.5"/>
		<path d="M56 11L80 34.5L66.063 34.1832C61.4741 34.079 57.699 30.538 57.3013 25.9652L56 11Z" fill="{$dark}"/>
	</svg>
HTML;

		$source->makeFile($iconName, $svg);
	}
}
