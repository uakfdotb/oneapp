<h1>Account</h1>

<?
if(isset($error)) {
	echo "<p>" . $error . "</p>";
}
?>

<form action="account.php" method="POST">
Old password: <input type="password" name="old_password"> enter old password here to update information
<?
//profile information
foreach($profile as $item) {
	echo "<br>" . $item[0] . ": " . $item[1];
}
?>
<br>New password: <input type="password" name="new_password"> to change your password, fill in this and the below field
<br>Confirm new password: <input type="password" name="new_password_conf">
<br>New email: <input type="text" name="new_email">
<br><input type="submit" value="Update">
</form>
