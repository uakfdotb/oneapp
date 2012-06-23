<h1>Notes feature selector</h1>

<p>Below, you can select what features to enable in your <b>View Submissions</b> tool. The category list is only used if categories are enabled, and allows you to group applications. The textbox feature is quite versatile (and recommended over categories) and allows to to enter information in a textbox, and then search through it.</p>

<form method="post" action="man_notes.php">
<?= $t_hidden ?>
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
	echo $t_hidden;
	echo "<input type=\"submit\" name=\"action\" value=\"delete\" />";
	echo "</form></td></tr>";
}
?>

</table>

<form method="POST" action="man_notes.php?action=add">
<?= $t_hidden ?>
<input type="text" name="name" />
<input type="submit" value="Add category" />
</form>
