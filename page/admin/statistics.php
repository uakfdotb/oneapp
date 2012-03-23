<h1>Statistics</h1>

<p>You have received <?= $adminStat[0] ?> submissions out of <?= $adminStat[1] ?> total applications and <?= $adminStat[2] ?> total users. Below is a breakdown of responses to questions on your supplement.</p>

<table>
<tr>
	<th>Question name</th>
	<th>Responses</th>
	<th>Percentage</th>
</tr>

<? foreach($responseStat as $item) { ?>
	<tr>
		<td colspan="3"<?= $item[0] ?></td>
	</tr>
	
	<? foreach($item[1] as $response => $count) { ?>
		<tr>
		<td><!-- skip question name --></td>
		<td><?= $response ?> (<?= $count ?>/<?= $adminStat[0] ?>)</td>
		<td>
		<? if($adminStat[0] != 0) { //make sure we don't divide by 0 ?>
			<img src="../include/ratingbox.php?rating=<?= $count * 100 / $adminStat[0] ?>" width=50%>
		<? } ?>
		</td>
	<? } ?>
<? } ?>
</table>
