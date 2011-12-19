<?php
include("../include/common.php");
include("../config.php");
include("../include/db_connect.php");
include("../include/session.php");

include("../include/apply_gen.php");
include("../include/apply_submit.php");
include("../include/latex.php");

if(isset($_SESSION['user_id'])) {
	if(isset($_REQUEST['app_id']) && isset($_REQUEST['club_id'])) {
		$club_id = $_REQUEST['club_id'];
		$app_id = $_REQUEST['app_id'];
		
		if($club_id != 0) { //cannot submit general application
			//check for errors in general application and supplement
			$gen_app_id = getApplicationByUserClub($_SESSION['user_id'], 0);
			
			$genCheck = checkCompletedApplication($_SESSION['user_id'], 0, $gen_app_id);
			$appCheck = checkCompletedApplication($_SESSION['user_id'], $club_id, $app_id);
			
			if(count($appCheck) == 0 && count($genCheck) == 0) {
				if(isset($_REQUEST['confirm'])) { //require confirmation before final submission
					$result = submitApplication($_SESSION['user_id'], $app_id);
					
					if($result === TRUE) { //true on success, string on failure
						get_page_apply("message", array("title" => "Application submission", "message" => "Application submitted successfully"));
					} else {
						get_page_apply("message", array("title" => "Application submission", "message" => "There was an error while submitting your application: " . $result));
					}
				} else {
					get_page_apply("submit_confirm", array("club_id" => $club_id, "app_id" => $app_id));
				}
			} else {
				get_page_apply("submit_warnings", array("genCheck" => $genCheck, "appCheck" => $appCheck));
			}
		} else {
			get_page_apply("message", array("title" => "Error", "message" => "Error: you cannot submit the general application. Instead, go to the clubs page, select a club, and then press submit. This will submit your general application and supplement, if any, to the club."));
		}
	} else {
		get_page_apply("message", array("title" => "Internal error", "message" => "Internal error: app_id or club_id unspecified."));
	}
} else {
	get_page_apply("message", array("title" => "Not Logged In", "message" => "You cannot access the application because you are not logged in. Please <a href=\"../login.php\">login first</a>."));
}

?>
