<?php 

define("ENC_KEY", "qhlg7l246j3b56ns");

/**
 * Encripta la cadena recibida
 * @param $pure_string
 * @param $iv
 * @return Cadena encriptada
 */
function encrypt($pure_string, $iv = "ahejalismche48ap") {
	$iv_size = mcrypt_get_iv_size ( MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC );
	if (!isset ( $iv )) {
		$iv = mcrypt_create_iv ( $iv_size, MCRYPT_RAND );
	}
	$encrypted_string = base64_encode ( $iv . mcrypt_encrypt ( MCRYPT_RIJNDAEL_128, ENC_KEY, utf8_encode ( $pure_string ), MCRYPT_MODE_CBC, $iv ) );
	return $encrypted_string;
}

/**
 * Desencripta la cadena recibida
 * @param $encrypted_string
 * @param $iv
 * @return Cadena desencriptada
 */
function decrypt($encrypted_string, $iv = "ahejalismche48ap") {
	$iv_size = mcrypt_get_iv_size ( MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC );
	$ciphertext_dec = base64_decode($encrypted_string);
	$iv_dec = substr ( $ciphertext_dec, 0, $iv_size );
	$ciphertext_dec = substr($ciphertext_dec, $iv_size);
	$decrypted_string = mcrypt_decrypt ( MCRYPT_RIJNDAEL_128, ENC_KEY, $ciphertext_dec, MCRYPT_MODE_CBC, $iv_dec );
	return $decrypted_string;
}

?>