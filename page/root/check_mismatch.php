<h1>Check for mismatched application answers</h1>

<p>This tool checks for supplement responses where the question associated with the response has been removed, or another question has been added. The system does not automatically update a user's application after the user adds the supplement if the supplement itself is changed. If you simply want to delete one user's application or you are just testing the system, you can completely reset a user's applications through the <b>User List</b>.</p>

<p>Note that a warning is displayed to club administrators that this may occur. Also note that this currently does not work with the general application.</p>

<?
if(isset($mismatches) && $mismatches !== FALSE) {
	foreach($mismatches as $mismatch) {
		echo $mismatch . "<br>";
	}
	
	echo "Total errors: " . count($mismatches);
}
?>

<form method="post" action="check_mismatch.php">
Club ID: <input type="text" name="club_id"><br>
<input type="submit" value="Check tables" />
<input type="submit" name="act" value="Check and fix errors" />
</form>
