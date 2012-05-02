<h1>Account</h1>

<?
if(isset($message)) {
	echo "<p>" . $message . "</p>";
}
?>

<form action="account.php" method="POST">
<table widh=100%>
<tr>
	<td width=50%><p class="name">Username</p></td>
	<td><p class="name"><?= $userInfo[0] ?></p></td>
</tr><tr>
	<td><p class="name"><? echo '<img src="' . $stylePath . '/images/required.png" width="8px" class="required">'; ?>Old password</p><p class="desc">Enter old password here to update information</p></td>
	<td><p><input type="password" name="old_password"></p></td>
</tr><tr>
	<td><p class="name">New password</p><p class="desc">To change your password, fill in this and the below field</td>
	<td><p><input type="password" name="new_password"></p></td>
</tr><tr>
	<td><p class="name">Confirm new password</p></td>
	<td><p><input type="password" name="new_password_conf"></p></td>
</tr><tr>
	<td><p class="name">Email</p></td>
	<td><p><input type="text" name="new_email" value="<?= $userInfo[1] ?>"></p></td>
</tr>
</table>
<?
if(count($profile)>0){
	//profile information
echo "<div class=\"profile\"><table width=100%>";
	foreach($profile as $item) {
		echo "<tr><td width=50%><p class=\"name\">" . $item[0] . "</p></td><td><p>" . $item[1] . "</p></td></tr>";
	}
	echo "</table></div>";
}
?>
<table width=100%>
<tr>
	<td></td>
	<td align="right"><input type="submit" value="Update" class="update"></td>
</table>
</form>
