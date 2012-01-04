<?php
include("../config.php");
include("../include/common.php");
include("../include/db_connect.php");
include("../include/session.php");

include("../include/chk.php");

get_root_header();

if(isset($_SESSION['root'])){
	if(isset($_REQUEST['club_id'])) {
		if(isset($_REQUEST['act'])) {
			checkMismatchedApplications($_REQUEST['club_id'], true);
			echo "Errors should be fixed. Click <a href=\"check_mismatch.php?club_id=" . $_REQUEST['club_id'] . "\">here</a> to refresh.";
		} else {
			$numMismatches = checkMismatchedApplications($_REQUEST['club_id']);
			echo "Total errors: $numMismatches";
		}
	}
?>

	<form method="post" action="check_mismatch.php">
	Club ID: <input type="text" name="club_id"><br>
	<input type="submit" value="Check tables" />
	<input type="submit" name="act" value="Check and fix errors" />
	</form>

<?
}
get_root_footer();
?>
