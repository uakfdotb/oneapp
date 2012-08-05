<?php

//attempts to send a message through messaging system
//returns true on success
//error codes:
// 1: internal server error
// 2: invalid target
// 3: user is not an administrator
function sendAdminGroupMessage($user_id, $club_id, $target, $subject, $body) {
	if($target != "all" && $target != "complete" && $target != "uncomplete" && $target != "subscribe")
		return 2;
	
	$user_id = escape($user_id);
	$club_id = escape($club_id);
	
	//confirm that user can administrate the club
	$result = mysql_query("SELECT COUNT(*) FROM user_groups WHERE user_id = '$user_id' AND `group` = '$club_id'");
	$row = mysql_fetch_array($result);
	
	if($row[0] == 0) {
		return 3;
	}
	
	//now get all targets to send to, and send message to each target
	if($target == "subscribe") {
		$targets = listSubscribers($club_id);
		
		foreach($targets as $target_id) {
			sendMessage($user_id, $target_id, $subject, $body);
		}
	} else {
		$query = "SELECT users.id FROM applications LEFT JOIN users ON users.id = applications.user_id WHERE applications.club_id = '$club_id'";
	
		if($target == "complete")
			$query .= " AND submitted != ''";
		else if($target == "uncomplete")
			$query .= " AND submitted = ''";
	
		$result = mysql_query($query);
	
		//send email to each target
	
		while($row = mysql_fetch_array($result)) {
			sendMessage($user_id, $row[0], $subject, $body);
		}
	}
}

//attempts to send a message to all administrators
//returns true on success
//error codes:
// 1: user is not an administrator
function sendMessageAdmins($user_id, $subject, $body) {
	$user_id = escape($user_id);
	
	//confirm that user is an administrator
	$result = mysql_query("SELECT COUNT(*) FROM user_groups WHERE user_id = '$user_id'");
	$row = mysql_fetch_array($result);
	
	if($row[0] == 0) {
		return 3;
	}
	
	//get all targets
	$result = mysql_query("SELECT DISTINCT user_id FROM user_groups");
	
	while($row = mysql_fetch_array($result)) {
		sendMessage($user_id, $row[0], $subject, $body);
	}
}

//true on success
//1: could not find target user
//2: could not find sending user
//3: sending user has disabled incoming messages (no inbox)
function sendMessage($sender, $receiver, $subject, $body) {
	$config = $GLOBALS['config'];

	$sender = escape($sender);
	$receiver = escape($receiver);
	$escsubject = escape(htmlentities($subject));
	$escbody = escape(htmlentities($body));
	$time = time();
	
	//make sure receiver exists; at the same time, grab email address
	$receiver_email = "";
	$result = mysql_query("SELECT email FROM users WHERE id = '$receiver'");
	
	if($row = mysql_fetch_array($result)) {
		$receiver_email = $row[0];
	} else {
		return 1;
	}
	
	//get sender information
	$sender_name = "";
	$sender_username = "";
	
	$result = mysql_query("SELECT name, username FROM users WHERE id = '$sender'");
	
	if($row = mysql_fetch_array($result)) {
		$sender_name = $row[0];
		$sender_username = $row[1];
	} else {
		return 2;
	}

	//add message to database
	mysql_query("INSERT INTO messages (sender_id, receiver_id, subject, body, time) VALUES ('$sender', '$receiver', '$escsubject', '$escbody', '$time')");
	$message_id = mysql_insert_id();
	
	//now send an email to receiver if notifications are enabled
	// also check for inbox folder to use
	$notify_email = false;
	$inbox_folder = 0;
	
	$result = mysql_query("SELECT notify_email, save_inbox FROM message_prefs WHERE user_id = '$receiver'");
	
	if($row = mysql_fetch_array($result)) {
		$notify_email = $row[0] == 1;
		$inbox_folder = $row[1];
	}
	
	if($notify_email) {
		$email_body = page_db("message_notifyemail");
		$email_body = str_replace('$NAME$', $sender_name, $email_body);
		$email_body = str_replace('$USERNAME$', $sender_username, $email_body);
		$email_body = str_replace('$SUBJECT$', $subject, $email_body);
		$email_body = str_replace('$BODY$', page_convert($body), $email_body);
		$email_body = str_replace('$MESSAGE_URL$', $config['site_address'] . "/application/messaging.php?view=message&message_id=$message_id&box_id=$inbox_folder", $email_body);
		one_mail("New private message", $receiver_email, $email_body);
	}
	
	//add message to inbox
	if($inbox_folder != 0) {
		mysql_query("INSERT INTO message_boxes_contents (box_id, message_id) VALUES ('$inbox_folder', '$message_id')");
	} else {
		//target user does not have inbox (incoming messages disabled?)
		//delete the message first
		mysql_query("DELETE FROM messages WHERE id = '$message_id'");
		return 3;
	}
	
	//find outbox settings and add if needed
	$result = mysql_query("SELECT save_sent FROM message_prefs WHERE user_id = '$sender'");
	
	if($row = mysql_fetch_array($result)) {
		$outbox_folder = $row[0];
		
		if($outbox_folder != 0) {
			mysql_query("INSERT INTO message_boxes_contents (box_id, message_id) VALUES ('$outbox_folder', '$message_id')");
		}
	}
}

