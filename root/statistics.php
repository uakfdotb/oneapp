<?php
include("../config.php");
include("../include/common.php");
include("../include/db_connect.php");
include("../include/session.php");

include("../include/statistics.php");

if(isset($_SESSION['root'])) {
	$stat_array = calculateStatistics();
	get_page_advanced("statistics", "root", array('stat_array' => $stat_array));
}
?>
