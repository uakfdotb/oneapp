<?php
include("../include/common.php");
include("../config.php");
include("../include/db_connect.php");
include("../include/session.php");

include("../include/messaging.php");

if(isset($_SESSION['user_id'])) {
	
	$inform = array();
	
	if(isset($_REQUEST['action'])) {
		if($_REQUEST['action'] == "prefs") {
			if(isset($_REQUEST['save_inbox']) && isset($_REQUEST['save_trash']) && isset($_REQUEST['save_sent'])) {
				$notify_email = (isset($_REQUEST['notify_email']) && $_REQUEST['notify_email'] == "yes") ? 1 : 0;
				$save_inbox = $_REQUEST['save_inbox'];
				$save_trash = $_REQUEST['save_trash'];
				$save_sent = $_REQUEST['save_sent'];
				
				savePreferences($_SESSION['user_id'], $notify_email, $save_inbox, $save_trash, $save_sent);
				$inform['success'] = "Your preferences have been saved.";
			}
			
		} else if($_REQUEST['action'] == "button") {
			if(isset($_REQUEST['box_id'])) {
				$box_id = $_REQUEST['box_id'];
				deleteBox($_SESSION['user_id'], $box_id);
			
				$inform['success'] = "Box deleted successfully.";
			} else if($_REQUEST['name']!="") {
				$box_name = $_REQUEST['name'];
				$res = addBox($_SESSION['user_id'], $box_name);
				if($res !== false) {
					$inform['success'] = "New box $box_name added successfully.";
				} else {
					$inform['error'] = "Invalid box name $box_name! Already in Use!";
				}
			} else {
					$inform['warn'] = "Please enter a valid box name!";
			}
		} else if($_REQUEST['action'] == "send") {
			if(isset($_REQUEST['to']) && isset($_REQUEST['subject']) && isset($_REQUEST['body'])) {
				$inform['warn'] = "";
				$to = explode(",", $_REQUEST['to']);
				$subject = $_REQUEST['subject'];
				$body = $_REQUEST['body'];
				
				$to_uids = array();
				
				foreach($to as $to_i) {
					$uid = getUserId(trim($to_i));
					
					if($uid === FALSE) {
						$inform['warn'] = "Could not find user with username: " . $to_i;
						$view = "compose";
					} else {
						array_push($to_uids, $uid);
					}
				}
				
				foreach($to_uids as $to_i) {
					sendMessage($_SESSION['user_id'], $to_i, $subject, $body);
				}
				
				if($inform['warn'] == "") {
					unset($inform['warn']);
					$inform['success'] = "Message sent successfully.";
				}
			}
		} else if($_REQUEST['action'] == "delete") {
			if (isset($_POST['index'])) {
				if(count($_POST['index'])) {
					foreach ($_POST['index'] AS $id) {
						boxDeleteMessage($_SESSION['user_id'], $_POST['box_id'], $id);
					}
					if(count($_POST['index']) > 1) {
					$inform["success"] = "Deleted <b>" . count($_POST['index']) . "</b> messages!";
					} else {
					$inform["success"] = "Deleted <b>" . count($_POST['index']) . "</b> message!";
					}
				} else {
					$inform['warn'] = "Select messages you would like to delete!";
				}
			}  else {
				$inform['warn'] = "Select messages you would like to delete!";
			}  
		} else if($_REQUEST['action']) {
			if (isset($_POST['index'])) {
				if(count($_POST['index'])) {
					foreach ($_POST['index'] AS $id) {
						boxMoveMessage($_SESSION['user_id'], $id,  $_POST['box_id'], $_POST['action']);
					}
					if(count($_POST['index']) > 1) {
					$inform["success"] = "Moved <b>" . count($_POST['index']) . "</b> messages!";
					} else {
					$inform["success"] = "Moved <b>" . count($_POST['index']) . "</b> message!";
					}
				} else {
					$inform['warn'] = "Select messages you would like to move!";
				}
			}  else {
				$inform['warn'] = "Select messages you would like to move!";
			}  
		}
	}
	
	//for preferences and Boxes
	$prefs = retrievePreferences($_SESSION['user_id']);

	//for boxes
	$boxes = retrieveBoxList($_SESSION['user_id']);
	$message_boxes = array();
	$message_data = array();
	foreach($boxes as $box) {
		$box_id = $box[0];
		$box_name = $box[1];
		$messages = retrieveMessageList($_SESSION['user_id'], $box_id);
		$message_boxes[$box_id] = $messages;
		foreach($messages as $mess) {
			$message_data[$mess[0]] = retrieveMessage($_SESSION['user_id'], $box_id, $mess[0]);
		}
	}
	
	//for compose
	$reciever = "";
	if(isset($_REQUEST['target'])) {
		$reciever = $_REQUEST['target'];
	}
	
	get_page_advanced("messaging", "apply", array('boxes' => $boxes, 'messages' => $message_boxes, 'message_details' => $message_data, 'reciever' => $reciever, 'prefs' => $prefs,  "inform" => $inform));
	
} else {
	get_page_advanced("message", "apply", array("title" => "Not Logged In", "message" => "You cannot access the application because you are not logged in. Please <a href=\"../login.php\">login first</a>."));
}

?>
