<?php
include("../include/common.php");
include("../config.php");
include("../include/db_connect.php");
include("../include/session.php");

if(isset($_SESSION['user_id'])) {
	$profile = getProfile();
	
	if(isset($_POST['old_password']) && isset($_POST['new_password']) && isset($_POST['new_password_conf']) && isset($_POST['new_email'])) {
		$result = updateAccount($_SESSION['user_id'], $_POST['old_password'], $_POST['new_password'], $_POST['new_password_conf'], $_POST['new_email']);
		
		if($result === 0) {
			get_page_apply("account", array("profile" => $profile));
		} else if($result == -1) {
			get_page_apply("account", array("profile" => $profile, "error" => "Invalid password for old paswsord supplied. Information was not changed.");
		} else if($result == -2) {
			get_page_apply("account", array("profile" => $profile, "error" => "Action attempted too many times. Please try again later."));
		} else if($result == 1) {
			get_page_apply("account", array("profile" => $profile, "error" => "New password is too short (less than six characters)."));
		} else if($result == 10) {
			get_page_apply("account", array("profile" => $profile, "error" => "New email address is invalid."));
		} else if($result == 11) {
			get_page_apply("account", array("profile" => $profile, "error" => "New passwords do not match."));
		}
	} else {
		get_page_apply("account", array("profile" => $profile));
	}
} else {
	get_page("message", array("stylepath" => "../style", "title" => "Not Logged In", "message" => "You cannot access the application because you are not logged in. Please <a href=\"../login.php\">login first</a>."));
}

?>
