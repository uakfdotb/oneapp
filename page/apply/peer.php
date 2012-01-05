<h1>Peer recommendations</h1>

<?
if(isset($message)) {
	echo "<p>" . $message . "</p>";
}
?>

<p>The recommendations that you have already requested are listed below. For information on submitting different peer recommendations to different clubs, click <a target="_blank" href="../help.php?page=submit_different">here</a>.</p>

<table width=100% class="borderon"><tr align="center"><th><p class="admin_table_header">Name</p></th><th><p class="admin_table_header">Email</p></th><th><p class="admin_table_header">Status</p></th><th><p class="admin_table_header">Toggle (<a target="_blank" href="../help.php?page=submit_different">?</a>)</th></tr>

<?
foreach($recList as $rec) {
	echo "<tr align=\"center\"><td><p>" . $rec[1] . "</p></td>";
	echo "<td><p>" . $rec[2] . "</p></td>";
	
	$statusString = ($rec[3] == "0") ? "incomplete" : "complete (enabled)";
	if($rec[3] == 2) $statusString = "complete (disabled)";
	echo "<td><p>" . $statusString . "<p></td>";
	
	echo "<td><form method=\"POST\" action=\"peer.php?toggle=true&id=" . $rec[0] . "\">";
	echo "<input type=\"submit\" value=\"Toggle\">";
	echo "</form></td>";
}
?>

</table>

<p>Use the form below to request a peer recommendation.</p>

<form action="peer.php" method="POST"><table>
<tr><td><p class="name">*Name:</p></td><td><input type="text" name="name" style="width:100%"></td></tr>
<tr><td><p class="name">*Email address:</p></td><td><input type="text" name="email" style="width:100%"></td></tr>
<tr><td colspan="2"><p class="name">*Message:</p><textarea rows="6" cols="50" name="message" style="width:100%;resize:none">Dear [insert name here],

This is [Insert Your Name]. I would like to request a peer recommendation from you. I have already communicated with you about this; the details for submitting the recommendation should appear above.</textarea></td></tr>
<tr><td colspan="2" align="right"><input type="submit" value="Request"></td></tr>
</table>
</form>
