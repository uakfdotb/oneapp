<?php
include("../config.php");
include("../include/common.php");
include("../include/db_connect.php");
include("../include/session.php");

include("../include/statistics.php");

get_root_header();

if(isset($_SESSION['root'])) {
	$stat_array = calculateStatistics();
	
	echo "<table><tr><th><p class=\"admin_table_header\">Name</p></th><th><p class=\"admin_table_header\">Value</p></th></tr>";
	
	foreach($stat_array as $name => $value) {
		echo "<tr>";
		echo "<td><p>$name</p></td>";
		echo "<td><p>$value</p></td>";
		echo "</tr>";
	}
	
	echo "</table>";
}

get_root_footer();
?>
