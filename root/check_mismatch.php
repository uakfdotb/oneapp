<?php
include("../config.php");
include("../include/common.php");
include("../include/db_connect.php");
include("../include/session.php");

include("../include/chk.php");

if(isset($_SESSION['root'])){
	$mismatches = false;
	
	if(isset($_REQUEST['club_id'])) {
		if(isset($_REQUEST['act'])) {
			checkMismatchedApplications($_REQUEST['club_id'], true);
			$mismatches = array("Errors should be fixed. Click <a href=\"check_mismatch.php?club_id=" . $_REQUEST['club_id'] . "\">here</a> to refresh.");
		} else {
			$mismatches = checkMismatchedApplications($_REQUEST['club_id']);
		}
	}
	get_page_advanced("check_mismatch", "root", array('mismatches' => $mismatches));
} else {
	header('Location: index.php');
}
?>
