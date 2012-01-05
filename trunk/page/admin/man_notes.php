<form method="post" action="man_notes.php">
<input type="checkbox" name="box_enabled" value="true" <?= $box_enabled ? "checked" : "" ?>/> Textboxes enabled
<br /><input type="checkbox" name="cat_enabled" value="true" <?= $cat_enabled ? "checked" : "" ?>/> Categories enabled
<br /><input type="checkbox" name="comment_enabled" value="true" <?= $comment_enabled ? "checked" : "" ?>/> Comments enabled
<br /><input type="submit" name="notesupdate" value="Update" />
</form>

<table><tr><th>Category name</th><th>Delete</th></tr>

<?
foreach($categories as $category) {
	echo "<tr><td>$category</td>";
	echo "<td><form method=\"post\" action=\"man_notes.php?name=" . urlencode($category) . "\">";
	echo "<input type=\"submit\" name=\"action\" value=\"delete\" />";
	echo "</form></td></tr>";
}
?>

</table>

<form method="POST" action="man_notes.php?action=add">
<input type="text" name="name" />
<input type="submit" value="Add category" />
</form>
