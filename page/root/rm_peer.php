<h1>Remove peer recommendations</h1>

<p>This tool is provided so that you can remove recommendations if a user accidentally requests one or provides an invalid email address. To retrieve the user ID, you should use the User List page. Then, enter the user ID, and a list of recommendations will be displayed. If you press delete, the recommendation request will be deleted (note that the recommender will receive an error if he or she then tries to submit a recommendation).</p>

<form method="GET" action="rm_peer.php">
<table>
<tr>
	<td>User ID</td>
	<td>
	<select name="user_id" />
		<option value="0"></option>
		<?
		while( $row = mysql_fetch_row($userdata)) {
			echo "<option value=\"" . $row[0] . "\" />" . $row[0] . " - " . $row[1] . "</option>";
		}
		?>
	</select>
	</td>
	<td><input type="submit" value="List"></td>
</tr>
</table>
</form>

<?
if($recommendationResult !== FALSE) {
?>

	<table class="borderon" width=100%>
	<tr>
		<th>Author</th>
		<th>Email</th>
		<th>Auth</th>
		<th>Status</th>
		<th>File</th>
		<th>Delete</th>
	</tr>

<?
	$rowcounter = 1; //used to identify which row we are on for banding
	while($row = mysql_fetch_array($recommendationResult)) {
?>
		<tr>
		<td><?= $row['author'] ?></td>
		<td><?= $row['email'] ?></td>
		<td><?= wordwrap($row['auth'], 15, "<br>", true) ?></p></td>
		<td><?= getStatusString($row['status']) ?></p></td>
		
		<td>
		<? if($row['filename'] != '') { ?>
			<a href="../submit/<?= $row['filename'] ?>.pdf">link</a>
		<? } else { ?>
			N/A
		<? } ?>
		</td>

		<td>
			<form method="POST" action="rm_peer.php?user_id=<?= $user_id ?>&remove_id=<?= $row['id'] ?>">
			<input type="submit" value="Delete" />
			</form>
		</td>

		</tr>
<?
	}
	
	echo '</table>';
}
?>

