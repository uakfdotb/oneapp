<h1>Club manager</h1>

<p>This manager allows you to add, remove, and edit clubs. If you delete a club that has a supplement, the supplement will no longer be accessible (and you can delete these residual questions through the <a href="check_nohome">Delete questions without a home</a> tool). Also, you will need to create one or more admins for a club before the club information can be edited.</p>

<?
if(isset($message) && $message != '') {
	echo "<p>$message</p>";
}
?>

<form action="man_clubs.php?action=add_club" method="post">
<table>
<tr>
	<td>Club name</td>
	<td><input type="text" name="name"></td>
</tr>
<tr>
	<td>Description</td>
	<td><textarea name="description"></textarea></td>
</tr>
<tr>
	<td colspan="2"><input type="submit" value="Add club"></td>
</tr>
</table>
</form>

<? while($row = mysql_fetch_array($clubsResult)) { ?>
	<tr>
	<table>
		<form method="post" action="man_clubs.php">
		<input type="hidden" name="id" value="<?= $row['id'] ?>">
		<tr>
			<td>Club ID:</td>
			<td><?= $row['id'] ?></td></tr>
		<tr>
			<td>Club Name:</td>
			<td><?= $row['name'] ?></td>
		</tr>
		<tr>
			<td colspan="2">Description:<textarea name="description" rows="7" cols="20"><?= $row['description'] ?></textarea></td>
		</tr>
		<tr>
			<td></td>
			<td><input type="submit" name="action" value="update"><input type="submit" name="action" value="delete"></td>
		</tr>
		</form>
	</table>
	</tr>
<? } ?>
</table>
