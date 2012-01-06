<?php
include("../config.php");
include("../include/common.php");
include("../include/db_connect.php");
include("../include/session.php");

include("../include/apply_gen.php");
include("../include/latex.php");

if(isset($_SESSION['admin_id'])) {
	$club_id = escape(getAdminClub($_SESSION['admin_id']));
	
	if(isset($_REQUEST['type'])) {
		
	} else {
		get_page_advanced("easyq_type", "admin");
	}
} else {
	header('Location: index.php?error=' . urlencode("You are not logged in!"));
}
?>
