<?php
include("include/common.php");
include("config.php");
include("include/db_connect.php");
include("include/session.php");

include("include/reset.php");

if(isset($_SESSION['user_id'])) {
	$inform["info"] = "You are already logged in!";
	get_page("reset", array("message" => "<a href=\"application/\">Click here</a> if you are not redirected.", "redirect" => "application/"));
} else if(isset($_REQUEST['username']) && isset($_REQUEST['email'])) {
	if(isset($_REQUEST['auth']) && isset($_REQUEST['user_id'])) {
		$check = resetCheck($_REQUEST['username'], $_REQUEST['email'], $_REQUEST['auth'], $_REQUEST['user_id']);
		
		if(isset($_REQUEST['password']) && isset($_REQUEST['password_confirm'])) {
			if($_REQUEST['password'] == $_REQUEST['password_confirm']) {
				resetPassword($_REQUEST['user_id'], $_REQUEST['password']);
				$inform["success"] = "Your password has been reset! Log in now!";
				get_page("login", array("inform" => $inform));
			} else {
				$inform["error"] = "The passwords do not match!";
				get_page("reset", array("inform" => $inform));
			}
		} else {
			get_page("reset_password", array("username" => $_REQUEST['username'], "email" => $_REQUEST['email'], "auth" => $_REQUEST['auth'], "user_id" => $_REQUEST['user_id']));
		}
	} else {
		$result = resetRequest($_REQUEST['username'], $_REQUEST['email']);
		$inform = array();
		if($result == 0) { //request successful
			$inform["success"] = "Details on how to reset your password have been sent to " . $_REQUEST['email'] . "!";
		} else if($result == 1) {
			$inform["error"] = "No user found with the information provided!";
		} else if($result == 2) {
			$inform["warn"] = "A reset request has been recently sent. Check your email and find those details or wait for the current reset request to expire.";
		}
		get_page("reset_form", array("inform" => $inform));
	}
} else {
	get_page("reset_form");
}

?>
