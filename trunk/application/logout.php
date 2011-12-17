<?php
include("../include/common.php");
include("../config.php");
include("../include/db_connect.php");
include("../include/session.php");

if(isset($_SESSION['user_id'])) {
	unset($_SESSION['user_id']);
	get_page_apply("message", array("title" => "Logged out", "message" => "You have been logged out. Click <a href=\"../\">here</a> to continue."));
} else {
	get_page_apply("message", array("title" => "Not Logged In", "message" => "You are not logged in, so there is no reason to log out. Click <a href=\"../\">here</a> to continue."));
}

?>
