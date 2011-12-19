<?php
include("../include/common.php");
include("../config.php");
include("../include/db_connect.php");
include("../include/session.php");

if(isset($_SESSION['user_id'])) {
	if(isset($_REQUEST['app_id']) && isset($_REQUEST['club_id'])) {
		$club_id = $_REQUEST['club_id'];
		$app_id = $_REQUEST['app_id'];
		
		$clubInfo = clubInfo($club_id);
		get_page_apply("club_detail", array("club_id" => $club_id, "app_id" => $app_id, "clubInfo" => $clubInfo));
	} else {
		get_page_apply("message", array("title" => "Internal error", "message" => "Internal error: app_id or club_id unspecified."));
	}
} else {
	get_page_apply("message", array("title" => "Not Logged In", "message" => "You cannot access the application because you are not logged in. Please <a href=\"../login.php\">login first</a>."));
}

?>
