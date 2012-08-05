<script src="<?= $basePath ?>/style/jsbn/jsbn.js"></script>
<script src="<?= $basePath ?>/style/jsbn/prng4.js"></script>
<script src="<?= $basePath ?>/style/jsbn/rng.js"></script>
<script src="<?= $basePath ?>/style/jsbn/rsa.js"></script>
<script src="<?= $basePath ?>/style/bin2hex.js"></script>
<script src="<?= $basePath ?>/style/password.js.php"></script>

<h2 class="separate">Login</h2>

<form name="pcrypt" onsubmit="pcryptf()" action="login.php" method="post" class="uniForm">
	<fieldset>
	<h3>Login here if you have activated your account. If you do not have an account, <a href="register.php">register</a> now!</h3>
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
