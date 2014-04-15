<?php

require 'HashIcon.php';

$input = isset($_POST['input']) ? $_POST['input'] : 'Lorem ipsum dolor sit amet.';
$algo  = isset($_POST['algo']) ? $_POST['algo'] : 'sha256';
$hash  = hash($algo, $input);
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
			<!--
			<option value="adler32" <?php echo $algo == 'adler32' ? 'selected' : ''?>>adler32</option>
			<option value="crc32" <?php echo $algo == 'crc32' ? 'selected' : ''?>>crc32</option>
			<option value="crc32b" <?php echo $algo == 'crc32b' ? 'selected' : ''?>>crc32b</option>
			<option value="md2" <?php echo $algo == 'md2' ? 'selected' : ''?>>md2</option>
			<option value="md4" <?php echo $algo == 'md4' ? 'selected' : ''?>>md4</option>
			<option value="md5" <?php echo $algo == 'md5' ? 'selected' : ''?>>md5</option>
			<option value="haval128,3" <?php echo $algo == 'haval128,3' ? 'selected' : ''?>>haval128,3</option>
			<option value="haval128,5" <?php echo $algo == 'haval128,5' ? 'selected' : ''?>>haval128,5</option>
			<option value="ripemd128" <?php echo $algo == 'ripemd128' ? 'selected' : ''?>>ripemd128</option>
			<option value="tiger128,3" <?php echo $algo == 'tiger128,3' ? 'selected' : ''?>>tiger128,3</option>
			<option value="tiger128,4" <?php echo $algo == 'tiger128,4' ? 'selected' : ''?>>tiger128,4</option>
			<option value="haval128,4" <?php echo $algo == 'haval128,4' ? 'selected' : ''?>>haval128,4</option>
			<option value="sha1" <?php echo $algo == 'sha1' ? 'selected' : ''?>>sha1</option>
			<option value="ripemd160" <?php echo $algo == 'ripemd160' ? 'selected' : ''?>>ripemd160</option>
			<option value="tiger160,3" <?php echo $algo == 'tiger160,3' ? 'selected' : ''?>>tiger160,3</option>
			<option value="tiger160,4" <?php echo $algo == 'tiger160,4' ? 'selected' : ''?>>tiger160,4</option>
			<option value="haval160,3" <?php echo $algo == 'haval160,3' ? 'selected' : ''?>>haval160,3</option>
			<option value="haval160,4'" <?php echo $algo == 'haval160,4' ? 'selected' : ''?>>haval160,4'</option>
			<option value="haval160,5" <?php echo $algo == 'haval160,5' ? 'selected' : ''?>>haval160,5</option>
			<option value="tiger192,3" <?php echo $algo == 'tiger192,3' ? 'selected' : ''?>>tiger192,3</option>
			<option value="tiger192,4" <?php echo $algo == 'tiger192,4' ? 'selected' : ''?>>tiger192,4</option>
			<option value="haval192,3" <?php echo $algo == 'haval192,3' ? 'selected' : ''?>>haval192,3</option>
			<option value="haval192,4" <?php echo $algo == 'haval192,4' ? 'selected' : ''?>>haval192,4</option>
			<option value="haval192,5" <?php echo $algo == 'haval192,5' ? 'selected' : ''?>>haval192,5</option>
			<option value="haval224,3" <?php echo $algo == 'haval224,3' ? 'selected' : ''?>>haval224,3</option>
			<option value="haval224,4'" <?php echo $algo == 'haval224,4' ? 'selected' : ''?>>haval224,4'</option>
			<option value="haval224,5" <?php echo $algo == 'haval224,5' ? 'selected' : ''?>>haval224,5</option>
			-->
			<option value="sha256" <?php echo $algo == 'sha256' ? 'selected' : ''?>>sha256</option>
			<option value="ripemd256" <?php echo $algo == 'ripemd256' ? 'selected' : ''?>>ripemd256</option>
			<option value="snefru" <?php echo $algo == 'snefru' ? 'selected' : ''?>>snefru</option>
			<option value="gost" <?php echo $algo == 'gost' ? 'selected' : ''?>>gost</option>
			<option value="haval256,3" <?php echo $algo == 'haval256,3' ? 'selected' : ''?>>haval256,3</option>
			<option value="haval256,4" <?php echo $algo == 'haval256,4' ? 'selected' : ''?>>haval256,4</option>
			<option value="haval256,5" <?php echo $algo == 'haval256,5' ? 'selected' : ''?>>haval256,5</option>
			<!--
			<option value="ripemd320" <?php echo $algo == 'ripemd320' ? 'selected' : ''?>>ripemd320</option>
			<option value="sha384" <?php echo $algo == 'sha384' ? 'selected' : ''?>>sha384</option>
			<option value="sha512" <?php echo $algo == 'sha512' ? 'selected' : ''?>>sha512</option>
			<option value="whirlpool" <?php echo $algo == 'whirlpool' ? 'selected' : ''?>>whirlpool</option>
			-->
		</select>
		<input type="submit" value="Generate Unique Icon" />
	 </form>
</body>
</html>