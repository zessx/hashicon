<?php

require 'HashIcon.php';

$algorythms = [
	// HashIcon::ADLER32 => array('name' => 'ADLER-32', 'function' => 'adler32'),
	// HashIcon::CRC32 => array('name' => 'CRC-32', 'function' => 'crc32'),
	// HashIcon::CRC32B => array('name' => 'CRC-32B', 'function' => 'crc32b'),

	// HashIcon::HAVAL128_3 => array('name' => 'HAVAL-128,3', 'function' => 'haval128,3'),
	// HashIcon::HAVAL128_4 => array('name' => 'HAVAL-128,4', 'function' => 'haval128,4'),
	// HashIcon::HAVAL128_5 => array('name' => 'HAVAL-128,5', 'function' => 'haval128,5'),
	// HashIcon::MD2 => array('name' => 'MD2', 'function' => 'md2'),
	// HashIcon::MD4 => array('name' => 'MD4', 'function' => 'md4'),
	// HashIcon::MD5 => array('name' => 'MD5', 'function' => 'md5'),
	// HashIcon::RIPEMD128 => array('name' => 'RIPEMD-128', 'function' => 'ripemd128'),
	// HashIcon::TIGER128_3 => array('name' => 'TIGER-128,3', 'function' => 'tiger128,3'),
	// HashIcon::TIGER128_4 => array('name' => 'TIGER-128,4', 'function' => 'tiger128,4'),

	// HashIcon::HAVAL160_3 => array('name' => 'HAVAL-160,3', 'function' => 'haval160,3'),
	// HashIcon::HAVAL160_4 => array('name' => 'HAVAL-160,4', 'function' => 'haval160,4'),
	// HashIcon::HAVAL160_5 => array('name' => 'HAVAL-160,5', 'function' => 'haval160,5'),
	// HashIcon::RIPEMD160 => array('name' => 'RIPEMD-160', 'function' => 'ripemd160'),
	// HashIcon::SHA1 => array('name' => 'SHA-1', 'function' => 'sha1'),
	// HashIcon::TIGER160_3 => array('name' => 'TIGER-160,3', 'function' => 'tiger160,3'),
	// HashIcon::TIGER160_4 => array('name' => 'TIGER-160,4', 'function' => 'tiger160,4'),

	// HashIcon::HAVAL192_3 => array('name' => 'HAVAL-192,3', 'function' => 'haval192,3'),
	// HashIcon::HAVAL192_4 => array('name' => 'HAVAL-192,4', 'function' => 'haval192,4'),
	// HashIcon::HAVAL192_5 => array('name' => 'HAVAL-192,5', 'function' => 'haval192,5'),
	// HashIcon::TIGER192_3 => array('name' => 'TIGER-192,3', 'function' => 'tiger192,3'),
	// HashIcon::TIGER192_4 => array('name' => 'TIGER-192,4', 'function' => 'tiger192,4'),

	// HashIcon::HAVAL224_3 => array('name' => 'HAVAL-224,3', 'function' => 'haval224,3'),
	// HashIcon::HAVAL224_4 => array('name' => 'HAVAL-224,4', 'function' => 'haval224,4'),
	// HashIcon::HAVAL224_5 => array('name' => 'HAVAL-224,5', 'function' => 'haval224,5'),

	HashIcon::GOST => array('name' => 'GOST', 'function' => 'gost'),
	HashIcon::RIPEMD256 => array('name' => 'RIPEMD-256', 'function' => 'ripemd256'),
	HashIcon::HAVAL256_3 => array('name' => 'HAVAL-256,3', 'function' => 'haval256,3'),
	HashIcon::HAVAL256_4 => array('name' => 'HAVAL-256,4', 'function' => 'haval256,4'),
	HashIcon::HAVAL256_5 => array('name' => 'HAVAL-256,5', 'function' => 'haval256,5'),
	HashIcon::SHA256 => array('name' => 'SHA-256', 'function' => 'sha256'),
	HashIcon::SNEFRU => array('name' => 'SNEFRU', 'function' => 'snefru'),

	// HashIcon::RIPEMD320 => array('name' => 'RIPEMD-320', 'function' => 'ripemd320'),

	// HashIcon::SHA384 => array('name' => 'SHA-384', 'function' => 'sha384'),

	// HashIcon::SHA512 => array('name' => 'SHA-512', 'function' => 'sha512'),
	// HashIcon::WHIRLPOOL => array('name' => 'WHIRLPOOL, 'function' => 'whirlpool')'
];
ksort($algorythms);

$input = isset($_POST['input']) ? $_POST['input'] : 'Lorem ipsum dolor sit amet.';
$algo  = isset($_POST['algo']) ? $_POST['algo'] : HashIcon::SHA256;
$hash  = hash($algorythms[$algo]['function'], $input);
$image = HashIcon::toIcon($algo, $hash);

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>HashIcon</title>
	<style>
	form, img {
		display: block;
		width: 300px;
		margin: 25px auto;
		text-align: center;
	}
	label, input {
		box-sizing: border-box;
		width: 200px;
	}
	</style>
</head>
<body>
	<img src="data:image/png;base64,<?php echo $image; ?>" alt="<?php echo $hash; ?>" title="<?php echo $hash; ?>">
	<form method="post">
		<input name="input" id="input" type="text" required value="<?php echo htmlentities($input); ?>">
		<select name="algo">
		<?php
			foreach ($algorythms as $key => $algorythm) {
				echo '<option value="'.$key.'"'.($algo == $key ? ' selected' : '').'>'.$algorythm['name'].'</option>'."\r\n";
			}
		?>
		</select>
		<input type="submit" value="Generate Unique Icon" />
	 </form>
</body>
</html>