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

<form action="peer.php" method="POST" class="uniForm fullwidth">
<fieldset>
<div class="ctrlHolder">
<label>Name</label>
<input type="text" name="name">
</div>
<div class="ctrlHolder">
<label>Email address</label>
<input type="text" name="email">
</div>
<div class="ctrlHolder">
<label>Message</label>
<textarea rows="6" cols="50" name="message">Dear [insert name here],

This is <?= $name ?>. I would like to request a peer recommendation from you. I have already communicated with you about this; the details for submitting the recommendation should appear above.

Thank you!</textarea>
<p class="formHint">This message will send exactly as is written here!</p>
</div>
<div class="buttonHolder">
<input type="submit" value="Request" class="request primaryAction">
</div>
</fieldset>
</form>
</div>
</div>
