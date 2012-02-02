<h1>Clubs</h1>

<form method="GET" action="addClub.php">
<input type="submit" value="Add club application">
</form>

<table width=80%>
<tr>
       <th align="left"><p class="admin_table_header">Club Name</p></th>
       <th><p class="admin_table_header">Status</p></th>
       <th><p class="admin_table_header">App Open</p></th>
       <th><p class="admin_table_header">App Close</p></th>
       <th><p class="admin_table_header">Submit</p></th>
</tr>
<?
foreach($clubsApplied as $item) {
	$club_id = $item[0];
	$club_name = $item[1];
	$app_id = $item[3];
	echo "<tr align=\"center\"><td width=40% align=\"left\"><p><a href=\"clubDetail.php?app_id=$app_id&club_id=$club_id\">";
	echo $club_name . "</p></a></td><td width=20%><p>" . $clubStates[$club_id] . "</p></td><td width=20%><p>" . $clubStart[$item[0]] . "</p></td><td width=20%><p>" . $clubDue[$item[0]] . "</p></td><td width=20%><p><a href=\"submit.php?app_id=" . $item[3] . "&club_id=" . $item[0] . "\">SUBMIT</a></p>";
	echo "</td></tr>";
}
?>
</table>