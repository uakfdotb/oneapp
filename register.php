<?php
include("include/common.php");
include("config.php");
include("include/db_connect.php");
include("include/session.php");

include("include/apply_gen.php");
include("include/apply_submit.php");

if(isset($_SESSION['user_id'])) {
	get_page("message", array("title" => "Already Logged In", "message" => "You are already logged in! Click <a href=\"application/\">here</a> to continue.");
} else if(isset($_REQUEST['username']) && isset($_REQUEST['email'])) {
	$data = processSubmission($_REQUEST);
	$result = register($_REQUEST['username'], $_REQUEST['email'], $data);
	
	if($result == 0) {
		get_page("message", array("title" => "Registration successful", "message" => "Your account has been created. You should be receiving an email shortly with your login details (you should change your password immediately after logging into your account) and information on how to start your application. Click <a href=\"application/\">here</a> to continue.");
	} else if($result == 1) {
		get_page("message", array("title" => "Error", "message" => "Error: a submitted field is too short.");
	} else if($result == 3) {
		get_page("message", array("title" => "Error", "message" => "Error: email address invalid or in use.");
	} else if($result == 4) {
		get_page("message", array("title" => "Error", "message" => "Error: internal database error!");
	} else if($result == 5) {
		get_page("message", array("title" => "Error", "message" => "Error: username is already in use.");
	} else if($result == 6) {
		get_page("message", array("title" => "Error", "message" => "Error: while sending email. Please contact us to receive your login details.");
	} else if($result == 7) {
		get_page("message", array("title" => "Error", "message" => "Error: you have been locked out. Try again later, or contact us.");
	} else if($result == 8) {
		get_page("message", array("title" => "Error", "message" => "Error: registration is currently disabled.");
	} else {
		get_page("message", array("title" => "Error", "message" => "Error: internal error!");
	}
} else {
	$fields = getProfileFields();
	get_page("register", array("profile" => $fields));
}

?>
