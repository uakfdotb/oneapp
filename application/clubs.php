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
	
	$clubStart = array();
	$clubClose = array();
	
	foreach($clubsApplied as $item) {
		$clubInfo = clubInfo($item[0]);
		$clubStart[$item[0]] = $clubInfo[2];
		$clubClose[$item[0]] = $clubInfo[3];
	}

	get_page_advanced("clubs", "apply", array("clubsApplied" => $clubsApplied, 'clubStates' => $clubStates, 'clubStart' => $clubStart, 'clubClose' => $clubClose));
} else {
	get_page_advanced("message", "apply", array("title" => "Not Logged In", "message" => "You cannot access the application because you are not logged in. Please <a href=\"../login.php\">login first</a>."));
}
?>
