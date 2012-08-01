<h1><a href="root_cat.php?cat=Statistics">Statistics</a> > Club</h1>

<p>Below are the number of users who submitted an application and who applied for each club. If you select details, then you will be able to see specific users who applied to the club.</p>

<table class="tbl_repeat">
<tr>
	<th align="left">Club</th>
	<th># submitted / # applied</th>
	<th></th>
	<th></th>
</tr>

<?
foreach($stat_array as $club_id => $clubTuple) { //club tuple is (club name, # submitted, # applied)
?>
	<tr>
	<td><?= $clubTuple[0] ?></td>
	<td align="center"><?= $clubTuple[1] ?> / <?= $clubTuple[2] ?></td>
	<td>
		<img src="../include/ratingbox.php?rating=<?= $clubTuple[1] * 100 / ($clubTuple[2] == 0 ? 1 : $clubTuple[2]) ?>" width=50%>
	</td>
	<td><a href="statistics_club.php?club_id=<?= $club_id ?>&club_name=<?= $clubTuple[0] ?>">Details</a></td>
	</tr>
<? } ?>

</table>
