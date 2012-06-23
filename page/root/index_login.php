<script src="<?= $basePath ?>/style/jsbn/jsbn.js"></script>
<script src="<?= $basePath ?>/style/jsbn/prng4.js"></script>
<script src="<?= $basePath ?>/style/jsbn/rng.js"></script>
<script src="<?= $basePath ?>/style/jsbn/rsa.js"></script>
<script src="<?= $basePath ?>/style/password.js.php"></script>

<h1>Root Administration Area</h1>

<p>Please login with your root password to access the root administration area. Your root password can be reset manually in config.php.</p>

<form name="pcrypt" onsubmit="pcryptf()" method="POST" action="index.php">
<? if(!$user_loggedin) { ?>
Username: <input type="text" name="username" /><br />
<? } ?>
Password: <input type="password" name="password" /><br />
<input type="submit" name="submit" value="Submit" />
</form>
