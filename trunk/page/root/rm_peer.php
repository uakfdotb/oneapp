<form method="GET" action="rm_peer.php">
User ID: <input type="text" name="user_id" />
<input type="submit" value="List">
</form><br><br>

<?
if($recommendationResult !== FALSE) {
?>

	<table class="borderon" width=100%>
	<tr>
		<th><p class="admin_table_header">Author</p></th>
		<th><p class="admin_table_header">Email</p></th>
		<th width=100px><p class="admin_table_header">Auth</p></th>
		<th><p class="admin_table_header">Status</p></th>
		<th><p class="admin_table_header">File</p></th>
		<th><p class="admin_table_header">Delete</p></th>
	</tr>

<?
	$rowcounter = 1; //used to identify which row we are on for banding
	while($row = mysql_fetch_array($recommendationResult)) {
?>
		<tr align="center" class="band<?= $rowcounter%2 ?>">
		<td><p><?= $row['author'] ?></p></td>
		<td><p><?= $row['email'] ?></p></td>
		<td><p><?= wordwrap($row['auth'], 15, "<br>", true) ?></p></td>
		<td><p><?= getStatusString($row['status']) ?></p></td>
	
		<? if($row['filename'] != '') { ?>
			<td><a href="../submit/<?= $row['filename'] ?>.pdf">link</a></td>
		<? } else { ?>
			<td><p>N/A</p></td>
		<? } ?>
	
		<td><form method="POST" action="rm_peer.php?user_id=<?= $user_id ?>&remove_id=<?= $row['id'] ?>">
		<input type="submit" value="Delete" /></form></td>
	
		</tr>
<?
		$rowcounter = $rowcounter + 1;
	}
	echo '</table>';
}
?>

