<h1>Registration</h1>

<p>Enter the information below to register a new account. If you have already registered an account, you can <a href="login.php">login</a>. Please do not register multiple accounts under the same name: if you forgot your password, you can <a href="reset.php">reset it</a>.</p><br><br>

<form action="register.php" method="POST">
<table width="400px">
<?
//first display all required profile items; $profile is an array of $var_id => ($var_name, $var_desc, $var_type)

foreach($profile as $var_id => $item) {
	writeField($var_id, $var_id, $item[0], $item[1], $item[2]);
}
?>
<tr><td><p class="name">*Username</p></td><td><input type="text" name="username" style="width:100%"></td></tr>
<tr><td><p class="name">*Email address</p><p class="desc">Your password will be sent here</p></td><td><input type="text" name="email" style="width:100%"></td></tr>
<tr><td colspan="2"><p class="name">Acceptance of Use</p><p class="desc">By clicking register, I acknowledge all Terms and Conditions set by OneApp.</p></td></tr>
<tr><td colspan="2" align="right"><input type="submit" value="Register"></td></tr>
</table>
</form>
