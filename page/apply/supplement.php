<h1>Clubs</h1>

<p>Select a supplement below to work on. To submit your application to a club, go to the clubs page, select the club, and press submit.</p>

<ul>
<?
foreach($clubsApplied as $item) {
	$club_id = $item[0];
	$club_name = $item[1];
	echo "<li><a href=\"app.php?club_id=$club_id&action=view\">";
	echo $club_name;
	echo "</a></li>";
}
?>
</ul>
