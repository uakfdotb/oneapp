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
		} else if($_REQUEST['action'] == "submit" && isset($_REQUEST['app_id'])) {
			$data = processSubmission($_REQUEST);
			$data += processFileSubmission($_FILES);
			$result = saveApplication($_SESSION['user_id'], $_REQUEST['app_id'], $data);
			$applicationId = $_REQUEST['app_id'];
			
			if($result === TRUE) {
				$inform["success"] = "Your application to has been saved!";
			} else {
				$inform["error"] = "Sorry! There seems to have been some error while saving your application.";
				$inform["detail"] = $result;
			}
		} else {
			echo $_REQUEST['action'] . "<br />";
		}
					
			if($applicationId !== FALSE) {
				$inform["info"] = "Be sure to save often!";
				if($_REQUEST['club_id'] == 0) {
					if(isset($_REQUEST['cat_id'])) {
						$cat_name = getCategory($_REQUEST['cat_id']);
					
						$title = "General Application > $cat_name";
						get_page_advanced("app", "apply", array("user_id" => $_SESSION['user_id'], "app_id" => $applicationId, "club_id" => $_REQUEST['club_id'], "cat_id" => $_REQUEST['cat_id'], "action" => "view" , "title" => $title, "inform" => $inform));
					} else {
				get_page_advanced("message", "apply", array("title" => "Internal error", "message" => "Internal error: application not found."));
					}
				} else {
					$club_data = clubInfo($_REQUEST['club_id']);
					$club_name = $club_data[0];
					
					$title = "Supplement > $club_name";
					get_page_advanced("app", "apply", array("user_id" => $_SESSION['user_id'], "app_id" => $applicationId, "club_id" => $_REQUEST['club_id'], "title" => $title, "inform" => $inform));
				}
			} else {
				get_page_advanced("message", "apply", array("title" => "Internal error", "message" => "Internal error: application not found."));
			}
		
	} else {
		get_page_advanced("message", "apply", array("title" => "Internal error", "message" => "Internal error: club ID or action not specified."));
	}
} else {
	get_page_advanced("message", "apply", array("title" => "Not Logged In", "message" => "You cannot access the application because you are not logged in. Please <a href=\"../login.php\">login first</a>."));
}

?>
