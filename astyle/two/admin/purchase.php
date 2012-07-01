<h1>Club Money</h1>

<p>Current Balance: $<?= $balance ?></p>

<table class="tbl_repeat">
	<tr>
		<th>Description</th>
		<th>Date</th>
		<th>Pending</th>
		<th>Authorized</th>
	</tr>
<? while($row = mysql_fetch_array($purchaseHistory)) { ?>
	<tr>
		<td><?= $row['description']?></td>
		<td><?= date('m/d/y H:i:s', $open_time) ?></td>
		<? if($row['status'] == -1) { ?>
			<td><?= $row['amount'] ?></td>
			<td></td>
		<? } else { ?>
			<td></td>
			<td><?= $row['amount'] ?></td>
		<? } ?>
<? } ?>
</table>
