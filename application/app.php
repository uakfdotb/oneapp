<?php
include("../include/common.php");
include("../config.php");
include("../include/db_connect.php");
include("../include/session.php");

include("../include/apply_submit.php");
include("../include/apply_gen.php");

if(isset($_SESSION['user_id'])) {
	if(isset($_REQUEST['club_id']) && isset($_REQUEST['action'])) {
		$clubGet = "club_id=" . $_REQUEST['club_id'];
		
		if($_REQUEST['action'] == "view") {
			$applicationId = getApplication($_SESSION['user_id', $_REQUEST['club_id']);
			
			if($applicationId !== FALSE) {
				if($club_id == 0) {
					if(isset($_REQUEST['cat_id'])) {
						writeApplication($_SESSION['user_id'], $applicationId, $_REQUEST['cat_id']);
					}
				} else {
					writeApplication($_SESSION['user_id'], $applicationId);
				}
			} else {
				get_page_apply("message", array("title" => "Internal error", "message" => "Internal error: application not found."));
			}
		} else if($_REQUEST['action'] == "submit" && isset($_REQUEST['app_id'])) {
			$data = processSubmision($_REQUEST);
			$result = saveApplication($_SESSION['user_id'], $_REQUEST['app_id'], $data);
			get_page_apply("message", array("title" => "Saved", "message" => "Your application has been saved. Click <a href\"app.php?$clubGet&action=view\">here</a> to continue."));
		}
	} else {
		get_page_apply("message", array("title" => "Internal error", "message" => "Internal error: club ID or action not specified."));
	}
} else {
	get_page_apply("message", array("title" => "Not Logged In", "message" => "You cannot access the application because you are not logged in. Please <a href=\"../login.php\">login first</a>."));
}

?>
