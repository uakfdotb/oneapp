<h1>Statistics</h1>

<p>You have received <?= $adminStat[0] ?> submissions out of <?= $adminStat[1] ?> total applications and <?= $adminStat[2] ?> total users. Below is a breakdown of responses to questions on your supplement.</p>

<table width=100%>
<tr>
	<th width=30%><p class="admin_table_header" align="left">Question name</p></th>
	<th width=30%><p class="admin_table_header" align="left">Responses</p></th>
	<th width=40%><p class="admin_table_header" align="left">Percentage</p></th>
</tr>

<? foreach($responseStat as $item) { ?>
	<tr>
	<td colspan="3" class="top_border"><p><?= $item[0] ?></p></td>
	</tr>
	
	<? foreach($item[1] as $response => $count) { ?>
		<tr>
		<td><!-- skip question name --></td>
		<td><p><?= $response ?> (<?= $count ?>/<?= $adminStat[0] ?>)</p></td>
		<td>
		<? if($adminStat[0] != 0) { //make sure we don't divide by 0 ?>
			<img src="../include/ratingbox.php?rating=<?= $count * 100 / $adminStat[0] ?>" width=50%>
		<? } ?>
		</td>
	<? } ?>
<? } ?>
</table>
