<h1>Messaging</h1>

<p>Select a messaging tool below:</p>

<ul>
<li><a href="messaging.php?view=box">View messages</a></li>
<li><a href="messaging.php?view=compose">Compose</a></li>
<li><a href="messaging.php?view=prefs">Preferences</a></li>
</ul>

<?
function displayBoxSelector($boxes, $default_box = -1, $select_name = "box_id") {
?>
	<select name="<?= $select_name ?>">
	<option value="0">None</option>
	<? foreach($boxes as $box_array) { //box_array is array(box id, box name) ?>
		<option value="<?= $box_array[0] ?>" <? if($box_array[0] == $default_box) echo "selected"; ?>><?= $box_array[1] ?></option>
	<? } ?>
	</select>
<? } ?>

<? if($view == "box") { ?>
	<form method="get" action="messaging.php">
	<input type="hidden" name="view" value="box">
	<? displayBoxSelector($boxes, $box_id); ?>
	<input type="submit" value="Go">
	</form>
	
	<table>
	<tr>
		<th>From</th>
		<th>To</th>
		<th>Subject</th>
		<th>Date</th>
	</tr>
	
	<? foreach($contents as $message) { //message is array(message id, sender id, sender username, receiver id, receiver username, subject, time int) ?>
		<tr>
		<td><a href="messaging.php?view=compose&target=<?= $message[2] ?>"><?= $message[2] ?></a></td>
		<td><a href="messaging.php?view=compose&target=<?= $message[4] ?>"><?= $message[4] ?></a></td>
		<td><a href="messaging.php?view=message&box_id=<?= $box_id ?>&message_id=<?= $message[0] ?>"><?= $message[5] ?></a></td>
		<td><?= timeString($message[6]) ?></td>
		</tr>
	<? } ?>
	
	</table>
<? } else if($view == "compose") { ?>
	<form method="post" action="messaging.php?action=send">
	To: <input type="text" name="to" value="<?= $contents ?>" /><br />
	Subject: <input type="text" name="subject" /><br />
	Message: <textarea name="body" rows="7" cols="25"></textarea><br />
	<input type="submit" value="Send" />
	</form>
<? } else if($view == "message") {
	//contents = array(sender id, sender name, sender username, receiver id, receiver name, receiver username, subject, body, time) ?>
	To: <a href="messaging.php?view=compose&target=<?= $contents[1] ?>"><?= $contents[2] ?> (<?= $contents[1] ?>)</a><br />
	From: <a href="messaging.php?view=compose&target=<?= $contents[4] ?>"><?= $contents[5] ?> (<?= $contents[4] ?>)</a><br />
	Subject: <?= $contents[6] ?><br />
	Body:
	<div><?= $contents[7] ?></div>
<? } else if($view == "prefs") { ?>
	<h3>Preferences</h3>
	<form method="post" action="messaging.php?action=prefs">
	Notify by email on new message? <input type="checkbox" name="notify_email" value="yes" <? if($prefs[0]) echo "checked"; ?>/><br />
	Inbox box: <? displayBoxSelector($boxes, $prefs[1], "save_inbox"); ?><br />
	Trash box: <? displayBoxSelector($boxes, $prefs[2], "save_trash"); ?><br />
	Sent box: <? displayBoxSelector($boxes, $prefs[3], "save_sent"); ?><br />
	<input type="submit" value="Save preferences" />
	</form>
	
	<h3>Manage boxes</h3>
	<form method="get" action="messaging.php">
	<input type="hidden" name="action" value="deletebox" />
	<? displayBoxSelector($boxes); ?>
	<input type="submit" value="Delete box" />
	</form>
	
	<form method="post" action="messaging.php?action=addbox">
	Box name: <input type="text" name="name" />
	<input type="submit" value="Add box" />
	</form>
<? } ?>
