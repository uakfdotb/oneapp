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
		<td><?= date('m/d/y H:i:s', $row['submit_time']) ?></td>
		<? if($row['status'] <= 0) { ?>
			<td><?= $row['amount'] ?></td>
			<td></td>
			<td><button value="<?=$row['id']?>" name="edit">Edit</button></td>
		<? } else { ?>
			<td></td>
			<td><?= $row['amount'] ?></td>
			<td></td>
		<? } ?>
<? } ?>
</table>
</form>
<form action="purchase.php">
<input name="option" value="true" type="hidden"></input>
<button>Create New Order</button>
</form>
