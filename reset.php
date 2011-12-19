<?php
include("include/common.php");
include("config.php");
include("include/db_connect.php");
include("include/session.php");

include("include/reset.php");

if(isset($_SESSION['user_id'])) {
	get_page("message", array("title" => "Logged In", "message" => "You are already logged in! Click <a href=\"application/\">here</a> to continue."));
} else if(isset($_REQUEST['username']) && isset($_REQUEST['email'])) {
	if(isset($_REQUEST['auth']) && isset($_REQUEST['user_id'])) {
		$check = resetCheck($_REQUEST['username'], $_REQUEST['email'], $_REQUEST['auth'], $_REQUEST['user_id']);
		
		if(isset($_REQUEST['password']) && isset($_REQUEST['password_confirm'])) {
			if($_REQUEST['password'] == $_REQUEST['password_confirm']) {
				resetPassword($_REQUEST['user_id'], $_REQUEST['password']);
				get_page("message", array("title" => "Password reset", "message" => "Your password has been reset. Click <a href=\"login.php\">here</a> to continue."));
			} else {
				get_page("message", array("title" => "Error", "message" => "The passwords entered do not match."));
			}
		} else {
			get_page("reset_password", array("username" => $_REQUEST['username'], "email" => $_REQUEST['email'], "auth" => $_REQUEST['auth'], "user_id" => $_REQUEST['user_id']));
		}
	} else {
		$result = resetRequest($_REQUEST['username'], $_REQUEST['email']);
		
		if($result == 0) { //request successful
			get_page("message", array("title" => "Check your email", "message" => "Details on how to reset your password have been sent to the email address provided."));
		} else if($result == 1) {
			get_page("message", array("title" => "Error", "message" => "No user found with that username and email address!"));
		} else if($result == 2) {
			get_page("message", array("title" => "Error", "message" => "A reset request has been recently sent. Check your email and find those details or wait for the current reset request to expire."));
		}
	}
} else {
	get_page("reset_form");
}

?>
