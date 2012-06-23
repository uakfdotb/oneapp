<script src="<?= $basePath ?>/style/jsbn/jsbn.js"></script>
<script src="<?= $basePath ?>/style/jsbn/prng4.js"></script>
<script src="<?= $basePath ?>/style/jsbn/rng.js"></script>
<script src="<?= $basePath ?>/style/jsbn/rsa.js"></script>
<script src="<?= $basePath ?>/style/password.js.php"></script>

<h1>Account</h1>

<?
if(isset($message)) {
	echo "<p>" . $message . "</p>";
}
?>

<table>
<form name="pcrypt" onsubmit="pcryptf()" action="account.php" method="POST">
<tr>
	<td>Username</td>
	<td><?= $userInfo[0] ?></td>
</tr><tr>
	<td>Old password</td>
	<td><input type="password" name="old_password"> enter old password here to update information</td>
</tr>

<? page_advanced_include("user_profile", "apply", array('profile' => $profile)); ?>

<tr>
	<td>New password</td>
	<td><input type="password" name="new_password"> to change your password, fill in this and the below field</td>
</tr><tr>
	<td>Confirm new password</td>
	<td><input type="password" name="new_password_conf"></td>
</tr><tr>
	<td>Email</td>
	<td><input type="text" name="new_email" value="<?= $userInfo[1] ?>"></td>
</tr><tr>
	<td></td>
	<td><input type="submit" value="Update"></td>
</table>
</form>
