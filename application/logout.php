<?php
include("../include/common.php");
include("../config.php");
include("../include/db_connect.php");
include("../include/session.php");

if(isset($_SESSION['user_id'])) {
	session_unset();
	get_page_advanced("message", "apply", array("title" => "Logged out", "message" => "You have been logged out. Click <a href=\"../\">here</a> to continue."));
} else {
	get_page_advanced("message", "apply", array("title" => "Not Logged In", "message" => "You are not logged in, so there is no reason to log out. Click <a href=\"../\">here</a> to continue."));
}

?>
