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
		
		//submit without actually submitting to get the PDFs
		$result = submitApplication($_SESSION['user_id'], $app_id, false);
		if(is_array($result)) {
			get_page_advanced("preview", "apply", array('pdf_array' => $result));
		} else {
			get_page_advanced("message", "apply", array('title' => "Error", 'message' => 'There was an error while generating the preview: ' . $result));
		}
	} else {
		get_page_advanced("message", "apply", array("title" => "Internal error", "message" => "Internal error: app_id or club_id unspecified."));
	}
} else {
	get_page_advanced("message", "apply", array("title" => "Not Logged In", "message" => "You cannot access the application because you are not logged in. Please <a href=\"../login.php\">login first</a>."));
}

?>
