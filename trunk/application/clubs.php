<?php
include("../include/common.php");
include("../config.php");
include("../include/db_connect.php");
include("../include/session.php");

include("../include/apply_gen.php");

if(isset($_SESSION['user_id'])) {
	$clubsApplied = getUserClubsApplied($_SESSION['user_id']);
	
	$clubStates = array(); //maps from club id to state string
	foreach($clubsApplied as $item) {
		$clubStates[$item[0]] = getApplicationStateString($_SESSION['user_id'], $item[3]);
	}
	
	get_page_advanced("clubs", "apply", array("clubsApplied" => $clubsApplied, 'clubStates' => $clubStates));
} else {
	get_page_advanced("message", "apply", array("title" => "Not Logged In", "message" => "You cannot access the application because you are not logged in. Please <a href=\"../login.php\">login first</a>."));
}

?>
