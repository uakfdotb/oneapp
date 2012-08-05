<?php
include("include/common.php");
include("config.php");
include("include/db_connect.php");
include("include/session.php");

include("include/apply_gen.php");
include("include/apply_submit.php");
include("include/messaging.php");

if(isset($_SESSION['user_id'])) {
	$inform["info"] = "You are already logged in!";
	get_page("login", array("message" => "<a href=\"application/\">Click here</a> if you are not redirected.", "redirect" => "application/", "inform" => $inform));
} else if(isset($_REQUEST['username']) && isset($_REQUEST['password'])) {
	$inform = array();
	$result = checkLogin($_REQUEST['username'], $_REQUEST['password']);
	
	if($result >= 0) {
		$_SESSION['user_id'] = $result;
		$inform["success"] = "Successfully logged in!";
	} else if($result == -2) {
		$inform["error"] = "Incorrect username or password!";
		$inform["warn"] = "You are locked out for too many failed attempts! Please wait 2 minutes to try again!";
	} else if($result == -3) {
		$inform["warn"] = "Sorry! Login and Registration are currently closed! Contact your local manager!";
	} else if($result == -1) {
		$inform["error"] = "Inncorrect username or password!";
	} else {
		$inform["error"] = "Internal error! If this occurs again, contact us!";
	}
	if(isset($inform["success"])) {
		get_page("login", array("inform" => $inform, "redirect" => "application/"));
	} else {
		get_page("login", array("inform" => $inform));
	}
} else {
	$fields = getProfileFields();
	get_page("login_register", array("profile" => $fields));
}

?>
