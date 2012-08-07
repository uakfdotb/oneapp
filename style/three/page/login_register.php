<script src="<?= $basePath ?>/style/jsbn/jsbn.js"></script>
<script src="<?= $basePath ?>/style/jsbn/prng4.js"></script>
<script src="<?= $basePath ?>/style/jsbn/rng.js"></script>
<script src="<?= $basePath ?>/style/jsbn/rsa.js"></script>
<script src="<?= $basePath ?>/style/bin2hex.js"></script>
<script src="<?= $basePath ?>/style/password.js.php"></script>

<div class="col2-4" style="margin-right:10px">
<form name="pcrypt" onsubmit="pcryptf()" action="register.php" method="POST" class="uniForm fullwidth">
<fieldset>
	<h2 class="separate">Register</h2>
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
<?
//Display all required profile items; $profile is an array of $var_id => ($var_name, $var_desc, $var_type)

foreach($profile as $var_id => $item) {
	writeField($var_id, $var_id, $item[0], $item[1], $item[2]);
}
?>  
<? if($config['captcha_enabled']) { ?>
<label for=""><img id="captcha" src="<?= $basePath ?>/securimage/securimage_show.php" alt="CAPTCHA Image" />
<a href="#" onclick="document.getElementById('captcha').src = '<?= $basePath ?>/securimage/securimage_show.php?' + Math.random(); return false"><img src="<?= $basePath ?>/securimage/images/refresh.gif" /></a></label>
<input type="text" name="captcha_code" />
<? } ?>      
        <div class="ctrlHolder">
<label for="">Acceptance of Use</label>By clicking register, I acknowledge all Terms and Conditions set by <?= $config['organization_name'] ?> and OneApp.
</div>      
    <div class="buttonHolder">
		<input type="submit" value="Register" class="submit primaryAction">
	</div>
</fieldset>
</form>
</div>

<div class="col2-4" >
<form name="pcrypt" onsubmit="pcryptf()" action="login.php" method="post" class="uniForm fullwidth">
	<h2 class="separate">Login</h2>
	<fieldset>
    <div class="ctrlHolder">
		<label><em>*</em>Username</label>
		<input type="text" name="username" />
	</div>      
    <div class="ctrlHolder">
		<label><em>*</em>Password</label>
		<input type="password" name="password" />
		<p class="formHint"><a href="reset.php">Forgot Password?</a></p>
	</div>
    <div class="buttonHolder">
		<input type="submit" value="Login" align="center" class="login primaryAction"/>
	</div>
</fieldset>
</form>
</div>
