<h1>Funding manager</h1>
<div id="tabs">
	<ul>
		<li><a href="#tabs-1">Pending</a></li>
		<li><a href="#tabs-2">Complete</a></li>
		<li><a href="#tabs-3">Necessary Approval List</a></li>
	</ul>
<div id="tabs-1">
<? if(mysql_num_rows($pending) == 0) {
	echo "<p>No purchase orders pending!</p>";
} else { 
	echo count($pending);?>
	<form action="man_funds.php">
	<table class="tbl_repeat">
	<tr>
		<th>Club Name</th>
		<th>Submit Time</th>
		<th>Current Status</th>
		<th>Amount</th>
		<th></th>
		<th></th>
		<th></th>
	</tr>

	<? while($row = mysql_fetch_array($pending)) { ?>
		<tr>
			<td><? $club_detail = clubInfo($row['club_id']); echo $club_detail[0]; ?></td>
			<td><?= date('m/d/y H:i', $row['submit_time'])?></td>
			<td>Awaiting: <?= getPurchaseStatusString($row['status'])?></td>
			<td><?= $row['amount']?></td>
			<td><a href="../submit/<?= $row['filename']?>.pdf">Download</a></td>
			<td><button name="status_change" value="<?=$row['id']?>">Approve</button></td>
			<td><button name="status_change" value="<?=-1*$row['id']?>">Reject</button></td>
		</tr>
	<? } ?>
	</table>
	</form>
<? } ?>
</div>
<div id="tabs-2">
	<table class="tbl_repeat">
	<tr>
		<th>Club Name</th>
		<th>Submit Time</th>
		<th>Finalized Time</th>
		<th>Status</th>
		<th>Amount</th>
	</tr>
	<? while($row = mysql_fetch_array($completed)) { ?>
		<tr>
			<td><? $club_detail = clubInfo($row['club_id']); echo $club_detail[0]; ?></td>
			<td><?= date('m/d/y H:i', $row['submit_time']) ?></td>
			<td><? if($row['status'] <= -1) echo date('m/d/y H:i:s', $row['status_time']); ?></td>
			<td><?= getPurchaseStatusString($row['status'])?></td>
			<td><?= $row['amount']?></td>
		</tr>
	<? } ?>
	</table>
</div>
<div id="tabs-3">
	<form action="man_funds.php?action=add" method="post">
	<table>
	<tr>
		<td><p class="name">Root Name</p></td>
		<td><input type="text" name="name" list="datalist1" autocomplete="off" /></td>
		<datalist id="datalist1">
		<? foreach($userList as $user) {
					echo "<option value=\"" . $user[0] . "\">";
		} ?>
		</datalist>
	</tr><tr>
		<td colspan="2"><input type="submit" value="Add order" class="add right"></td>
	</tr>
	</table>
	</form>

	<table class="tbl_repeat">
	<tr>
		<th align="left">Order</th>
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
</div>
</div>
