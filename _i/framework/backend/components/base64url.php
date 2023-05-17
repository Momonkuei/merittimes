<?php

class base64url
{
	/*
	 * http://stackoverflow.com/questions/1374753/passing-base64-encoded-strings-in-url
	 */
	// 加號，yii會濾掉
	public static function encode($data)
	{
		//return strtr(base64_encode($data), '+/=', '-_,');
		return strtr(base64_encode($data), '+/=', '*_,');
		//return substr_replace(strtr(base64_encode($data), '+/=', '*_,'),2);
	}

	public static function decode($base64)
	{
		//return base64_decode(strtr($base64, '*_', '+/'));
		//return base64_decode(strtr($base64, '-_,', '+/='));
		return base64_decode(strtr($base64, '*_,', '+/='));
	}

	//// 目前只有/auth/font會用得到。但目前沒有用
	//public static function decode_other($base64)
	//{
	//	return base64_decode(strtr($base64, '-_', '+/'));
	//}

	// http://php.net/manual/en/function.base64-encode.php#82947
	// unchanged, thanx Tom, Andy, fsx.nr01
	//function encode($input) {
	//	return strtr(base64_encode($input), '+/=', '-_,');
	//}

	//function decode($input) {
	//	return base64_decode(strtr($input, '-_,', '+/='));
	//}

	//// some variables are used for clarity, they can be avoided and lines can be shortened:

	//function encryptId($int, $TableSalt='') {
	//	global $GlobalSalt;    // global secret for salt.
	//   
	//	$HashedChecksum = substr(sha1($TableSalt.$int.$GlobalSalt), 0, 6);
	//	// The length of the "HashedChecksum" is another little secret,
	//	// but when the integers are small, it reveals...
	//   
	//	$hex = dechex($int);
	//	// The integer is better obfuscated by being HEX like the hash.
	//   
	//	return base64url_encode($HashedChecksum.$hex);
	//	// reordered, alternatively use substr() with negative lengths...
	//}

	//function decryptId($string, $TableSalt='') {
	//	// checks if the second part of the base64 encoded string is correct.
	//	global $GlobalSalt;    // global secret for salt.
	//	$parts = base64url_decode($string);
	//	$hex = substr($parts, 6);
	//	$int = hexdec($hex);
	//	$part1 = substr($parts, 0, 6);    // The "checksum/salt" is always the same length
	//   
	//	return substr(sha1($TableSalt.$int.$GlobalSalt), 0, 6) === $part1
	//		? $int
	//		: false;    // distinguish "0" and "false"
	//}

}
