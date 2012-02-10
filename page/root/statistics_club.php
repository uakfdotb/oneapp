<h1>Club Statistics</h1>

<p>Below are the number of users who submitted an application and who applied for each club. If you select details, then you will be able to see specific users who applied to the club.</p>

<table width=100%>
<tr>
	<th><p class="admin_table_header">Club</p></th>
	<th><p class="admin_table_header"># submitted / # applied</p></th>
	<th><p class="admin_table_header">Graph</p></th>
	<th><p class="admin_table_header">Details</p></th>
</tr>

<?
foreach($stat_array as $club_id => $clubTuple) { //club tuple is (club name, # submitted, # applied)
?>
	<tr>
	<td><p class="admin_table_entry"><?= $clubTuple[0] ?></p></td>
	<td align="center"><p class="admin_table_entry"><?= $clubTuple[1] ?> / <?= $clubTuple[2] ?></p></td>
	<td>
		<img src="../include/ratingbox.php?rating=<?= $clubTuple[1] * 100 / ($clubTuple[2] == 0 ? 1 : $clubTuple[2]) ?>" width=50%>
	</td>
	<td><p class="admin_table_entry"><a href="statistics_club.php?club_id=<?= $club_id ?>&club_name=<?= $clubTuple[0] ?>">Details</a></p></td>
	</tr>
<? } ?>

</table>
