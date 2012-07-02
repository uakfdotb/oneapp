<?php
include("../include/common.php");
include("../config.php");
include("../include/db_connect.php");
include("../include/session.php");

include("../include/messaging.php");

if(isset($_SESSION['user_id'])) {
	if(isset($_REQUEST['view'])) {
		$view = $_REQUEST['view'];
	} else {
		$view = "none";
	}
	
	$box_id = -1;
	$message_id = -1;
	$contents = "";
	$prefs = 0;
	$boxes = 0;
	
	if(isset($_REQUEST['action'])) {
		if($_REQUEST['action'] == "prefs") {
			if(isset($_REQUEST['save_inbox']) && isset($_REQUEST['save_trash']) && isset($_REQUEST['save_sent'])) {
				$notify_email = (isset($_REQUEST['notify_email']) && $_REQUEST['notify_email'] == "yes") ? 1 : 0;
				$save_inbox = $_REQUEST['save_inbox'];
				$save_trash = $_REQUEST['save_trash'];
				$save_sent = $_REQUEST['save_sent'];
				
				savePreferences($_SESSION['user_id'], $notify_email, $save_inbox, $save_trash, $save_sent);
				$success = "Your preferences have been saved.";
			}
			
			$view = "prefs";
		} else if($_REQUEST['action'] == "deletebox") {
			$box_id = $_REQUEST['box_id'];
			deleteBox($_SESSION['user_id'], $box_id);
			
			$success = "Box deleted successfully.";
			$view = "prefs";
		} else if($_REQUEST['action'] == "addbox") {
			$box_name = $_REQUEST['name'];
			addBox($_SESSION['user_id'], $box_name);
			
			$success = "Box added successfully.";
			$view = "prefs";
		} else if($_REQUEST['action'] == "send") {
			if(isset($_REQUEST['to']) && isset($_REQUEST['subject']) && isset($_REQUEST['body'])) {
				$to = explode(",", $_REQUEST['to']);
				$subject = $_REQUEST['subject'];
				$body = $_REQUEST['body'];
				
				$to_uids = array();
				
				foreach($to as $to_i) {
					$uid = getUserId(trim($to_i));
					
					if($uid === FALSE) {
						$error = "Could not find user with username: " . $to_i;
						$view = "compose";
					} else {
						array_push($to_uids, $uid);
					}
				}
				
				foreach($to_uids as $to_i) {
					sendMessage($_SESSION['user_id'], $to_i, $subject, $body);
				}
				
				if($error == "") {
					$success = "Message sent successfully.";
				}
			}
		}
	}
	
	if($view != "compose" && $view != "box" && $view != "prefs" && $view != "message") {
		$view = "none";
	} else if($view == "box") {
		if(isset($_REQUEST['box_id'])) {
			$box_id = $_REQUEST['box_id'];
		} else {
			$box_id = getDefaultBox($_SESSION['user_id']);
		}
		
		if(openBox($_SESSION['user_id'], $box_id)) {
			$contents = retrieveMessageList($_SESSION['user_id'], $box_id);
			$boxes = retrieveBoxList($_SESSION['user_id']);
		} else {
			$view = "none";
		}
	} else if($view == "message") {
		if(isset($_REQUEST['box_id']) && isset($_REQUEST['message_id'])) {
			$box_id = $_REQUEST['box_id'];
			$message_id = $_REQUEST['message_id'];
			
			if(openBox($_SESSION['user_id'], $box_id)) {
				$contents = retrieveMessage($_SESSION['user_id'], $box_id, $message_id);
				
				if($contents === FALSE) {
					$view = "none";
				}
			} else {
				$view = "none";
			}
		} else {
			$view = "none";
		}
	} else if($view == "compose") {
		if(isset($_REQUEST['target'])) {
			$contents = $_REQUEST['target'];
		}
	} else if($view == "prefs") {
		$prefs = retrievePreferences($_SESSION['user_id']);
		$boxes = retrieveBoxList($_SESSION['user_id']);
	}
	
	if(isset($error)) {
		get_page_advanced("messaging", "apply", array('view' => $view, 'box_id' => $box_id, 'message_id' => $message_id, 'contents' => $contents, 'prefs' => $prefs, 'boxes' => $boxes, 'error' => $error));
	} else if(isset($success)) {
		get_page_advanced("messaging", "apply", array('view' => $view, 'box_id' => $box_id, 'message_id' => $message_id, 'contents' => $contents, 'prefs' => $prefs, 'boxes' => $boxes, 'success' => $success));
	} else {
		get_page_advanced("messaging", "apply", array('view' => $view, 'box_id' => $box_id, 'message_id' => $message_id, 'contents' => $contents, 'prefs' => $prefs, 'boxes' => $boxes));
	}
} else {
	get_page_advanced("message", "apply", array("title" => "Not Logged In", "message" => "You cannot access the application because you are not logged in. Please <a href=\"../login.php\">login first</a>."));
}

?>
