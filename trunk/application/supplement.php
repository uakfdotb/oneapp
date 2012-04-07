<?php
include("../include/common.php");
include("../config.php");
include("../include/db_connect.php");
include("../include/session.php");

include("../include/apply_submit.php");

if(isset($_SESSION['user_id'])) {
	$clubsApplied = getUserClubsApplied($_SESSION['user_id']);
	if(count($clubsApplied)==0) $info="You have not added any clubs!";
	if(isset($info)){
		get_page_advanced("supplement", "apply", array("clubsApplied" => $clubsApplied, "info" => $info));
	} else {
		get_page_advanced("supplement", "apply", array("clubsApplied" => $clubsApplied));
	}
} else {
	get_page_advanced("message", "apply", array("title" => "Not Logged In", "message" => "You cannot access the application because you are not logged in. Please <a href=\"../login.php\">login first</a>."));
}

?>
