<h1>Check for mismatched application answers</h1>

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
