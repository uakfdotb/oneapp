<?php

//depending on config and user, input may be the plaintext password or the encrypted one
//anyway we return plaintext hopefully
function decryptPassword($input) {
	$config = $GLOBALS['config'];
	
	if($config['rsa_modulus'] != '' && $config['rsa_exponent'] != '' && $config['rsa_key'] != '' && isset($_SESSION['crypt_key'])) {
		if(substr($input, 0, 5) == "enc: ") {
			$input = substr($input, 5);
			
			$res = openssl_pkey_get_private($config['rsa_key'], $config['rsa_passphrase']);
			openssl_private_decrypt(hex2bin($input), $plaintext, $res);
			
			//loop through current session login keys and try all of them that haven't expired
			foreach($_SESSION['crypt_key'] as $arrayKey => $key_array) { //key_array is array(time key was generated, hexadecimal key)
				if(time() - $key_array[0] > 5 * 60) {
					//delete keys older than 5 minutes
					//shouldn't take that long to login anyway!
					unset($_SESSION['crypt_key'][$arrayKey]);
				} else {
					$crypt_key = hex2bin($key_array[1]);
					
					//first part of plaintext should be equal to crypt key
					if(substr($plaintext, 0, strlen($crypt_key)) == $crypt_key) {
						return substr($plaintext, strlen($crypt_key));
					}
					
					//if not, continue iterating
				}
			}
			
			//none of the keys above worked, either forgery or expired form
			return "";
		} else {
			return $input;
		}
	} else {
		return $input;
	}
}

?>
