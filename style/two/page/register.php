<script src="<?= $basePath ?>/style/jsbn/jsbn.js"></script>
<script src="<?= $basePath ?>/style/jsbn/prng4.js"></script>
<script src="<?= $basePath ?>/style/jsbn/rng.js"></script>
<script src="<?= $basePath ?>/style/jsbn/rsa.js"></script>
<script src="<?= $basePath ?>/style/bin2hex.js"></script>
<script src="<?= $basePath ?>/style/password.js.php"></script>

<h2 class="separate">Registration</h2>

<form name="pcrypt" onsubmit="pcryptf()" action="register.php" method="POST" class="uniForm">
<fieldset>
	<h3>Enter the information below to register a new account. If you have already registered an account, you can <a href="login.php">login</a>. Please do not register multiple accounts under the same name: if you forgot your password, you can <a href="reset.php">reset it</a>.</h3>
<?
//first display all required profile items; $profile is an array of $var_id => ($var_name, $var_desc, $var_type)

foreach($profile as $var_id => $item) {
	writeField($var_id, $var_id, $item[0], $item[1], $item[2]);
}
?>      
        <div class="ctrlHolder">
<label for=""><em>*</em>Username</label>
<input type="text" name="username" />
</div>      
        <div class="ctrlHolder">
<label for=""><em>*</em>Full name</label>
	<input type="text" name="name" />
		<p class="formHint">Enter your first and last name, and middle initial if you have one</p>
</div>      
        <div class="ctrlHolder">
<label for=""><em>*</em>Email address</label>
	<input type="text" name="email" />
		<p class="formHint">Your password will be sent here</p>
</div>

<? if($config['captcha_enabled']) { ?>
<label for=""><img id="captcha" src="<?= $basePath ?>/securimage/securimage_show.php" alt="CAPTCHA Image" />
<a href="#" onclick="document.getElementById('captcha').src = '<?= $basePath ?>/securimage/securimage_show.php?' + Math.random(); return false"><img src="<?= $basePath ?>/securimage/images/refresh.gif" /></a></label>
<input type="text" name="captcha_code" />
<? } ?>      
        <div class="ctrlHolder">
<label for="">Acceptance of Use</label>By clicking register, I acknowledge all Terms and Conditions set by <?= $config['organization_name'] ?>.
</div>      
    <div class="buttonHolder">
		<input type="submit" value="Register" class="submit primaryAction">
	</div>
</fieldset>
</form>
