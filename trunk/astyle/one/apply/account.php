<script src="<?= $basePath ?>/style/jsbn/jsbn.js"></script>
<script src="<?= $basePath ?>/style/jsbn/prng4.js"></script>
<script src="<?= $basePath ?>/style/jsbn/rng.js"></script>
<script src="<?= $basePath ?>/style/jsbn/rsa.js"></script>
<script src="<?= $basePath ?>/style/bin2hex.js"></script>
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
	<td><p>Username</p></td>
	<td><p><?= $userInfo[0] ?></p></td>
</tr><tr>
	<td><p>Old password</p></td>
	<td><p><input type="password" name="old_password"> enter old password here to update information</p></td>
</tr>
<?
//profile information
foreach($profile as $item) {
	echo "<tr><td><p>" . $item[0] . "</p></td><td><p>" . $item[1] . "</p></td></tr>";
}
?>

<tr>
	<td><p>New password</p></td>
	<td><p><input type="password" name="new_password"> to change your password, fill in this and the below field</p></td>
</tr><tr>
	<td><p>Confirm new password</p></td>
	<td><p><input type="password" name="new_password_conf"></p></td>
</tr><tr>
	<td><p>Email</p></td>
	<td><p><input type="text" name="new_email" value="<?= $userInfo[1] ?>"></p></td>
</tr><tr>
	<td></td>
	<td><input type="submit" value="Update"></td>
</table>
</form>
