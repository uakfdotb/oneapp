<h1>Peer recommendations</h1>

<?
if(isset($message)) {
	echo "<p>" . $message . "</p>";
}
?>

<p>The recommendations that you have already requested are listed below. For information on submitting different peer recommendations to different clubs, click <a target="_blank" href="../help.php?page=submit_different">here</a>.</p>

<table><tr><th>Name</th><th>Email</th><th>Status</th><th>Toggle (<a target="_blank" href="../help.php?page=submit_different">?</a>)</th></tr>

<?
foreach($recList as $rec) {
	echo "<tr><td>" . $rec[1] . "</td>";
	echo "<td>" . $rec[2] . "</td>";
	
	$statusString = ($rec[3] == "0") ? "incomplete" : "complete (enabled)";
	if($rec[3] == 2) $statusString = "complete (disabled)";
	echo "<td>" . $statusString . "</td>";
	
	echo "<td><form method=\"POST\" action=\"peer.php?toggle=true&id=" . $rec[0] . "\">";
	echo "<input type=\"submit\" value=\"Toggle\">";
	echo "</form></td>";
}
?>

</table>

<p>Use the form below to request a peer recommendation.</p>

<form action="peer.php" method="POST">
Name: <input type="text" name="name"><br>
Email address: <input type="text" name="email"><br>
Message:<br><textarea rows="6" cols="50" name="message">Dear ___,

This is ___ ___. I would like to request a peer recommendation from you. I have already communicated with you about this; the details for submitting the recommendation should appear above.</textarea>
<input type="submit" value="Request">
</form>
