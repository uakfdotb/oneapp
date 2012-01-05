<h1>Category manager</h1>

<p>Here, you can manage the categories for the general application. Note that if you delete a category, the questions in the category will no longer be accessible even if you add another category with the same name (this is because categories are identified by their ID). If you wish to update the name of the category and already have questions in the category, use the update feature (do NOT delete and then re-add with another name).</p>

<?
if(isset($message) && $message != '') {
	echo "<p>$message</p>";
}
?>

<form action="man_cat.php?action=add" method="post"><p>
Category name <input type="text" name="name">
<input type="submit" value="Add category">
</p></form>
<br><br>
		
<table width=100% cellspacing=0 class="borderon">
<tr>
	<th><p class="admin_table_header">Category name</p></th>
	<th><p class="admin_table_header">Update</p></th>
	<th><p class="admin_table_header">Delete</p></th>
	<th><p class="admin_table_header">Up</p></th>
	<th><p class="admin_table_header">Down</p></th>
</tr>

<?
foreach($catList as $item) {
?>
	<form method="post" action="man_cat.php">
	<input type="hidden" name="id" value="<?= $item[0] ?>">
	<tr align="center"><td><input type="text" name="name" value="<?= $item[1] ?>" style="width:100%"></td>
	<td><input type="submit" name="action" value="update"></td>
	<td><input type="submit" name="action" value="delete"></td>
	<td><input type="submit" name="action" value="up"></td>
	<td><input type="submit" name="action" value="down"></td>
	</tr></form>
<?
}
?>

</table>
