<h1>Clubs</h1>

<ul>
<?
foreach($clubsApplied as $item) {
	$club_id = $item[0];
	$club_name = $item[1];
	$app_id = $item[3];
	echo "<li><a href=\"clubDetail.php?app_id=$app_id&club_id=$club_id\">";
	echo $club_name;
	echo "</a></li>";
}
?>
</ul>

<form method="GET" action="addClub.php">
<input type="submit" value="Add club application">
</form>
