<h1>Clubs</h1>

<p>You can add a club and view the list of clubs you have added below. The open time and close time identifies the interval during which you may submit your application to the club.</p>

<form method="GET" action="addClub.php">
<input type="submit" value="Add club application">
</form>

<br />

<table width=100% class="borderon">
<tr>
       <th align="left"><p class="admin_table_header">Club Name</p></th>
       <th><p class="admin_table_header">Status</p></th>
       <th><p class="admin_table_header">Open time</p></th>
       <th><p class="admin_table_header">Close time</p></th>
       <th><p class="admin_table_header">Submit</p></th>
</tr>

<?
foreach($clubsApplied as $item) {
	$club_id = $item[0];
	$club_name = $item[1];
	$app_id = $item[3];
	
	echo "<tr align=\"center\">";
	echo "<td width=40% align=\"left\"><p>";
	echo "<a href=\"clubDetail.php?app_id=$app_id&club_id=$club_id\">";
	echo $club_name . "</p></a></td>";
	echo "<td width=20%><p>" . $clubStates[$club_id] . "</p></td>";
	echo "<td width=20%><p>" . $clubStart[$club_id] . "</p></td>";
	echo "<td width=20%><p>" . $clubClose[$club_id] . "</p></td>";
	echo "<td width=20%><p><a href=\"submit.php?app_id=" . $item[3] . "&club_id=" . $item[0] . "\">Submit</a></p></td>";
	echo "</tr>";
}
?>

</table>
