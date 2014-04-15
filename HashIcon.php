<?php

class HashIcon {

	private static $background = null;
	private static $colors = null;
	private static $shapes = [
		[0, 0, 1, 1, 0, 1],
		[0, 0, 1, 1, 1, 0],
		[0, 0, 0, 1, 1, 0],
		[0, 1, 1, 0, 1, 1]
	];

	public static function toIcon($algo, $hash, $size = 300, $format = 'png')
	{
		/* Check algorythm */
		$algo = strtolower($algo);
		if(!in_array($algo, array(
			// 'adler32', 'crc32', 'crc32b',
			// 'md2', 'md4', 'md5', 'haval128,3', 'haval128,5', 'ripemd128 ', 'tiger128,3', 'tiger128,4', 'haval128,4',
			// 'sha1', 'ripemd160', 'tiger160,3', 'tiger160,4', 'haval160,3', 'haval160,4', 'haval160,5',
			// 'tiger192,3', 'tiger192,4', 'haval192,3', 'haval192,4', 'haval192,5',
			// 'haval224,3', 'haval224,4', 'haval224,5',
			'sha256', 'ripemd256', 'snefru', 'gost', 'haval256,3', 'haval256,4', 'haval256,5',
			// 'ripemd320',
			// 'sha384',
			// 'sha512', 'whirlpool',
		)))
		{
			trigger_error('This hash algorythm is not supported by HashIcon: '.$algo, E_USER_ERROR);
			return false;
		}
		$hashlen = strlen(hash($algo, 'foo', false));

		/* Check hash */
		if(!preg_match('/^[\da-f]{'.$hashlen.'}$/', $hash))
		{
			trigger_error('This hash is not a valid '.$algo.' hash: '.$hash, E_USER_ERROR);
			return false;
		}

		/* Check format */
		$format = strtolower($format);
		if(!in_array($format, array('gif', 'jpeg', 'png')))
		{
			trigger_error('This format is not supported by HashIcon: '.$format, E_USER_ERROR);
			return false;
		}

		/* Create icon */
		$icon = imagecreatetruecolor($size / 2, $size / 2);

		/* Define colors */
		self::$background = imagecolorallocate($icon, 255, 255, 255);
		self::$colors = [
			imagecolorallocate($icon, 231, 76, 60),
			imagecolorallocate($icon, 46, 204, 113),
			imagecolorallocate($icon,52, 152, 219),
			imagecolorallocate($icon, 241, 196, 15)
		];

		/* Set Background */
		imagefill($icon, 0, 0, self::$background);

		/* Generate icon */
		$function = 'toIcon'.$hashlen;
		$icon = self::$function($icon, $hash, $size / 2, $format);

		/* Duplicate and rotate shapes */
		$image = imagecreatetruecolor($size, $size);
		imagecopy($image, $icon, 0, 0, 0, 0, $size / 2, $size / 2);
		$icon = imagerotate($icon, -90, 0);
		imagecopy($image, $icon, $size / 2, 0, 0, 0, $size / 2, $size / 2);
		$icon = imagerotate($icon, -90, 0);
		imagecopy($image, $icon, $size / 2, $size / 2, 0, 0, $size / 2, $size / 2);
		$icon = imagerotate($icon, -90, 0);
		imagecopy($image, $icon, 0, $size / 2, 0, 0, $size / 2, $size / 2);

		imagedestroy($icon);

		/* Create image */
		ob_start();
		if($format == 'gif')
			imagegif($image);
		elseif($format == 'jpeg')
			imagejpeg($image);
		elseif($format == 'png')
			imagepng($image);
		$output = ob_get_contents();
		ob_end_clean();

		/* Base 64 output */
		return base64_encode($output);
	}

	private static function toIcon64($icon, $hash, $size, $format)
	{
		/* Generate image */
		$hbits = str_split($hash);
		for($i = 0; $i < 64; $i++)
		{
			$y = floor($i / 8);
			$x = $i % 8;
			$dbit = hexdec($hbits[$i]);
			$shape = array_map(
				function($value, $size, $offset) {
					return $value * $size / 8 + $offset;
				},
				array_fill(0, 6, $size),
				self::$shapes[$dbit % 4], [$x * $size / 8, $y * $size / 8, $x * $size / 8, $y * $size / 8, $x * $size / 8, $y * $size / 8]
			);
			$color = self::$colors[floor($dbit / 4)];
			imagefilledpolygon(
				$icon,
				$shape,
				3,
				$color
			);
		}
		return $icon;
	}

}

?>