//confirms access to a box
// true grants access, false rejects access
function openBox($user_id, $box_id) {
	$user_id = escape($user_id);
	$box_id = escape($box_id);
	
	$result = mysql_query("SELECT user_id FROM message_boxes WHERE id = '$box_id'");
	
	if($row = mysql_fetch_array($result)) {
		return $row[0] == $user_id;
	}
	
	return false;
}

//returns array of (message id, sender id, sender username, receiver id, receiver username, subject, time int)
function retrieveMessageList($user_id, $box_id) {
	$box_id = escape($box_id);
	
	$result = mysql_query("SELECT messages.id, messages.sender_id, sender.username, messages.receiver_id, receiver.username, messages.subject, messages.time FROM message_boxes_contents LEFT JOIN messages ON message_boxes_contents.message_id = messages.id LEFT JOIN users AS sender ON messages.sender_id = sender.id LEFT JOIN users AS receiver ON messages.receiver_id = receiver.id WHERE message_boxes_contents.box_id = '$box_id' ORDER BY messages.id DESC");
	$messages = array();
	
	while($row = mysql_fetch_row($result)) {
		array_push($messages, array($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6]));
	}
	
	return $messages;
}

//gets a message from a box
//array(sender id, sender name, sender username, receiver id, receiver name, receiver username, subject, body, time)
function retrieveMessage($user_id, $box_id, $message_id) {
	$box_id = escape($box_id);
	$message_id = escape($message_id);
	
	$result = mysql_query("SELECT messages.sender_id, messages.receiver_id, messages.subject, messages.body, messages.time FROM message_boxes_contents LEFT JOIN messages ON message_boxes_contents.message_id = messages.id WHERE message_boxes_contents.box_id = '$box_id' AND messages.id = '$message_id'");
	
	if($row = mysql_fetch_row($result)) {
		$sender_id = escape($row[0]);
		$receiver_id = escape($row[1]);
		$subject = $row[2];
		$body = page_convert($row[3]);
		$time = $row[4];
		
		$sender_name = "";
		$sender_username = "";
		$receiver_name = "";
		$receiver_username = "";
		
		$result = mysql_query("SELECT username, name FROM users WHERE id = '$sender_id'");
		if($row = mysql_fetch_row($result)) {
			$sender_username = $row[0];
			$sender_name = $row[1];
		}
		
		$result = mysql_query("SELECT username, name FROM users WHERE id = '$receiver_id'");
		if($row = mysql_fetch_row($result)) {
			$receiver_username = $row[0];
			$receiver_name = $row[1];
		}
		
		return array($sender_id, $sender_name, $sender_username, $receiver_id, $receiver_name, $receiver_username, $subject, $body, $time);
	}
	
	return false;
}

//retrieves list of boxes
function retrieveBoxList($user_id) {
	$user_id = escape($user_id);
	
	$result = mysql_query("SELECT id, box_name FROM message_boxes WHERE user_id = '$user_id'");
	$boxes = array();
	
	while($row = mysql_fetch_array($result)) {
		array_push($boxes, array($row['id'], $row['box_name']));
	}
	
	return $boxes;
}

//returns array (notify email, save inbox, save trash, save sent)
function retrievePreferences($user_id) {
	$user_id = escape($user_id);
	
	$result = mysql_query("SELECT notify_email, save_inbox, save_trash, save_sent FROM message_prefs WHERE user_id = '$user_id'");
	
	if($row = mysql_fetch_array($result)) {
		$notify_email = $row['notify_email'] == 1;
		return array($notify_email, $row['save_inbox'], $row['save_trash'], $row['save_sent']);
	} else {
		mysql_query("INSERT INTO message_prefs (user_id, notify_email, save_inbox, save_trash, save_sent) VALUES ('$user_id', '1', '0', '0', '0')");
		return array(1, 0, 0, 0);
	}
}

