<?php
include("../config.php");
include("../include/common.php");
include("../include/db_connect.php");
include("../include/session.php");

include("../include/statistics.php");

if(isset($_SESSION['root'])) {
	if(isset($_REQUEST['club_id']) && isset($_REQUEST['club_name'])) {
		$stat_array = clubApplicationList($_REQUEST['club_id']);
		get_page_advanced("statistics_club_details", "root", array('stat_array' => $stat_array, 'club_id' => $_REQUEST['club_id'], 'club_name' => $_REQUEST['club_name']));
	} else {
		$stat_array = clubStatistics();
		get_page_advanced("statistics_club", "root", array('stat_array' => $stat_array));
	}
} else {
	header('Location: index.php');
}
?>
