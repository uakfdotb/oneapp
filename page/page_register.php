<h1>Registration</h1>

<p>Enter the information below to register a new account. If you have already registered an account, you can <a href="login.php">login</a>. Please do not register multiple accounts under the same name: if you forgot your password, you can <a href="reset.php">reset it</a>.</p>

<form action="register.php" method="POST">
<?
//first display all required profile items; $profile is an array of $var_id => ($var_name, $var_desc, $var_type)

foreach($profile as $var_id => $item) {
	writeField($var_id, $var_id, $item[0], $item[1], $item[2]);
}
?>
Username: <input type="text" name="username">
<br>Email address: <input type="text" name="email"> your password will be sent to this address
<br><input type="submit" value="Register">
</form>
