<h1>Admin management</h1>

<p>The admin management tools allows you to add and remove administrators for clubs. The Club ID can be retrieved from the club management page. An email address is not used but can be provided for your own use. Passwords will be hashed and securely stored in the database. You can reset an administrator's password using the update function.</p>

<p>Note that if you delete and then re-add an administrator, the only information that will be deleted is the information on this page plus notes features (the textbox, categories, and comments shown on the <b>View Submissions</b> page in the application administration section.</p>

<form action="man_admins.php?action=add" method="post">
<table style="margin:10px auto" width=60%>
<tr>
	<td width=35%><p class="name">Administrator</p></td>
	<td><input type="text" name="username" list="datalist1" autocomplete="off" style="width:85%" class="right"/></td>
	<datalist id="datalist1">
	<? foreach($userList as $user) {
				echo "<option value=\"" . $user[0] . "\">";
	} ?>
	</datalist>
</tr>
<tr>
	<td width=35%><p class="name">Club</p></td>
	<td><select name="group_id" style="width:87%" class="right"/>
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
	<th align="left">Username</th>
	<th align="left">Group</th>
	<th width=10%></th>
	<th width=10%></th>
</tr>

<?
foreach($adminList as $item) {
?>
	<form method="post" action="man_admins.php">
	<input type="hidden" name="id" value="<?= $item[0] ?>">
	<input type="hidden" name="group_id_orig" value="<?= $item[2] ?>">
	<tr>
		<td><input class="slide" onfocus="OnFocusInput (this)" onblur="OnBlurInput (this)" type="text" name="username" value="<?= $item[1] ?>"></td>
		<td><select name="group_id" style="width:100%">
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
		<td><input type="submit" name="action" value="Update" class="update right"></td>
		<td><input type="submit" name="action" value="Remove" class="delete negative right"></td>
		</tr>
		</tr>
	</form>
<?
}
?>

</table>
