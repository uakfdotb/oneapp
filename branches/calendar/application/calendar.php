<?php
include("../include/common.php");
include("../config.php");
include("../include/db_connect.php");
include("../include/session.php");

include("../include/apply_gen.php");
include("../include/apply_submit.php");
include("../include/subscribe.php");
include("../include/custom.php");
include("../include/calendar.php");

if(isset($_SESSION['user_id'])) {
	$mode = "list";
	$timeStart = getDayTime();
	$timeEnd = getDayTime(time(), 7);
	
	if(isset($_REQUEST['mode']) && ($_REQUEST['mode'] == "list" || $_REQUEST['mode'] == "month")) {
		$mode = $_REQUEST['mode'];
	}
	
	if(isset($_REQUEST['time_start'])) {
		$timeStart = getDayTime(int($_REQUEST['time_start']));
		$timeEnd = getDayTime(int($_REQUEST['time_start']), 7);
	}
	
	if(isset($_REQUEST['duration'])) {
		$timeEnd = getDayTime($timeStart, int($_REQUEST['duration']));
	}
	
	$clubs = listSubscriptions($_SESSION['user_id']);
	$events = getEvents($timeStart, $timeEnd, $clubs);
	
	get_page_advanced("calendar", "apply", array('mode' => $mode, 'events' => $events));
} else {
	get_page_advanced("message", "apply", array("title" => "Not Logged In", "message" => "You cannot access the application because you are not logged in. Please <a href=\"../login.php\">login first</a>."));
}

?>
