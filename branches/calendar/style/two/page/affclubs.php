<h1>Affiliated Clubs</h1>

<p>This page lists all of the clubs using our application system. For more details (including application deadlines), click on the club name to go to the club details page. To apply to a club, enter the application system and select the club from the dropdown list.</p>

<?
foreach($clubList as $club) {
	$club_id = $club[0];
	$club_name = $club[1];
	$club_desc = $club[2];
	echo "<p><b><a href=\"affclubs.php?id=$club_id\">$club_name</a></b>: $club_desc</p>";
}
?>
