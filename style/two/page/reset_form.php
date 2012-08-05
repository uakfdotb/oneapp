<script src="<?= $basePath ?>/style/jsbn/jsbn.js"></script>
<script src="<?= $basePath ?>/style/jsbn/prng4.js"></script>
<script src="<?= $basePath ?>/style/jsbn/rng.js"></script>
<script src="<?= $basePath ?>/style/jsbn/rsa.js"></script>
<script src="<?= $basePath ?>/style/bin2hex.js"></script>
<script src="<?= $basePath ?>/style/password.js.php"></script>

<h2 class="separate">Password reset</h2>

<form name="pcrypt" onsubmit="pcryptf()" action="reset.php" method="POST" class="uniForm">
<fieldset>    
<h3>Enter your username and email address below to reset your password. If you already submitted a reset request, then check your email for a link to follow. If you still experience problems logging in to the application system, <a href="contact.php">contact us</a>.</h3>
<div class="ctrlHolder">
	<label><em>*</em>Username</label>
	<input type="text" name="username">
</div>
<div class="ctrlHolder">
	<label><em>*</em>Email address</label>
	<input type="text" name="email">
</div>	
    <div class="buttonHolder">
		<input type="submit" value="Reset password" class="primaryAction reset">
	</div>
</fieldset>
</form>
