<?php
include("../include/common.php");
include("../config.php");
include("../include/db_connect.php");
include("../include/session.php");

include("../include/apply_gen.php");

if(isset($_SESSION['user_id'])) {
	if(isset($_REQUEST['app_id']) && isset($_REQUEST['club_id'])) {
		$club_id = $_REQUEST['club_id'];
		$app_id = $_REQUEST['app_id'];
		
		$clubInfo = clubInfo($club_id);
		//passed to page, and also used to validate ownership of application
		$checkStatus = checkApplication($_SESSION['user_id'], $app_id);
		
		if($checkStatus != -2) {
			get_page_advanced("club_detail", "apply", array("club_id" => $club_id, "app_id" => $app_id, "clubInfo" => $clubInfo, 'checkStatus' => $checkStatus));
		} else {
			get_page_advanced("message", "apply", array("title" => "Internal error", "message" => "Internal error: application does not appear to belong to the requesting user."));
		}
	} else {
		get_page_advanced("message", "apply", array("title" => "Internal error", "message" => "Internal error: app_id or club_id unspecified."));
	}
} else {
	get_page_advanced("message", "apply", array("title" => "Not Logged In", "message" => "You cannot access the application because you are not logged in. Please <a href=\"../login.php\">login first</a>."));
}

?>
