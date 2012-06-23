<h1>Clubs</h1>

<p>You can add a club and view the list of clubs you have added below. The open time and close time identifies the interval during which you may submit your application to the club.</p>

<form method="GET" action="addClub.php">
<input type="submit" value="Add club">
</form>

<br />

<table width=100% class="borderon">
<tr>
       <th align="left"><p class="admin_table_header">Club Name</p></th>
       <th><p class="admin_table_header">Subscribed?</p></th>
       <th><p class="admin_table_header">Application status</p></th>
       <th><p class="admin_table_header">Open time</p></th>
       <th><p class="admin_table_header">Close time</p></th>
       <th><p class="admin_table_header">Submit</p></th>
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
	
	echo "<tr align=\"center\">";
	echo "<td width=25% align=\"left\"><p>";
	echo "<a href=\"clubDetail.php?app_id=$app_id&club_id=$club_id\">";
	echo $club_name . "</p></a></td>";
	echo "<td width=15%>$subscribedString</td>";
	echo "<td width=15%>$stateString</td>";
	echo "<td width=15%>$start/td>";
	echo "<td width=15%>$close</td>";
	echo "<td width=15%><p>";
	if($state == 0) {
		echo "<a href=\"submit.php?app_id=$app_id&club_id=$club_id\">Submit</a>";
	} else {
		echo "<font color=\"red\">Not Available</font>";
	}
	echo "</p></td></tr>";
}
?>

</table>
