<?php
include("../config.php");
include("../include/common.php");
include("../include/db_connect.php");
include("../include/session.php");

include("../include/apply_gen.php");

get_admin_header();

if(isset($_SESSION['admin_id'])) {
	$club_id = escape(getAdminClub($_SESSION['admin_id']));
	
	$database = "supplements";
	$whereString = "club_id = '$club_id'";
	
	if($club_id == 0) { //use category instead of club_id if we're dealing with the base application
		include("category_manager.php");
	}
	
	$result = mysql_query("SELECT varname, vardesc, vartype FROM $database WHERE $whereString ORDER BY orderId");

	<table>
	while($row = mysql_fetch_array($result)) {
		writeField(0, 0, $row['varname'], $row['vardesc'], $row['vartype']);
	}
	</table>

} else {
	header('Location: index.php?error=' . urlencode("You are not logged in!"));
}

get_admin_footer();
?>
