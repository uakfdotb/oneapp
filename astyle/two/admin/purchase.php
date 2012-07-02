<h1>Club Money</h1>

<p>Current Balance: $<?= $balance ?></p>

<form action="purchase.php">
<table class="tbl_repeat">
	<tr>
		<th>Description</th>
		<th>Date</th>
		<th>Pending</th>
		<th>Authorized</th>
		<th></th>
	</tr>
<? while($row = mysql_fetch_array($purchaseHistory)) { ?>
	<tr>
		<td><?= $row['description']?></td>
		<td><? $time = max($row['submit_time'], $row['status_time']); echo date('m/d/y H:i:s', $time); ?></td>
		<? if($row['status'] != -1) { ?>
			<td><?= $row['amount'] ?></td>
			<td></td>
			<? if($row['status'] == 0) { ?>
			<td><button value="<?=$row['id']?>" name="edit">Edit</button></td>
			<? } else { ?>
			<td><?=getPurchaseStatusString($row['status'])?><br /><a href="../submit/<?= $row['filename']?>.pdf">Download</a></td>
			<? } 
		} else { ?>
			<td></td>
			<td><?= $row['amount'] ?></td>
			<td><?=getPurchaseStatusString($row['status'])?><br /><a href="../submit/<?= $row['filename']?>.pdf">Download</a></td>
		<? } ?>
<? } ?>
</table>

<br />
</form>

<table style="width:40%">
<form action="purchase.php">
<input name="option" value="true" type="hidden"></input>
<tr>
	<td colspan="2"><p>Short Description</p></td>
</tr><tr>
	<td colspan="2"><textarea name="description" style="width:100%"></textarea></td>
</tr><tr>
	<td><p>Amount</p></td><td>$<input name="amount" style="width:90%"></input></td>
</tr><tr>
	<td colspan="2">
		<input type="radio" name="transfer_type" value="-1" checked>Withdrawl</input>
	</td>
</tr><tr>
	<td colspan="2"><button>Create New Order</button></td>
</tr>
</form>
</table>
