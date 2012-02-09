<h1>Check for mismatched application answers</h1>

<p>This tool checks for supplement responses where the question associated with the response has been removed, or another question has been added. The system does not automatically update a user's application after the user adds the supplement if the supplement itself is changed. If you simply want to delete one user's application or you are just testing the system, you can completely reset a user's applications through the <a href="userlist.php">User List</a>.</p>

<p>Note that a warning is displayed to club administrators that this may occur. Also note that this currently does not work with the general application.</p>

<?
if(isset($mismatches) && $mismatches !== FALSE) {
	echo "<ul>";
	foreach($mismatches as $mismatch) {
		echo $mismatch . "<br>";
	}
	echo "</ul>";
	echo "<p><b>Total errors: " . count($mismatches) . "</b></p>";
}
?>

<form method="post" action="check_mismatch.php">
<table><tr><td><p>
Club ID</p><td><select name="club_id">
<?
	while($row = mysql_fetch_row($clubInfo)){
		echo "<option value=\"" . $row[0] . "\" />" . $row[1] . "</option>";
	}
?>
</select></td></tr>
<tr><td><input type="submit" value="Check tables" /></td><td>
<input type="submit" name="act" value="Check and fix errors" />
</td></tr></table>
</form>
