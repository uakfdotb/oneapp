<script src="<?= $basePath ?>/style/jsbn/jsbn.js"></script>
<script src="<?= $basePath ?>/style/jsbn/prng4.js"></script>
<script src="<?= $basePath ?>/style/jsbn/rng.js"></script>
<script src="<?= $basePath ?>/style/jsbn/rsa.js"></script>
<script src="<?= $basePath ?>/style/bin2hex.js"></script>
<script src="<?= $basePath ?>/style/password.js.php"></script>

<h2 class="separate">Administrator Page</h2>
	<form name="pcrypt" onsubmit="pcryptf()" method="POST" action="index.php" class="uniForm">
	<fieldset>
	<? if(!$user_loggedin) { ?>
	<h3>Log in with the administrator username and password. If you have forgotten your username and/or password, contact your root administrator to reset your password.</h3>
	<div class="ctrlHolder">
	<label>Username</label>
		<input type="text" name="username" />
	</div>
	<? } else { ?>
	<h3>Log in with the administrator password. If you have forgotten your password, contact your root administrator.</h3>
	<? } ?>
	<div class="ctrlHolder">
	<label>Password</label>
		<input type="password" name="password" />
	</div>
	<div class="ctrlHolder">
	<label>Club</label>
		<select name="club" />
		<? foreach($clubs as $club_id => $club_name) { ?>
			<option value="<?= $club_id ?>"><?= $club_name ?></option>
		<? } ?>
		</select>
	</div>
	<div class="buttonHolder">
		<input type="submit" value="Log In" class="login positive primaryAction"/>
	</div>
	</fieldset>
	</form>
</table>
