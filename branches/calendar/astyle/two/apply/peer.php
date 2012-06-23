<h1>Peer recommendations</h1>

<?
if(isset($message)) {
	echo "<p>" . $message . "</p>";
}
?>

<p>For information on submitting different peer recommendations to different clubs, click <a target="_blank" href="../help.php?page=submit_different">here</a>.</p>

<? if(count($recList)>0){ ?>
<p>Here are the recommendations you have requested</p>
<br />
<table width=100% class="borderon"><tr align="center"><th><p class="admin_table_header">Name</p></th><th><p class="admin_table_header">Email</p></th><th><p class="admin_table_header">Status</p></th><th><p class="admin_table_header">Toggle (<a target="_blank" href="../help.php?page=submit_different">?</a>)</th></tr>


<?
	foreach($recList as $rec) {
		echo "<tr align=\"center\"><td><p>" . $rec[1] . "</p></td>";
		echo "<td><p>" . $rec[2] . "</p></td>";
	
		$statusString = ($rec[3] == "0") ? "<font color=\"red\">INCOMPLETE</font>" : "<font color=\"green\">ENABLED</font>";
		if($rec[3] == 2) $statusString = "<font color=\"red\">DISABLED</font>";
		echo "<td><p>" . $statusString . "<p></td>";
	
		echo "<td><form method=\"POST\" action=\"peer.php?toggle=true&id=" . $rec[0] . "\">";
		echo "<input type=\"submit\" value=\"Toggle\">";
		echo "</form></td>";
	}
	?>

	</table>
<? } ?>
<br />
<br />
<p>Use the form below to request a peer recommendation.</p>

<form action="peer.php" method="POST"><table width=80%>
<tr><td><p class="name">*Name:</p></td><td><input type="text" name="name" style="width:100%"></td></tr>
<tr><td><p class="name">*Email address:</p></td><td><input type="text" name="email" style="width:100%"></td></tr>
<tr><td colspan="2"><p class="name">*Message:</p><textarea rows="6" cols="50" name="message" style="width:100%;resize:vertical;min-height:100px">Dear [insert name here],

This is [Insert Your Name]. I would like to request a peer recommendation from you. I have already communicated with you about this; the details for submitting the recommendation should appear above.</textarea></td></tr>
<tr><td colspan="2"><div class="warning">This message will send exactly as is written here!</div></td></tr>
<tr><td colspan="2" align="right"><input type="submit" value="Request"></td></tr>
</table>
</form>
