<?php
include("../include/common.php");
include("../config.php");
include("../include/db_connect.php");
include("../include/session.php");

include("../include/apply_gen.php");
include("../include/apply_submit.php");
include("../include/subscribe.php");

if(isset($_SESSION['user_id'])) {
	$inform = array();
	if(isset($_POST['club_id'])) {
		$club_data = clubInfo($_POST['club_id']);
		$club_name = $club_data[0];
		if(isset($_POST['sub'])) {
			if($_POST['sub']=="on") {
				$out = removeSubscription($_SESSION['user_id'], $_POST['club_id']);
				$inform["success"] = "Unsubscribed from $club_name! You will <b>NOT</b> recieve messages from $club_name";
			} else if($_POST['sub']=="off") {
				$out = addSubscription($_SESSION['user_id'], $_POST['club_id']);
				$inform["success"] = "Subscribed to $club_name! You will now recieve messages from $club_name";
			}
		} else if(isset($_POST['app'])) {
			if($_POST['app']=="on") {
				$out = deleteApplication($_SESSION['user_id'], $_POST['club_id']);
				if($out == 0) {
					$inform["success"] = "Deleted application for $club_name!";
				} else if($out == -1) {
					$inform["warn"] = "You have not started the application for $club_name";
				} else if($out == -2) {
					$inform["error"] = "This club does not exist!";
				}
			} else if($_POST['app']=="off") {
				$out = startApplication($_SESSION['user_id'], $_POST['club_id']);
				if($out == 0) {
					$inform["success"] = "Started application for $club_name!";
				} else if($out == -1) {
					$inform["warn"] = "You have already started the application for $club_name";
				} else if($out == -2) {
					$inform["error"] = "This club does not exist!";
				} else if($out == -3) {
					$inform["error"] = "$club_name is not open yet! Try again after the open date!";
				}
			}
		}
	}
	
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

	get_page_advanced("clubs", "apply", array("clubs" => $clubsArray, "inform" => $inform));
} else {
	get_page_advanced("message", "apply", array("title" => "Not Logged In", "message" => "You cannot access the application because you are not logged in. Please <a href=\"../login.php\">login first</a>.", "redirect" => "../login.php"));
}
?>
