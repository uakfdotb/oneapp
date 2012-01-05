<h1>User List</h1>

<p>Here, all registered users are listed. Note that this includes users who have registered but not logged in yet (highlighted). <b>Reset apps</b> will delete all applications and responses of the user from the database, including on the general application. <b>Delete user</b> will delete the user completely (but will not delete applications and responses).</p>

<table width=100% class="borderon">
<tr>
	<th><p class="admin_table_header">ID</p></th>
	<th><p class="admin_table_header">Username</p></th>
	<th><p class="admin_table_header">Email</p></th>

<? foreach($profileHeader as $item) { ?>
	<th><p class="admin_table_header"><?= $item[0] ?></p></th>
<? } ?>

	<th><p class="admin_table_header">Reset apps</p></th>
	<th><p class="admin_table_header">Delete user</p></th>
</tr>

<?
foreach($userList as $user_id => $user) {
	$infoUser = $user[0]; //array of (username, email)
	$profileUser = $user[1]; //contains profile fields
?>
	
	<form method="post" action="userlist.php">
	<input type="hidden" name="id" value="<?= $user_id ?>"><tr align="center">
	<td><p><?= $user_id ?></p></td>
	<td><p><?= $infoUser[0] ?></p></td>
	<td><p><?= $infoUser[1] ?></p></td>
	
	<? foreach($profileUser as $item) { ?>
		<td><p><?= $item[1] ?></p></td>
	<? } ?>
	
	<td><input type="submit" name="action" value="reset"></td>
	<td><input type="submit" name="action" value="delete!!"></td>
	</form></tr>
<? } ?>

</table>
