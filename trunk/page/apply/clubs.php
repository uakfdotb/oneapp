<h1>Clubs</h1>

<p>You can add a club and view the list of clubs you have added below. The open time and close time identifies the interval during which you may submit your application to the club.</p>

<form method="GET" action="addClub.php">
<input type="submit" value="Add club application">
</form>

<br />

<table>
<tr>
       <th>Club Name</th>
       <th>Status</th>
       <th>Open time</th>
       <th>Close time</th>
       <th>Submit</th>
</tr>

<?
foreach($clubsApplied as $item) {
	$club_id = $item[0];
	$club_name = $item[1];
	$app_id = $item[3];
	
	echo "<tr>";
	
	echo "<td>";
	echo "<a href=\"clubDetail.php?app_id=$app_id&club_id=$club_id\">";
	echo $club_name . "</a></td>";
	
	echo "<td>" . $clubStates[$club_id] . "</td>";
	echo "<td>" . $clubStart[$club_id] . "</td>";
	echo "<td>" . $clubClose[$club_id] . "</td>";
	echo "<td>";
	if($clubStates[$club_id] == "<font color=\"blue\">Started</font>") {
		echo "<a href=\"submit.php?app_id=" . $item[3] . "&club_id=" . $item[0] . "\">Submit</a>";
	} else {
		echo "<font color=\"red\">Not Available</font>";
	}
	echo "</td></tr>";
}
?>

</table>
