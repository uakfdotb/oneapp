<h1>Messaging</h1>

<p>Select a messaging tool below:</p>

<table width=100%>
<td><a href="messaging.php?view=box">View messages</a> | <a href="messaging.php?view=compose">Compose</a> | <a href="messaging.php?view=prefs">Preferences</a></td>
</tr></table>
<br />
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
	
	<table>
	<tr float="left"><td><? displayBoxSelector($boxes, $box_id); ?>
	<td><input type="submit" value="Go"></td></tr></table>
	</form>
	
	<table class="tbl_repeat" width=100%>
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
	<table class="tbl_repeat">
	<form method="post" action="messaging.php?action=send">
	<tr><td>To</td><td><input type="text" name="to" value="<?= $contents ?>" style="width:100%" /></td></tr>
	<tr><td>Subject</td><td><input type="text" name="subject" style="width:100%" /></td></tr>
	<tr><td colspan="2">Message<br /><textarea name="body" rows="7" style="width:100%"></textarea></td></tr>
	<tr align="right"><td colspan="2"><input type="submit" value="Send" /></td></tr>
	</form>
	</table>
<? } else if($view == "message") { ?>
	//contents = array(sender id, sender name, sender username, receiver id, receiver name, receiver username, subject, body, time) ?>
	To: <a href="messaging.php?view=compose&target=<?= $contents[1] ?>"><?= $contents[2] ?> (<?= $contents[1] ?>)</a><br />
	From: <a href="messaging.php?view=compose&target=<?= $contents[4] ?>"><?= $contents[5] ?> (<?= $contents[4] ?>)</a><br />
	Subject: <?= $contents[6] ?><br />
	Body:
	<div><?= $contents[7] ?></div>
<? } else if($view == "prefs") { ?>
	<table class="tbl_repeat">
	<tr>
		<th align="left">Basic Configuration</th>
		<th></th>
	</tr>
	<form method="post" action="messaging.php?action=prefs">
	<tr><td>Notify by email on new message?</td><td><input type="checkbox" name="notify_email" value="yes" <? if($prefs[0]) echo "checked"; ?>/></td></tr>
	<tr><td>Inbox box</td><td><? displayBoxSelector($boxes, $prefs[1], "save_inbox"); ?></td></tr>
	<tr><td>Trash box</td><td><? displayBoxSelector($boxes, $prefs[2], "save_trash"); ?></td></tr>
	<tr><td>Sent box</td><td><? displayBoxSelector($boxes, $prefs[3], "save_sent"); ?></td></tr>
	</table>
	<input type="submit" value="Save preferences" style="float:right"/>
	</form>
	<br />
	<br />
	
	<table class="tbl_repeat">
	<tr>
		<th align="left">Manage Boxes</th>
		<th></th>
	</tr>
	<form method="get" action="messaging.php">
	<input type="hidden" name="action" value="deletebox" />
	<? foreach($boxes as $box_array) { //box_array is array(box id, box name) ?>
		<tr><td><?= $box_array[1] ?></td><td><button name="box_id" value="<?= $box_array[0] ?>">Delete</button></td></tr>
	<? } ?>
	</form>
	
	<form method="post" action="messaging.php?action=addbox">
	<tr><td>Box name</td><td><input type="text" name="name" /><input type="submit" value="Add box" style="float:right"/></td></tr>
	</table>
	
	</form>
<? } ?>
