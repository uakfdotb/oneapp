<h2 class="demoHeaders">Tabs</h2>
		<div id="tabs">
			<ul>
				<li><a href="#tabs-1">First</a></li>
				<li><a href="#tabs-2">Second</a></li>
				<li><a href="#tabs-3">Third</a></li>
			</ul>
			<div id="tabs-1">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</div>
			<div id="tabs-2">Phasellus mattis tincidunt nibh. Cras orci urna, blandit id, pretium vel, aliquet ornare, felis. Maecenas scelerisque sem non nisl. Fusce sed lorem in enim dictum bibendum.</div>
			<div id="tabs-3">Nam dui erat, auctor a, dignissim quis, sollicitudin eu, felis. Pellentesque nisi urna, interdum eget, sagittis et, consequat vestibulum, lacus. Mauris porttitor ullamcorper augue.</div>
		</div>


<h1>Funding manager</h1>
<h2>Purchase Orders</h2>
<h3>Pending</h3>
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
<br />
<h3>Completed</h3>
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

<form action="man_funds.php?action=add" method="post">
<h2>Necessary Approval List</h2>
<table>
<tr>
	<td><p class="name">Root Name</p></td>
	<td><input type="text" name="name" list="datalist1"></td>
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
