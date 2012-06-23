<h1>Add Club</h1>

<?
if(isset($error)) {
	echo "<p>" . $error . "</p>";
}
?>

<form action="addClub.php" method="POST">
Select a club: <select name="club">
<?
foreach($clubs as $club) {
	$club_id = $club[0];
	$club_name = $club[1];
	echo "<option value=\"$club_id\">$club_name</option>";
}
?>
</select>
<br><button type="submit" name="mode" value="subscribe">Subscribe</button>
<button type="submit" name="mode" value="apply">Apply</button>
</form>
