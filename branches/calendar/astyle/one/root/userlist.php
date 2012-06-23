<h1>User List</h1>

<p>Here, all registered users are listed. Note that this includes users who have registered but not logged in yet (highlighted). <b>Reset apps</b> will delete all applications and responses of the user from the database, including on the general application. <b>Delete user</b> will delete the user completely (but will not delete applications and responses).</p>

<table width=100% cellspacing="0">
<tr>
	<th><p class="admin_table_header">ID</p></th>
	<th><p class="admin_table_header">Name</p></th>
	<th><p class="admin_table_header">Username</p></th>
	<th><p class="admin_table_header">Email</p></th>
	<th><p class="admin_table_header">Last active</p></th>
	<th><p class="admin_table_header">Reset apps</p></th>
	<th><p class="admin_table_header">Delete user</p></th>
</tr>

<?
foreach($userList as $user_id => $user) {
	$infoUser = $user[1]; //array of (username, email)
	
	$banding = "";
	if($user[0] == 0) $banding = " class=\"bandwarning\"";
?>
	
	<form method="post" action="userlist.php">
	<input type="hidden" name="id" value="<?= $user_id ?>"><tr align="center"<?= $banding ?> style="padding-top:1"><a href="user_detail.php?id=<?= $user_id ?>">
	<td class="top_border"><p><a href="user_detail.php?id=<?= $user_id ?>"><?= $user_id ?></a></p></td>
	<td class="top_border"><p><a href="user_detail.php?id=<?= $user_id ?>"><?= $infoUser[2] ?></a></p></td></a>
	<td class="top_border"><p><?= $infoUser[0] ?></p></td></a>
	<td class="top_border"><p><?= $infoUser[1] ?></p></td>
	<td class="top_border"><p><?= timeString($user[0]) ?></p></td>
	<td class="top_border"><input type="submit" name="action" value="reset"></td>
	<td class="top_border"><input type="submit" name="action" value="delete!!"></td>
	</tr></form>
<? } ?>

</table>
