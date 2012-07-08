<script src="<?= $basePath ?>/style/jsbn/jsbn.js"></script>
<script src="<?= $basePath ?>/style/jsbn/prng4.js"></script>
<script src="<?= $basePath ?>/style/jsbn/rng.js"></script>
<script src="<?= $basePath ?>/style/jsbn/rsa.js"></script>
<script src="<?= $basePath ?>/style/bin2hex.js"></script>
<script src="<?= $basePath ?>/style/password.js.php"></script>

<h1>Password reset</h1>

<p>Enter a new password below to proceed.</p>

<form name="pcrypt" onsubmit="pcryptf()" action="reset.php?username=<?= $username ?>&email=<?= $email ?>&user_id=<?= $user_id ?>&auth=<?= $auth ?>" method="POST">
Password: <input type="password" name="password">
<br>Password confirmation: <input type="password" name="password_confirm">
<br><input type="submit" value="Reset password">
</form>
