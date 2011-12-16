<?php
include("../include/common.php");
include("../config.php");
include("../include/db_connect.php");
include("../include/session.php");

if(isset($_SESSION['user_id'])) {
	get_page_apply("index");
} else {
	get_page("message", array("stylepath" => "../style", "title" => "Not Logged In", "message" => "You cannot access the application because you are not logged in. Please <a href=\"../login.php\">login first</a>."));
}

?>
