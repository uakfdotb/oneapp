<h1>Peer recommendations</h1>

<?
if(isset($message)) {
	echo "<p>" . $message . "</p>";
}
?>

<p>The recommendations that you have already requested are listed below.</p>

<table><tr><th>Name</th><th>Email</th><th>Status</th></tr>

<?
foreach($recList as $rec) {
	echo "<tr><td>" . $rec[0] . "</td>";
	echo "<td>" . $rec[1] . "</td>";
	$statusString = ($rec[2] == "0") ? "incomplete" : "complete";
	echo "<td>" . $statusString . "</td></tr>";
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
