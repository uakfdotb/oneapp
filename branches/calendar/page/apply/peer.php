<h1>Peer recommendations</h1>

<?
if(isset($message)) {
	echo "<p>" . $message . "</p>";
}
?>

<p>The recommendations that you have already requested are listed below. For information on submitting different peer recommendations to different clubs, click <a target="_blank" href="../help.php?page=submit_different">here</a>.</p>

<table>
<tr>
	<th>Name</th>
	<th>Email</th>
	<th>Status</th>
	<th>Toggle (<a target="_blank" href="../help.php?page=submit_different">?</a>)</th>
</tr>

<?
foreach($recList as $rec) {
	echo "<tr>";
	echo "<td>" . $rec[1] . "</td>";
	echo "<td>" . $rec[2] . "</td>";
	
	$statusString = ($rec[3] == "0") ? "<font color=\"red\">Incomplete</font>" : "<font color=\"green\">Enabled</font>";
	if($rec[3] == 2) $statusString = "<font color=\"red\">Disabled</font>";
	echo "<td>" . $statusString . "</td>";
	
	echo "<td><form method=\"POST\" action=\"peer.php?toggle=true&id=" . $rec[0] . "\">";
	echo "<input type=\"submit\" value=\"Toggle\">";
	echo "</form></td>";
}
?>

</table>

<p>Use the form below to request a peer recommendation.</p>

<form action="peer.php" method="POST"><table>
<tr>
	<td>Name:</td>
	<td><input type="text" name="name"></td>
</tr>
<tr>
	<td>Email address:</td>
	<td><input type="text" name="email"></td>
</tr>
<tr>
	<td colspan="2">
	Message:
	<textarea rows="6" cols="50" name="message" style="width:100%;resize:none">Dear [insert name here],

	This is [insert your name]. I would like to request a peer recommendation from you. I have already communicated with you about this; the details for submitting the recommendation should appear above.</textarea>
	</td>
</tr>
<tr>
	<td colspan="2"><input type="submit" value="Request"></td>
</tr>
</table>
</form>
