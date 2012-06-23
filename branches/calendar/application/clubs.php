<?php
include("../include/common.php");
include("../config.php");
include("../include/db_connect.php");
include("../include/session.php");

include("../include/apply_gen.php");
include("../include/subscribe.php");

if(isset($_SESSION['user_id'])) {
	$clubsSubscribed = listSubscriptions($_SESSION['user_id']);
	$clubsApplied = getUserClubsApplied($_SESSION['user_id']);
	
	//matrix maps from club id to array(subscribed?, applystate, applyinfo, clubinfo)
	$clubsArray = array();
	
	foreach($clubsSubscribed as $club_id) {
		$clubsArray[$club_id] = array(true, false, false, false);
	}
	
	foreach($clubsApplied as $club) {
		if(!isset($clubsArray[$club[0]])) {
			$clubsArray[$club[0]] = array(false, false, false, false);
		}
		
		$clubsArray[$club[0]][1] = checkApplication($_SESSION['user_id'], $club[3]);
		$clubsArray[$club[0]][2] = $club;
	}
	
	foreach(array_keys($clubsArray) as $club_id) {
		$clubsArray[$club_id][3] = clubInfo($club_id);
	}

	get_page_advanced("clubs", "apply", array("clubs" => $clubsArray));
} else {
	get_page_advanced("message", "apply", array("title" => "Not Logged In", "message" => "You cannot access the application because you are not logged in. Please <a href=\"../login.php\">login first</a>."));
}
?>
