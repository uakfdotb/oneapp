<script src="<?= $basePath ?>/style/jsbn/jsbn.js"></script>
<script src="<?= $basePath ?>/style/jsbn/prng4.js"></script>
<script src="<?= $basePath ?>/style/jsbn/rng.js"></script>
<script src="<?= $basePath ?>/style/jsbn/rsa.js"></script>
<script src="<?= $basePath ?>/style/bin2hex.js"></script>
<script src="<?= $basePath ?>/style/password.js.php"></script>

<h2 class="separate">Password reset</h2>

<p>Enter a new password below to proceed.</p>

<form name="pcrypt" onsubmit="pcryptf()" action="reset.php?username=<?= $username ?>&email=<?= $email ?>&user_id=<?= $user_id ?>&auth=<?= $auth ?>" method="POST">
<table>
<tr><td>Password</tr><td><input type="password" name="password"></td></tr>
<tr><td>Password confirmation</td><td><input type="password" name="password_confirm"></td></tr>
<tr><td colspan="2"><input type="submit" value="Reset password" class="right"></td></tr>
</table>
</form>
