<script src="<?= $basePath ?>/style/jsbn/jsbn.js"></script>
<script src="<?= $basePath ?>/style/jsbn/prng4.js"></script>
<script src="<?= $basePath ?>/style/jsbn/rng.js"></script>
<script src="<?= $basePath ?>/style/jsbn/rsa.js"></script>
<script src="<?= $basePath ?>/style/bin2hex.js"></script>
<script src="<?= $basePath ?>/style/password.js.php"></script>

<h1>Password reset</h1>

<p>Enter your username and email address below to reset your password. If you already submitted a reset request, then check your email for a link to follow. If you still experience problems logging in to the application system, <a href="contact.php">contact us</a>.</p>

<form name="pcrypt" onsubmit="pcryptf()" action="reset.php" method="POST">
Username: <input type="text" name="username">
<br>Email address: <input type="text" name="email">
<br><input type="submit" value="Reset password">
</form>
