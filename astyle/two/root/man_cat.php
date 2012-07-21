<h1>Category manager</h1>

<p>Here, you can manage the categories for the general application. Note that if you delete a category, the questions in the category will no longer be accessible even if you add another category with the same name (this is because categories are identified by their ID). If you wish to update the name of the category and already have questions in the category, use the update feature (do NOT delete and then re-add with another name).</p>

<?
if(isset($message) && $message != '') {
	echo "<p>$message</p>";
}
?>

<form action="man_cat.php?action=add" method="post">
<table width=60% class="center">
<tr>
	<td width=30%><p class="name">Category Title</p></td>
	<td><input type="text" name="name" class="right"></td>
</tr><tr>
	<td colspan="2"><input type="submit" value="Add category" class="add right"></td>
</tr>
</table>
</form>
		
<br /><br />
		
<table class="tbl_repeat">
<tr>
	<th align="left">Category</th>
	<th></th>
	<th></th>
	<th></th>
	<th></th>
</tr>

<?
foreach($catList as $item) {
?>
	<form method="post" action="man_cat.php">
	<input type="hidden" name="id" value="<?= $item[0] ?>">
	<tr align="center"><td><input type="text" name="name" value="<?= $item[1] ?>" style="width:100%"></td>
	<td><input type="submit" name="action" value="Update" class="update" /></td>
	<td><input type="submit" name="action" value="Delete" class="delete negative" /></td>
	<td><input type="submit" name="action" value="up" class="up" /></td>
	<td><input type="submit" name="action" value="down" class="down" /></td>
	</tr></form>
<?
}
?>

</table>
