<?php
include("../config.php");
include("../include/common.php");
include("../include/db_connect.php");
include("../include/session.php");

include("../include/subscribe.php");

if(isset($_SESSION['admin'])) {
	$club_id = $_SESSION['admin_club_id'];
	$user_id = $_SESSION['user_id'];
	
	if($club_id != 0) {
		$subscribers = listSubscriberInfo($club_id); //array of user_id => userInformation array (username, email, name)
		get_page_advanced("view_subscribe", "admin", array('subscribers' => $subscribers));
	} else {
		get_page_advanced("message", "admin", array('message' => "General application admin does not have a club to manage.", 'title' => "View submissions"));
	}
} else {
	header('Location: index.php?error=' . urlencode("You are not logged in!"));
}
?>
