<h1>Calendar</h1>

<p>Use the form below to register a new event to the calendar, or select an event from the list to complete it's addition or add reservations.</p>

<form method="post" action="calendar.php?action=register">
Name: <input type="text" name="name" /><br />
Description: <textarea name="description"></textarea><br />
Start time: <input type="text" name="start_time" /><br />
End time: <input type="text" name="end_time" /><br />
<input type="submit" value="Register event" />
</form>

<table>
<tr>
	<th>Name</th>
	<th>Start time</th>
	<th>End time</th>
	<th>Status</th>
</tr>

<? foreach($events as $event_id => $event) { ?>
	<tr>
		<td><?= $event[0] ?></td>
		<td><?= timeString($event[1]) ?></td>
		<td><?= timeString($event[2]) ?></td>
		<td><?
			if($event[3] == 0) echo "<a href=\"calendar.php?action=add&id=$event_id\">Not completed</a>";
			else echo "<a href=\"calendar.php?action=edit&id=$event_id\">On calendar</a>";
		?></td>
	</tr>
<? } ?>

</table>
