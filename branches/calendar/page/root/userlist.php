<h1>User List</h1>

<p>Here, all registered users are listed. Note that this includes users who have registered but not logged in yet (highlighted). <b>Reset apps</b> will delete all applications and responses of the user from the database, including on the general application. <b>Delete user</b> will delete the user completely (but will not delete applications and responses).</p>

<table>
<tr>
	<th>ID</th>
	<th>Name</th>
	<th>Username</th>
	<th>Email</th>
	<th>Last active</th>
	<th>Reset apps</th>
	<th>Delete user</th>
</tr>

<?
foreach($userList as $user_id => $user) {
	$infoUser = $user[1]; //array of (username, email)
?>
	
	<form method="post" action="userlist.php">
	<input type="hidden" name="id" value="<?= $user_id ?>">
	<tr>
		<td><a href="user_detail.php?id=<?= $user_id ?>"><?= $user_id ?></a></td>
		<td><a href="user_detail.php?id=<?= $user_id ?>"><?= $infoUser[2] ?></a></td>
		<td><?= $infoUser[0] ?></td></a>
		<td><?= $infoUser[1] ?></td>
		<td><?= timeString($user[0]) ?></td>
		<td><input type="submit" name="action" value="reset"></td>
		<td><input type="submit" name="action" value="delete!!"></td>
	</tr>
	</form>
<? } ?>

</table>
