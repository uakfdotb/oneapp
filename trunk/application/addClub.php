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
	if(isset($_REQUEST['club']) && isset($_REQUEST['mode'])) {
		$club_data = clubInfo($_REQUEST['club']);
		$club_name = $club_data[0];
		if($_REQUEST['mode'] == "apply") {
			$result = startApplication($_SESSION['user_id'], $_REQUEST['club']);
		
			if($result == 0) {
				$inform["success"] = "Started application for $club_name!";
			} else if($result == -1) {
					$inform["warn"] = "You have already started the application for $club_name";
			} else if($result == -2) {
					$inform["error"] = "This club does not exist!";
			} else if($result == -3) {
					$inform["error"] = "$club_name is not open yet! Try again after the open date!";
			} else {
					$inform["error"] = "Internal error!";
			}
		} else {
			addSubscription($_SESSION['user_id'], $_REQUEST['club']);
			$inform["success"] = "Subscribed to $club_name! You will now recieve messages from $club_name";
		}
	}
	
	$clubList = listClubs();
	get_page_advanced("addclub", "apply", array("clubs" => $clubList, "inform" => $inform));

} else {
	get_page_advanced("message", "apply", array("title" => "Not Logged In", "message" => "You cannot access the application because you are not logged in. Please <a href=\"../login.php\">login first</a>."));
}

?>
