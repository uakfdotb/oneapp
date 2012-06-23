<h1>Clubs</h1>

<p>You can add a club and view the list of clubs you have added below. The open time and close time identifies the interval during which you may submit your application to the club.</p>

<form method="GET" action="addClub.php">
<input type="submit" value="Add club">
</form>

<br />

<table>
<tr>
       <th>Club Name</th>
       <th>Subscribed?</th>
       <th>Application status</th>
       <th>Open time</th>
       <th>Close time</th>
       <th>Submit</th>
</tr>

<?
foreach($clubs as $club_id => $club) {
	$club_name = $club[3][0];
	$app_id = $club[2][3];
	
	$start = $club[3][2];
	$close = $club[3][3];
	$state = $club[1];
	
	$stateString = "Not applying";
	if($state == 0) $stateString = "<font color=\"blue\">Started</font>";
	else if($state == -1) $stateString = "<font color=\"green\">Submitted</font>";
	else if($state == -3) $stateString = "<font color=\"red\">Late</font>";
	
	$subscribedString = $club[0] ? "Subscribed" : "Not subscribed";
	
	echo "<tr>";
	
	echo "<td>";
	echo "<a href=\"clubDetail.php?app_id=$app_id&club_id=$club_id\">";
	echo $club_name . "</a></td>";
	
	echo "<td>$subscribedString</td>";
	echo "<td>$stateString</td>";
	echo "<td>$start/td>";
	echo "<td>$close</td>";
	
	echo "<td>";
	if($state == 0) {
		echo "<a href=\"submit.php?app_id=$app_id&club_id=$club_id\">Submit</a>";
	} else {
		echo "<font color=\"red\">Not Available</font>";
	}
	echo "</td></tr>";
}
?>

</table>
