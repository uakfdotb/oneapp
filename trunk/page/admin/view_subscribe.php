<h1>View subscribers</h1>

<p>A list of users subscribed to your club appears below. These users will receive notifications when you <a href="messaging.php">message</a> all subscribers. Users that apply to your club will be automatically subscribed, but may unsubscribe without removing the application.</p>

<table>
<tr>
	<th>User ID</th>
	<th>Username</th>
	<th>Name</th>
	<th>Email</th>
</tr>

<?
foreach($subscribers as $user_id => $subscriber) {
	$displayId = '<a href="user_detail.php?id=' . $user_id . '">' . $user_id . '</a>';
	$displayUser = '<a href="user_detail.php?id=' . $user_id . '">' . $subscriber[0] . '</a>';
	$displayName = '<a href="user_detail.php?id=' . $user_id . '">' . $subscriber[2] . '</a>';
	$displayEmail = '<a href="mailto:' . $subscriber[1] . '">' . $subscriber[1] . '</a>';
	
	
	echo "<tr>";
	echo "<td>$displayId</td>";
	echo "<td>$displayUser</td>";
	echo "<td>$displayName</td>";
	echo "<td>$displayEmail</td>";
	echo '</tr>';
}
?>

</table>
