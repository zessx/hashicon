<?php

class HashIcon {

	/* Constants */
	const ADLER32 = 800;
	const CRC32 = 801;
	const CRC32B = 802;

	const HAVAL128_3 = 3200;
	const HAVAL128_4 = 3201;
	const HAVAL128_5 = 3202;
	const MD2 = 3203;
	const MD4 = 3204;
	const MD5 = 3205;
	const RIPEMD128 = 3206;
	const TIGER128_3 = 3207;
	const TIGER128_4 = 3206;

	const HAVAL160_3 = 4000;
	const HAVAL160_4 = 4001;
	const HAVAL160_5 = 4002;
	const RIPEMD160 = 4003;
	const SHA1 = 4004;
	const TIGER160_3 = 4005;
	const TIGER160_4 = 4006;

	const HAVAL192_3 = 4800;
	const HAVAL192_4 = 4801;
	const HAVAL192_5 = 4802;
	const TIGER192_3 = 4803;
	const TIGER192_4 = 4804;

	const HAVAL224_3 = 5600;
	const HAVAL224_4 = 5601;
	const HAVAL224_5 = 5602;

	const GOST = 6400;
	const HAVAL256_3 = 6401;
	const HAVAL256_4 = 6402;
	const HAVAL256_5 = 6403;
	const RIPEMD256 = 6404;
	const SHA256 = 6405;
	const SNEFRU = 6406;

	const RIPEMD320 = 8000;

	const SHA384 = 9600;

	const SHA512 = 12800;
	const WHIRLPOOL = 12801;

	const JPG = 'jpeg';
	const PNG = 'png';
	const GIF = 'gif';

	/* Private variables */
	private static $background = null;
	private static $colors = null;
	private static $shapes = array(
		array(0, 0, 1, 1, 0, 1),
		array(0, 0, 1, 1, 1, 0),
		array(0, 0, 0, 1, 1, 0),
		array(0, 1, 1, 0, 1, 1)
	);

	public static function toIcon($algo, $hash, $size = 300, $format = self::PNG)
	{
		/* Check algorythm */
		$algo = strtolower($algo);
		if(!in_array($algo, array(
			// self::ADLER32, self::CRC32, self::CRC32B,
			// self::HAVAL128_3, self::HAVAL128_4, self::HAVAL128_5, self::MD2, self::MD4, self::MD5, self::RIPEMD128, self::TIGER128_3, self::TIGER128_4,
			// self::HAVAL160_3, self::HAVAL160_4, self::HAVAL160_5, self::RIPEMD160, self::SHA1, self::TIGER160_3, self::TIGER160_4,
			// self::HAVAL192_3, self::HAVAL192_4, self::HAVAL192_5, self::TIGER192_3, self::TIGER192_4,
			// self::HAVAL224_3, self::HAVAL224_4, self::HAVAL224_5,
			self::GOST, self::HAVAL256_3, self::HAVAL256_4, self::HAVAL256_5, self::RIPEMD256, self::SHA256, self::SNEFRU,
			// self::RIPEMD320,
			// self::SHA384,
			// self::SHA512, self:: WHIRLPOOL
		)))
		{
			trigger_error('This algorythm is not supported, please use HashIcon constants (like HashIcon::SHA256).', E_USER_ERROR);
			return false;
		}
		$hashlen = floor($algo / 100);

		/* Check hash */
		if(!preg_match('/^[\da-f]{'.$hashlen.'}$/', $hash))
		{
			trigger_error('This hash is not a valid '.$algo.' hash: '.$hash, E_USER_ERROR);
			return false;
		}

		/* Check format */
		$format = strtolower($format);
		if(!in_array($format, array(self::PNG, self::JPG, self::GIF)))
		{
			trigger_error('This format is not supported, please use HashIcon constats (like HashIcon::PNG).', E_USER_ERROR);
			return false;
		}

		/* Create icon */
		$icon = imagecreatetruecolor($size / 2, $size / 2);

		/* Define colors */
		self::$background = imagecolorallocate($icon, 255, 255, 255);
		self::$colors = array(
			imagecolorallocate($icon, 231, 76, 60),
			imagecolorallocate($icon, 46, 204, 113),
			imagecolorallocate($icon,52, 152, 219),
			imagecolorallocate($icon, 241, 196, 15)
		);

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
		$function = 'image'.$format;
		$function($image);
		$output = ob_get_contents();
		ob_end_clean();

		/* Base 64 output */
		return base64_encode($output);
	}

	private static function toIcon64($icon, $hash, $size, $format)
	{
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
				self::$shapes[$dbit % 4], array($x * $size / 8, $y * $size / 8, $x * $size / 8, $y * $size / 8, $x * $size / 8, $y * $size / 8)
			);
			$color = self::$colors[floor($dbit / 4)];
			imagefilledpolygon($icon, $shape, 3, $color);
		}
		return $icon;
	}

}

?>