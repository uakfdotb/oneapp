<h1><a href="root_cat.php?cat=Manage">Manage</a> > Admins</h1>

<p>The admin management tools allows you to add and remove administrators for clubs. The Club ID can be retrieved from the club management page. An email address is not used but can be provided for your own use. Passwords will be hashed and securely stored in the database. You can reset an administrator's password using the update function.</p>

<p>Note that if you delete and then re-add an administrator, the only information that will be deleted is the information on this page plus notes features (the textbox, categories, and comments shown on the <b>View Submissions</b> page in the application administration section.</p>

<form action="man_admins.php?action=add" method="post">
<table style="margin:10px auto" width=60%>
<tr>
	<td width=35%><p class="name">Administrator</p></td>
	<td><input type="text" name="username" list="datalist1" autocomplete="off" class="right"/></td>
	<datalist id="datalist1">
	<? foreach($userList as $user) {
				echo "<option value=\"" . $user[0] . "\">";
	} ?>
	</datalist>
</tr>
<tr>
	<td width=35%><p class="name">Club</p></td>
	<td><select name="group_id" class="right"/>
		<?
			foreach($groupList as $group_id => $group_name) {
				echo "<option value=\"" . $group_id . "\">" . $group_name . "</option>";
			}
		?>
		<option value="0">General Application</option>
	</select></td>
</tr>
<tr>
	<td colspan="2" align="right"><input type="submit" value="Add admin" class="add"></td>
</tr>
</table>
</form>

<table class="tbl_repeat">
<tr>
	<th width:500px align="left">Username</th>
</tr>

<?
foreach($adminList as $item) {
?>
	<tr><td><table width=100%>
	<form method="post" action="man_admins.php">
	<input type="hidden" name="id" value="<?= $item[0] ?>">
	<input type="hidden" name="group_id_orig" value="<?= $item[2] ?>">
		<td><input class="slide" onfocus="OnFocusInput(this)" onblur="OnBlurInput(this)" type="text" name="username" value="<?= $item[1] ?>" style="width:70px" /></td>
		<td><select name="group_id" style="width:190px">
			<option value="<?= $item[2] ?>"><?= $item[3] ?></option>
			<?
				foreach($groupList as $group_id => $group_name) {
					if(substr($group_id, 0, 1) == substr($item[2], 0, 1) && $group_id != $item[2]) {
						echo "<option value=\"" . $group_id . "\">" . $group_name . "</option>";
					}
				}
			?>
		</select>
		</td>
		<td><input type="submit" name="action" value="Update" class="update "></td>
		<td><input type="submit" name="action" value="Remove" class="delete negative right"></td>
		</tr></table></td>
		</tr>
	</form>
<?
}
?>

</table>
