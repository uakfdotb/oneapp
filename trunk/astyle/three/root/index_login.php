<script src="<?= $basePath ?>/style/jsbn/jsbn.js"></script>
<script src="<?= $basePath ?>/style/jsbn/prng4.js"></script>
<script src="<?= $basePath ?>/style/jsbn/rng.js"></script>
<script src="<?= $basePath ?>/style/jsbn/rsa.js"></script>
<script src="<?= $basePath ?>/style/bin2hex.js"></script>
<script src="<?= $basePath ?>/style/password.js.php"></script>

<h1>Root Administration Area</h1>

<form name="pcrypt" onsubmit="pcryptf()" method="POST" action="index.php">
<? if(!$user_loggedin) { ?>
<p>Please login with your username and password to access the root administration area.</p>
<? } else { ?>
<p>Please confirm your root password to continue.</p>
<? } ?>
<br />
<table class="log_in" width=60%>
<tr>
<? if(!$user_loggedin) { ?>
<td width=20%><p class="bold">Username</p></td><td align="right"><input type="text" name="username" style="width:80%"/></td></tr><tr>
<? } ?>
<td><p class="bold">Password</p></td><td align="right"><input type="password" name="password" style="width:80%"/></td></tr>
<tr><td colspan="3"><input type="submit" name="submit" value="Log in" class="login right"></td>
</tr></table>
</form>
