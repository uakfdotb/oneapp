<h1>Login</h1>
<?
if(isset($message)) {
	echo "<p>The username/password was incorrect. Please try again.</p>";
}
?>

<p>Login here if you have activated your account. If you do not have an account, <a href="register.php">register one</a> first. If you forgot your password, you can <a href="reset.php">reset it</a>.</p>

<form action="login.php" method="post">
<table width=30%>
<tr>
	<td><p align="right">Username:</p></td>
	<td><input type="text" name="username"/></td>
</tr>
<tr>
	<td><p align="right">Password:</p></td>
	<td><input type="password" name="password"/></td>
</tr>
<tr>
	<td colspan="2" align="right"><input type="submit" value="Login" align="center"/></td>
</tr>
</table>
</form>
