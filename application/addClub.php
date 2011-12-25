<?php
include("../include/common.php");
include("../config.php");
include("../include/db_connect.php");
include("../include/session.php");

include("../include/apply_gen.php");
include("../include/apply_submit.php");

if(isset($_SESSION['user_id'])) {
	if(isset($_REQUEST['club'])) {
		$result = startApplication($_SESSION['user_id'], $_REQUEST['club']);
		
		if($result == 0) {
			get_page_apply("message", array("title" => "Club added successfully", "message" => "The requested club has been added successfully. You can view the <a href=\"clubs.php\">list of clubs</a> you are applying to or <a href=\"addClub.php\">add another club</a>."));
		} else if($result == -1) {
			get_page_apply("message", array("title" => "Addition failed", "message" => "This club has already been added. Click <a href=\"clubs.php\">here</a> to return to the list of clubs you are applying to."));
		} else if($result == -2) {
			get_page_apply("message", array("title" => "Addition failed", "message" => "The specified club does not exist. Click <a href=\"clubs.php\">here</a> to return to the list of clubs you are applying to."));
		} else if($result == -3) {
			get_page_apply("message", array("title" => "Addition failed", "message" => "The club is not available at this time. Click <a href=\"clubs.php\">here</a> to return to the list of clubs you are applying to."));
		} else {
			get_page_apply("message", array("title" => "Addition failed", "message" => "There was an error while adding a club: $result. Click <a href=\"clubs.php\">here</a> to return to the list of clubs you are applying to."));
		}
	} else {
		$clubList = listClubs();
		get_page_apply("addclub", array("clubs" => $clubList));
	}
} else {
	get_page_apply("message", array("title" => "Not Logged In", "message" => "You cannot access the application because you are not logged in. Please <a href=\"../login.php\">login first</a>."));
}

?>
