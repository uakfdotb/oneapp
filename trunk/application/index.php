<?php
include("../include/common.php");
include("../config.php");
include("../include/db_connect.php");
include("../include/session.php");

if(isset($_SESSION['user_id'])) {
	header( 'Location: clubs.php' ) ;
} else {
	get_page_advanced("message", "apply", array("title" => "Not Logged In", "message" => "You cannot access the application because you are not logged in. Please <a href=\"../login.php\">login first</a>."));
}

?>
