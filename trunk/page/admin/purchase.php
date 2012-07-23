<h1>Club Money</h1>

<p>Current Balance: <?= display_money($balance) ?></p>
<div id="tabs">
	<ul>
		<li><a href="#tabs-1">Accepted</a></li>
		<li><a href="#tabs-2">Rejected</a></li>
		<li><a href="#tabs-3">Pending</a></li>
		<li><a href="#tabs-4">Incomplete</a></li>
	</ul>
<div id="tabs-1">
<table class="tbl_repeat">
	<tr>
		<th width=40% align="left">Description</th>
		<th>Submited</th>
		<th>Accepted</th>
		<th>Amount</th>
		<th></th>
	</tr>
<? while($row = mysql_fetch_array($accept)) { ?>
	<tr align="center">
		<td valign="bottom" align="left"><?= $row['description']?></td>
		<td valign="bottom"><?= date('m/d/y', $row['submit_time']) ?></td>
		<td valign="bottom"><?= date('m/d/y', $row['status_time']) ?></td>
		<td valign="bottom"><?= display_money($row['amount']) ?></td>
		<td valign="bottom"><a href="../submit/<?= $row['filename']?>.pdf"><div class="nav-button-vertical small"><div class="pdf_small"></div></div></a></td>
	</tr>
<? } ?>
</table>
</div>
<div id="tabs-2">
<table class="tbl_repeat">
	<tr>
		<th width=40% align="left">Description</th>
		<th>Submited</th>
		<th>Rejected</th>
		<th>Amount</th>
		<th></th>
	</tr>
<? while($row = mysql_fetch_array($reject)) { ?>
	<tr align="center">
		<td valign="bottom" align="left"><?= $row['description']?><br /><b><?= getPurchaseStatusString($row['status'])?></b></td>
		<td valign="bottom"><?= date('m/d/y', $row['submit_time']) ?></td>
		<td valign="bottom"><?= date('m/d/y', $row['status_time']) ?></td>
		<td valign="bottom"><?= display_money($row['amount']) ?></td>
		<td valign="bottom"><a href="../submit/<?= $row['filename']?>.pdf"><div class="nav-button-vertical small"><div class="pdf_small"></div></div></a></td>
	</tr>
<? } ?>
</table>
</div>
<div id="tabs-3">
<table class="tbl_repeat">
	<tr>
		<th width=40% align="left">Description</th>
		<th>Submitted</th>
		<th>Last Changed</th>
		<th>Authorized</th>
		<th></th>
	</tr>
<? while($row = mysql_fetch_array($pending)) { ?>
	<tr align="center">
		<td valign="bottom" align="left"><?= $row['description']?><br /><b>Awaiting: <?= getPurchaseStatusString($row['status'])?></b></td>
		<td valign="bottom"><?= date('m/d/y', $row['submit_time']) ?></td>
		<td valign="bottom"><?= date('m/d/y', $row['status_time']) ?></td>
		<td valign="bottom"><?= display_money($row['amount']) ?></td>
		<td valign="bottom"><a href="../submit/<?= $row['filename']?>.pdf"><div class="nav-button-vertical small"><div class="pdf_small"></div></div></a></td>
	</tr>
<? } ?>
</table>
</div>
<div id="tabs-4">
<form action="purchase.php">
<table class="tbl_repeat">
	<tr>
		<th width=40% align="left">Description</th>
		<th>Created</th>
		<th>Amount</th>
		<th></th>
		<th></th>
	</tr>
<? while($row = mysql_fetch_array($incomplete)) { ?>
	<tr align="center">
		<td valign="bottom" align="left"><?= $row['description']?></td>
		<td valign="bottom"><?= date('m/d/y', $row['submit_time']) ?></td>
		<td valign="bottom"><?= display_money($row['amount']) ?></td>
		<td valign="bottom"><button value="<?=$row['id']?>" name="edit" class="app_edit">Edit</button></td>
		<td valign="bottom"><button value="<?=$row['id']?>" name="delete" class="delete negative">Delete</button></td>
	</tr>
<? } ?>
</table>
</form>
</div>
</div>

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
	<td colspan="2"><button class="add">Create New Order</button></td>
</tr>
</form>
</table>
