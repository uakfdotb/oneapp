<h1><a href="root_cat.php?cat=Manage">Manage</a> > Funds</h1>

<p>Through the Funding Manager tab, we provide resources to request additional funding and either approve or deny such propositions. Within the <b>Pending</b> option, you can view clubs withdrawing or depositing funds. <b>Complete</b> shows your approval history, and <b>Necessary Approval List</b> allows the root user to design the order in which the files would be approved or rejected by admin.</p>
<div id="tabs">
	<ul>
		<li><a href="#tabs-1">Pending</a></li>
		<li><a href="#tabs-2">Complete</a></li>
		<li><a href="#tabs-3">Necessary Approval List</a></li>
	</ul>
<div id="tabs-1">
<? if(mysql_num_rows($pending) == 0) {
	echo "<p>No purchase orders pending!</p>";
} else { ?>
	<form action="man_funds.php">
	<table class="tbl_repeat">
	<tr>
		<th>Club Name</th>
		<th>Submit Time</th>
		<th>Current Status</th>
		<th>Amount</th>
		<th>Form</th>
		<th></th>
	</tr>

	<? while($row = mysql_fetch_array($pending)) { ?>
		<tr>
			<td valign="bottom"><? $club_detail = clubInfo($row['club_id']); echo $club_detail[0]; ?></td>
			<td valign="bottom"><?= date('m/d/Y', $row['submit_time'])?></td>
			<td valign="bottom">Awaiting: <?= getPurchaseStatusString($row['status'])?></td>
			<td valign="bottom"><?= display_money($row['amount'])?></td>
			<td><a href="../submit/<?= $row['filename']?>.pdf"><div class="nav-button-vertical small"><div class="pdf_small"></div></div></a></td>
			<td valign="bottom"><button name="status_change" value="<?=$row['id']?>" class="accept positive" style="width:100%" />Approve</button><button name="status_change" value="<?=-1*$row['id']?>" class="reject negative" style="width:100%" />Reject</button></td>
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
			<td><?= display_money($row['amount'])?></td>
		</tr>
	<? } ?>
	</table>
</div>
<div id="tabs-3">
	<form action="man_funds.php?action=add" method="post">
	<table width="60%" class="center">
	<tr>
		<td width=35%><p class="name">Root Name</p></td>
		<td><input type="text" name="name" list="datalist1" autocomplete="off" class="right" style="width:85%"/></td>
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
<br />
	<table class="tbl_repeat center" style="width:70%" >
	<tr>
		<th align="left">Order</th>
		<th></th>
		<th></th>
		<th></th>
	</tr>

	<?
	foreach($purchaseList as $item) {
	?>
		<form method="post" action="man_funds.php">
		<input type="hidden" name="id" value="<?= $item[0] ?>">
		<tr align="center">
			<td><p class="name"><?= $item[1] ?></p></td>
			<td><input type="submit" name="action" value="Delete" class="delete negative" /></td>
			<td><input type="submit" name="action" value="up" class="up" /></td>
			<td><input type="submit" name="action" value="down" class="down" /></td>
		</tr>
		</form>
	<?
	}
	?>

	</table>
</div>
</div>
