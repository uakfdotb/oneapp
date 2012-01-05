<h1>Club manager</h1>

<p>This manager allows you to add, remove, and edit clubs. If you delete a club that has a supplement, the supplement will no longer be accessible (and you can delete these residual questions through the <b>Delete questions without a home</b> tool). Also, you will need to create one or more admins for a club before the club information can be edited.</p>

<?
if(isset($message) && $message != '') {
	echo "<p>$message</p>";
}
?>

<form action="man_clubs.php?action=add_club" method="post">
<table class="borderon">
<tr><td align="right"><p>Club name</p></td><td><input type="text" name="name" style="width:100%"></td></tr>
<tr><td align="right"><p>Description</p></td><td><textarea name="description" style="width:100%;resize:none"></textarea></td></tr>
<tr><td colspan="2" align="right"><input type="submit" value="Add club"></td></tr>
</table>
</form>
<br><br>
<?
while($row = mysql_fetch_array($clubsResult)) {
?>
	<form method="post" action="man_clubs.php">
	<input type="hidden" name="id" value="<? $row['id'] ?>">
	<tr align="center"><td><p><?= $row['id'] ?></p></td>
	<td><p><?= $row['name'] ?></p></td>
	<td><textarea name="description" style="width:100%;resize:none"><?= $row['description'] ?></textarea></td>
	
	<td><input type="submit" name="action" value="update"></td>
	<td><input type="submit" name="action" value="delete"></td>
	</tr></form>
<?
}
?>
</table>
