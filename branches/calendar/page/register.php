<script src="<?= $basePath ?>/style/jsbn/jsbn.js"></script>
<script src="<?= $basePath ?>/style/jsbn/prng4.js"></script>
<script src="<?= $basePath ?>/style/jsbn/rng.js"></script>
<script src="<?= $basePath ?>/style/jsbn/rsa.js"></script>
<script src="<?= $basePath ?>/style/password.js.php"></script>

<h1>Registration</h1>

<p>Enter the information below to register a new account. If you have already registered an account, you can <a href="login.php">login</a>. Please do not register multiple accounts under the same name: if you forgot your password, you can <a href="reset.php">reset it</a>.</p><br><br>

<form name="pcrypt" onsubmit="pcryptf()" action="register.php" method="POST">
<table>
<?
//first display all required profile items; $profile is an array of $var_id => ($var_name, $var_desc, $var_type)

foreach($profile as $var_id => $item) {
	writeField($var_id, $var_id, $item[0], $item[1], $item[2]);
}
?>
<tr>
	<td>*Username</td>
	<td><input type="text" name="username"></td>
</tr>
<tr>
	<td>*Full name<br />
		Enter your full name</td>
	<td><input type="text" name="name"></td>
</tr>
<tr>
	<td>*Email address<br />
		Your password will be sent here</td>
	<td><input type="text" name="email"></td>
</tr>

<? if($config['captcha_enabled']) { ?>
<tr>
	<td colspan="2">
		<img id="captcha" src="<?= $basePath ?>/securimage/securimage_show.php" alt="CAPTCHA Image" />
		<a href="#" onclick="document.getElementById('captcha').src = '<?= $basePath ?>/securimage/securimage_show.php?' + Math.random(); return false"><img src="<?= $basePath ?>/securimage/images/refresh.gif" /></a>
		<input type="text" name="captcha_code" size="10" maxlength="6" />
	</td>
</tr>
<? } ?>

<tr>
	<td colspan="2">Acceptance of Use<br />
		By clicking register, I acknowledge all Terms and Conditions set by <?= $config['organization_name'] ?>.
	</td>
</tr>
<tr>
	<td colspan="2">
		<input type="submit" value="Register">
	</td>
</tr>
</table>
</form>
