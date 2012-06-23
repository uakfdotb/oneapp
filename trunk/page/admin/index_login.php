<script src="<?= $basePath ?>/style/jsbn/jsbn.js"></script>
<script src="<?= $basePath ?>/style/jsbn/prng4.js"></script>
<script src="<?= $basePath ?>/style/jsbn/rng.js"></script>
<script src="<?= $basePath ?>/style/jsbn/rsa.js"></script>
<script src="<?= $basePath ?>/style/password.js.php"></script>

<h1>Administrator Page</h1>

<p>Use the form below to log in to the club administration area.</p>

<form name="pcrypt" onsubmit="pcrypt()" method="POST" action="index.php">
<table>
	<tr>
		<table>
		<?= $t_hidden ?>
			<? if(!$user_loggedin) { ?>
			<tr>
				<td>Username:</td>
				<td><input type="text" name="username"/></td>
			</tr>
			<? } ?>
			<tr>
				<td>Password:</td>
				<td><input type="password" name="password"/></td>
			</tr>
			<tr>
				<td>Club:</td>
				<td><select name="club">
				<? foreach($clubs as $club_id => $club_name) { ?>
					<option value="<?= $club_id ?>"><?= $club_name ?></option>
				<? } ?>
				</select></td>
			</tr>
			<tr>
				<td colspan="2"><input type="submit" value="Submit" align="center"/></td>
			</tr>
		</table>
	</tr>

	<?
	if(isset($message) && $message != "") {
	?>
		<tr><td colspan="2"><?= $message ?></td></tr>
	<?
	}
	?>
</table>
</form>
