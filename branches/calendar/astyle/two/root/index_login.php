<h1>Root Administration Area</h1>

<form method="POST" action="index.php">
<table class="center">
<? if(!$user_loggedin) { ?>
<p>Please login with your username and password to access the root administration area.</p>
<? } else { ?>
<p>Please confirm your root password to continue.</p>
<? } ?>
<tr>
<? if(!$user_loggedin) { ?>
<td>Username <input type="text" name="username" /></td>
<? } ?>
<td>Password <input type="password" name="password"></td>
<td><input type="submit" name="submit" value="Submit"></td>
</tr></table>
</form>