function savePreferences($user_id, $notify_email, $save_inbox, $save_trash, $save_sent) {
	$notify_email = ($notify_email == 1) ? 1 : 0;
	$save_inbox = intval($save_inbox);
	$save_trash = intval($save_trash);
	$save_sent = intval($save_sent);
	
	$result = mysql_query("SELECT COUNT(*) FROM message_prefs WHERE user_id = '$user_id'");
	$row = mysql_fetch_row($result);
	
	if($row[0] == 0) {
		mysql_query("INSERT INTO message_prefs (user_id, notify_email, save_inbox, save_trash, save_sent) VALUES ('$user_id', '$notify_email', '$save_inbox', '$save_trash', '$save_sent')");
	} else {
		mysql_query("UPDATE message_prefs SET notify_email = '$notify_email', save_inbox = '$save_inbox', save_trash = '$save_trash', save_sent = '$save_sent' WHERE user_id = '$user_id'");
	}
}

//deletes the specified message ID from a specified box
function boxDeleteMessage($user_id, $box_id, $message_id) {
	$user_id = escape($user_id);
	$box_id = escape($box_id);
	$message_id = escape($message_id);
	
	//move message to trash depending on settings
	$result = mysql_query("SELECT save_trash FROM message_prefs WHERE user_id = '$user_id'");
	
	if($row = mysql_fetch_array($result)) {
		$trash_folder = $row[0];
		
		if($trash_folder != 0 && $trash_folder != $box_id) {
			boxMoveMessage($user_id, $message_id, $box_id, $trash_folder);
		}
	}
	
	//delete the message link to the box
	mysql_query("DELETE FROM message_boxes_contents WHERE box_id = '$box_id' AND message_id = '$message_id'");
}

//moves a message into a new box
function boxMoveMessage($user_id, $message_id, $box_old_id, $box_id) {
	$message_id = escape($message_id);
	$box_old_id = escape($box_old_id);
	$box_id = escape($box_id);
	
	//delete the old box message link
	mysql_query("DELETE FROM message_boxes_contents WHERE box_id = '$box_old_id' AND message_id = '$message_id'");
	
	//add a new box message link
	mysql_query("INSERT INTO message_boxes_contents (box_id, message_id) VALUES ('$box_id', '$message_id'");
}

//gets the user's default box
function getDefaultBox($user_id) {
	$user_id = escape($user_id);
	
	//first try inbox
	$result = mysql_query("SELECT save_inbox FROM message_prefs WHERE user_id = '$user_id'");
	
	if($row = mysql_fetch_row($result)) {
		if($row[0] != 0) return $row[0];
	}
	
	//ok, now let's just get the first folder we see
	$result = mysql_query("SELECT id FROM message_boxes WHERE user_id = '$user_id' LIMIT 1");
	
	if($row = mysql_fetch_row($result)) {
		return $row[0];
	}
	
	//user has no boxes
	return FALSE;
}

function deleteBox($user_id, $box_id) {
	$user_id = escape($user_id);
	$box_id = escape($box_id);
	
	$result = mysql_query("SELECT COUNT(*) FROM message_boxes WHERE user_id = '$user_id' AND id = '$box_id'");
	$row = mysql_fetch_row($result);
	
	if($row[0] > 0) {
		mysql_query("DELETE FROM message_boxes WHERE id = '$box_id'");
		mysql_query("DELETE FROM message_boxes_contents WHERE box_id = '$box_id'");
	}
}

//adds a new box for a user
//returns the id of the new box
function addBox($user_id, $box_name) {
	$user_id = escape($user_id);
	$box_name = escape($box_name);
	$result = mysql_query("SELECT box_name FROM message_boxes WHERE user_id='$user_id' AND box_name='$box_name'");
	if(mysql_num_rows($result) > 0 ) {
		return false;
	}
	mysql_query("INSERT INTO message_boxes (user_id, box_name) VALUES ('$user_id', '$box_name')");
	return mysql_insert_id();
}

//sets up the messaging defaults for a user
function initMessaging($user_id) {
	$save_inbox = addBox($user_id, 'Inbox');
	$save_trash = addBox($user_id, 'Trash');
	$save_sent = addBox($user_id, 'Sent');
	
	savePreferences($user_id, 1, $save_inbox, $save_trash, $save_sent);
}

?>
