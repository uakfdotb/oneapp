<?php
include("../include/common.php");
include("../config.php");
include("../include/db_connect.php");
include("../include/session.php");

include("../include/apply_submit.php");
include("../include/apply_gen.php");

if(isset($_SESSION['user_id'])) {
	if(isset($_REQUEST['club_id']) && isset($_REQUEST['action'])) {
		if(!isset($_REQUEST['cat_id'])) {
			$clubGet = "club_id=" . $_REQUEST['club_id'];
		} else {
			$clubGet = "club_id=" . $_REQUEST['club_id'] . "&cat_id=" . $_REQUEST['cat_id'];
		}
		
		if($_REQUEST['action'] == "view") {
			$applicationId = getApplication($_SESSION['user_id'], $_REQUEST['club_id']);
			
			if($applicationId !== FALSE) {
				if($_REQUEST['club_id'] == 0) {
					if(isset($_REQUEST['cat_id'])) {
						get_page_advanced("app", "apply", array("user_id" => $_SESSION['user_id'], "app_id" => $applicationId, "club_id" => $_REQUEST['club_id'], "cat_id" => $_REQUEST['cat_id']));
					}
				} else {
					get_page_advanced("app", "apply", array("user_id" => $_SESSION['user_id'], "app_id" => $applicationId, "club_id" => $_REQUEST['club_id']));
				}
			} else {
				get_page_advanced("message", "apply", array("title" => "Internal error", "message" => "Internal error: application not found."));
			}
		} else if($_REQUEST['action'] == "submit" && isset($_REQUEST['app_id'])) {
			$data = processSubmission($_REQUEST);
			$result = saveApplication($_SESSION['user_id'], $_REQUEST['app_id'], $data);
			get_page_advanced("message", "apply", array("title" => "Saved", "message" => "Your application has been saved. Click <a href=\"app.php?$clubGet&action=view\">here</a> to continue.", "redirect" => "app.php?$clubGet&action=view"));
		}
	} else {
		get_page_advanced("message", "apply", array("title" => "Internal error", "message" => "Internal error: club ID or action not specified."));
	}
} else {
	get_page_advanced("message", "apply", array("title" => "Not Logged In", "message" => "You cannot access the application because you are not logged in. Please <a href=\"../login.php\">login first</a>."));
}

?>
