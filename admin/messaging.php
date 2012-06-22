<?php
include("../config.php");
include("../include/common.php");
include("../include/db_connect.php");
include("../include/session.php");

include("../include/messaging.php");
include("../include/subscribe.php");

if(isset($_SESSION['admin'])) {
	$club_id = $_SESSION['admin_club_id'];
	
	$success = '';
	$error = '';
	
	if(isset($_REQUEST['target']) && isset($_REQUEST['subject']) && isset($_REQUEST['body'])) {
		$result = sendAdminGroupMessage($_SESSION['user_id'], $club_id, $_REQUEST['target'], $_REQUEST['subject'], $_REQUEST['body']);
		
		if($result === 1) {
			$error = "Your message could not be sent: internal server error.";
		} else if($result === 2) {
			$error = "Your message could not be sent: you specified an invalid target.";
		} else if($result === 3) {
			$error = "Your message could not be sent: you are not an administrator!";
			session_unset();
		} else {
			$success = "Your message has been sent.";
		}
	}
	
	$param = array();
	
	if($success != '') {
		$param['success'] = $success;
	}
	
	if($error != '') {
		$param['error'] = $error;
	}
	
	get_page_advanced("messaging", "admin", $param);
} else {
	header('Location: index.php');
}
?>
