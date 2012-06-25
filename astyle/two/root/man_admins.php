<h1>Admin management</h1>

<p>The admin management tools allows you to add and remove administrators for clubs. The Club ID can be retrieved from the club management page. An email address is not used but can be provided for your own use. Passwords will be hashed and securely stored in the database. You can reset an administrator's password using the update function.</p>

<p>Note that if you delete and then re-add an administrator, the only information that will be deleted is the information on this page plus notes features (the textbox, categories, and comments shown on the <b>View Submissions</b> page in the application administration section.</p>

<form action="man_admins.php?action=add" method="post">
<table style="margin:10px auto">
<tr>
	<td style="padding-right:10px">Admin username</td>
	<td><input type="text" name="username"></td>
</tr>
<tr>
	<td>Club</td>
	<td><select name="club_id">
		<?
			foreach($clubsList as $club_id => $club_name) {
				echo "<option value=\"" . $club_id . "\">" . $club_name . "</option>";
			}
		?>
		<option value="0">General Application</option>
	</select></td>
</tr>
<tr>
	<td colspan="2" align="center"><input type="submit" value="Add admin" class="add"></td>
</tr>
</table>
</form>


<script type="text/javascript">
    function OnFocusInput (input) {
        input.style.width="120px";
        input.style.backgroundColor="white";
    }

    function OnBlurInput (input) {
        input.style.width="50px";
        input.style.backgroundColor="#DCDCDC";
    }
</script>


<table class="tbl_repeat">
<tr>
	<th align="left">Username</th>
	<th>Club</th>
	<th></th>
	<th></th>
</tr>

<?
foreach($adminList as $item) {
?>
	<form method="post" action="man_admins.php">
	<input type="hidden" name="id" value="<?= $item[0] ?>">
	<input type="hidden" name="club_id_orig" value="<?= $item[1] ?>">
	<tr>
		<td><input class="slide" onfocus="OnFocusInput (this)" onblur="OnBlurInput (this)" type="text" name="username" value="<?= $item[2] ?>"></td>
		<td><select name="club_id">
			<option value="<?= $item[1] ?>">
			<?
				if ($item[1] == 0) {
				   echo "General Application";
				} else {
					echo $clubsList[$item[1]];
				}
			?>
			</option>
			
			<?
				foreach($clubsList as $club_id => $club_name) {
					echo "<option value=\"" . $club_id . "\">" . $club_name . "</option>";
				}

				echo "<option value=\"0\">General Application</option>";
			?>
		</select>
		</td>
		<td><input type="submit" name="action" value="Update" class="update"></td>
		<td><input type="submit" name="action" value="Remove" class="delete negative"></td>
		</tr>
		</tr>
	</form>
<?
}
?>

</table>