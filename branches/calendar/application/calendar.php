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
	
	if(isset($_REQUEST['mode']) && ($_REQUEST['mode'] == "list" || $_REQUEST['mode'] == "month" || $_REQUEST['mode'] == "reserve")) {
		$mode = $_REQUEST['mode'];
	}
	
	if(isset($_REQUEST['time_start'])) {
		$timeStart = getDayTime(intval($_REQUEST['time_start']));
		$timeEnd = getDayTime(intval($_REQUEST['time_start']), 7);
	}
	
	if(isset($_REQUEST['duration'])) {
		$timeEnd = getDayTime($timeStart, intval($_REQUEST['duration']));
	}
	
	if(isset($_REQUEST['time_end'])) {
		$timeEnd = getDayTime(intval($_REQUEST['time_end']));
	}
	
	$clubs = listSubscriptions($_SESSION['user_id']);
	$parameters = array('mode' => $mode, 'timeStart' => $timeStart, 'timeEnd' => $timeEnd);
	
	if($mode == "reserve") {
		$parameters['events'] = getReservations($timeStart, $timeEnd);
		$parameters['reservables'] = getReservables();
	} else {
		$parameters['events'] = getEvents($timeStart, $timeEnd, $clubs);
		$parameters['reservables'] = 0;
	}
	
	get_page_advanced("calendar", "apply", $parameters);
} else {
	get_page_advanced("message", "apply", array("title" => "Not Logged In", "message" => "You cannot access the application because you are not logged in. Please <a href=\"../login.php\">login first</a>."));
}

?>
