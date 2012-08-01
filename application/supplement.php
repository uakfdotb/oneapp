<?php
include("../include/common.php");
include("../config.php");
include("../include/db_connect.php");
include("../include/session.php");

include("../include/apply_submit.php");

if(isset($_SESSION['user_id'])) {
	$clubsApplied = getUserClubsApplied($_SESSION['user_id']);
	get_page_advanced("supplement", "apply", array("clubsApplied" => $clubsApplied));
} else {
	get_page_advanced("index", "apply", array());
}

?>
