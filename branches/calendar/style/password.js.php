<?
include("../config.php");

if($config['rsa_modulus'] != '' && $config['rsa_exponent'] != '' && $config['rsa_key'] != '') {
?>

function pcryptf() {
	var rsa = new RSAKey();
	rsa.setPublic("<?= $config['rsa_modulus'] ?>", "<?= $config['rsa_exponent'] ?>");
	
	if(document.pcrypt.password) {
		var res = rsa.encrypt(document.pcrypt.password.value);
	
		if(res) {
			document.pcrypt.password.value = "enc: " + res;
		}
	}
	
	if(document.pcrypt.password_confirm) {
		var res = rsa.encrypt(document.pcrypt.password_confirm.value);
	
		if(res) {
			document.pcrypt.password_confirm.value = "enc: " + res;
		}
	}
	
	if(document.pcrypt.new_password) {
		var res = rsa.encrypt(document.pcrypt.new_password.value);
	
		if(res) {
			document.pcrypt.new_password.value = "enc: " + res;
		}
	}
	
	if(document.pcrypt.password_confirm) {
		var res = rsa.encrypt(document.pcrypt.new_password_conf.value);
	
		if(res) {
			document.pcrypt.new_password_conf.value = "enc: " + res;
		}
	}
}

<? } else { ?>

function pcrypt() {
	return true;
}

<? } ?>
