<?php

//depending on config and user, input may be the plaintext password or the encrypted one
//anyway we return plaintext hopefully
function decryptPassword($input) {
	$config = $GLOBALS['config'];
	
	if($config['rsa_modulus'] != '' && $config['rsa_exponent'] != '' && $config['rsa_key'] != '') {
		if(substr($input, 0, 5) == "enc: ") {
			$input = substr($input, 5);
			
			$res = openssl_pkey_get_private($config['rsa_key'], $config['rsa_passphrase']);
			openssl_private_decrypt(hex2bin($input), $plaintext, $res);
			return $plaintext;
		} else {
			return $input;
		}
	} else {
		return $input;
	}
}

?>
