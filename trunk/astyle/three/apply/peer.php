<h2 class="separate">Peer recommendations</h2>
<p>Certain clubs may require a peer recommendation letter. Use the "Create New" feature to ask individuals for their inputs on your behalf.</p>
<p>For information on submitting different peer recommendations to different clubs, <a target="_blank" href="../help.php?page=submit_different">Click here!</a></p>

<div id="tabs">
	<ul>
		<li><a href="#tabs-1">View Requested</a></li>
		<li><a href="#tabs-2">Create New</a></li>
	</ul>
<div id="tabs-1">
<? if(count($recList)>0){ ?>
<table width=100% class="styled">
<tr>
	<th>Name</th>
	<th>Email</th>
	<th>Status</th>
	<th>Toggle <a target="_blank" href="../help.php?page=submit_different" style="cursor:help">[?]</a></th>
</tr>


<?
	foreach($recList as $rec) {
		echo "<tr align=\"center\"><td>" . $rec[1] . "</td>";
		echo "<td>" . $rec[2] . "</td>";
	
		$statusString = ($rec[3] == "0") ? "<font color=\"red\">INCOMPLETE</font>" : "<font color=\"green\">ENABLED</font>";
		if($rec[3] == 2) $statusString = "<font color=\"red\">DISABLED</font>";
		echo "<td><b>" . $statusString . "</b></td>";
	
		echo "<td><form method=\"POST\" action=\"peer.php?toggle=true&id=" . $rec[0] . "\">";
		echo "<input type=\"submit\" value=\"Toggle\">";
		echo "</form></td>";
	}
	?>

	</table>
<? } else { ?>
	<p>You have not requested any recommendations!</p>
<? } ?>
</div>
<div id="tabs-2">

<form action="peer.php" method="POST">
<table width=80%>
<tr><td>Name:</td><td><input type="text" name="name" style="width:100%"></td></tr>
<tr><td>Email address:</td><td><input type="text" name="email" style="width:100%"></td></tr>
<tr><td colspan="2">Message:<textarea rows="6" cols="50" name="message" style="width:100%;resize:vertical;min-height:100px">Dear [insert name here],

This is <?= $name ?>. I would like to request a peer recommendation from you. I have already communicated with you about this; the details for submitting the recommendation should appear above.

Thank you!</textarea></td></tr>
<tr><td colspan="2"><div class="msg msgWarn" title="Click to hide">This message will send exactly as is written here!</div></td></tr>
<tr><td colspan="2" align="right"><input type="submit" value="Request"></td></tr>
</table>
</form>
</div>
</div>
