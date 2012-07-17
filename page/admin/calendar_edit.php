<h1>Calendar: editing <?= $info[3] ?></h1>

<form action="calendar.php?action=edit_do&id=<?= $event_id ?>" method="post">
<table>
<tr>
	<td>Name</td>
	<td><?= $info[3] ?></td>
</tr>
<tr>
	<td>Description</td>
	<td><textarea name="description"><?= $info[4] ?></textarea></td>
</tr>
<tr>
	<td>Start time</td>
	<td><?= $info[5] ?></td>
</tr>
<tr>
	<td>End time</td>
	<td><?= $info[6] ?></td>
</tr>
</table>
<input type="submit" value="Edit" />
</form>

<h2>Edit reservations</h2>

<form action="calendar.php?action=reserve&id=<?= $event_id ?>" method="post">
<select name="reservable_id">
<? foreach($reservables as $reservable_id => $reservable) { ?>
	<option value="<?= $reservable_id ?>"><?= $reservable[0] ?></option>
<? } ?>
</select><br />
Reason <input name="reason" type="text" /><br />
<input type="submit" value="Add reservation">
</form>

<h2>Current reservations</h2>
<table>
<tr>
	<td>Name</td>
	<td>Reason</td>
	<td>Remove</td>
</tr>
<? foreach ($reservations as $reservation) { ?>
	<tr>
		<td><?= $reservation[3] ?></td>
		<td><?= $reservation[1] ?></td>
		<td>
			<a href="calendar.php?action=unreserve&id=<?= $event_id ?>&reservable_id=<?= $reservation[0] ?>">remove</a>
		</td>
	</tr>
<? } ?>
</table>
