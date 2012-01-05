<?php
include("../include/common.php");
include("../config.php");
include("../include/db_connect.php");
include("../include/session.php");

if(isset($_SESSION['user_id'])) {
	$profile = getProfile($_SESSION['user_id']);
	$userInfo = getUserInformation($_SESSION['user_id']);
	
	if(isset($_POST['old_password']) && isset($_POST['new_password']) && isset($_POST['new_password_conf']) && isset($_POST['new_email'])) {
		$result = updateAccount($_SESSION['user_id'], $_POST['old_password'], $_POST['new_password'], $_POST['new_password_conf'], $_POST['new_email']);
		
		if($result === 0) {
			get_page_advanced("account", "apply", array("profile" => $profile, "userInfo" => $userInfo, "message" => "Account updated successfully."));
		} else if($result == -1) {
			get_page_advanced("account", "apply", array("profile" => $profile, "userInfo" => $userInfo, "message" => "Invalid password for old password supplied. Information was not changed."));
		} else if($result == -2) {
			get_page_advanced("account", "apply", array("profile" => $profile, "userInfo" => $userInfo, "message" => "Action attempted too many times. Please try again later."));
		} else if($result == 1) {
			get_page_advanced("account", "apply", array("profile" => $profile, "userInfo" => $userInfo, "message" => "New password is too short (less than six characters)."));
		} else if($result == 10) {
			get_page_advanced("account", "apply", array("profile" => $profile, "userInfo" => $userInfo, "message" => "New email address is invalid."));
		} else if($result == 11) {
			get_page_advanced("account", "apply", array("profile" => $profile, "userInfo" => $userInfo, "message" => "New passwords do not match."));
		}
	} else {
		get_page_advanced("account", "apply", array("profile" => $profile, "userInfo" => $userInfo));
	}
} else {
	get_page_advanced("message", "apply", array("title" => "Not Logged In", "message" => "You cannot access the application because you are not logged in. Please <a href=\"../login.php\">login first</a>."));
}

?>
