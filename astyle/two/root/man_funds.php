<h1>Funding manager</h1>
<h2>Purchase Orders</h2>
<h3>Pending</h3>
<table class="tbl_repeat">
<tr>
	<th>Club Name</th>
	<th>Submit Time</th>
	<th>Current Status</th>
	<th>Amount</th>
	<th>Details</th>
</tr>

<? while($row = mysql_fetch_array($pending)) { ?>
	<tr>
		<td><? $club_detail = clubInfo($row['club_id']); echo $club_detail[0]; ?></td>
		<td><?= $row['submit_time']?></td>
		<td><?= $row['status']?></td>
		<td><?= $row['amount']?></td>
		<td>Details</td>
	</tr>
<? } ?>
</table>
<br />
<h3>Completed</h3>
<table class="tbl_repeat">
<tr>
	<th>Club Name</th>
	<th>Submit Time</th>
	<th>Finalized Time</th>
	<th>Status</th>
	<th>Amount</th>
	<th>Details</th>
</tr>
<? while($row = mysql_fetch_array($completed)) { ?>
	<tr>
		<td><? $club_detail = clubInfo($row['club_id']); echo $club_detail[0]; ?></td>
		<td><?= $row['submit_time']?></td>
		<td><?= $row['status_time']?></td>
		<td><?= $row['status']?></td>
		<td><?= $row['amount']?></td>
		<td>Details</td>
	</tr>
<? } ?>
</table>

<form action="man_funds.php?action=add" method="post">
<table>
<tr>
	<td colspan="2"><p class="name">Increase Order</p></td>
</tr><tr>
	<td><input type="text" name="name"></td>
	<td><input type="submit" value="Add order" class="add"></td>
</tr>
</table>
</form>

<table class="tbl_repeat">
<tr>
	<th align="left">Category</th>
	<th></th>
	<th></th>
	<th></th>
	<th></th>
</tr>

<?
foreach($purchaseList as $item) {
?>
	<form method="post" action="man_funds.php">
	<input type="hidden" name="id" value="<?= $item[0] ?>">
	<tr align="center"><td><input type="text" name="name" value="<?= $item[1] ?>" style="width:100%"></td>
	<td><input type="submit" name="action" value="Update" class="update" /></td>
	<td><input type="submit" name="action" value="Delete" class="delete negative" /></td>
	<td><input type="submit" name="action" value="up" class="up" /></td>
	<td><input type="submit" name="action" value="down" class="down" /></td>
	</tr></form>
<?
}
?>

</table>
