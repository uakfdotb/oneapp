<?php
include("include/common.php");
include("config.php");
include("include/db_connect.php");
include("include/session.php");

include("include/reset.php");

if(isset($_SESSION['user_id'])) {
	get_page("message", array("title" => "Logged In", "message" => "You are already logged in! Click <a href=\"application/\">here</a> to continue."));
} else if(isset($_REQUEST['email'])) {
	$result = resetRequest('', $_REQUEST['email'], false); //false to specify we are asking for username
	
	if($result == 0) { //request successful
		get_page("message", array("title" => "Check your email", "message" => "Your username has been sent to the email address provided."));
	} else if($result == 1) {
		get_page("message", array("title" => "Error", "message" => "No user found with that email address!"));
	} else if($result == 2) {
		get_page("message", array("title" => "Error", "message" => "A reset request has been recently sent. Check your email and find those details or wait for the current reset request to expire."));
	}
} else {
	get_page("forgotusername");
}

?>
