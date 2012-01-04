<?php
include("../config.php");
include("../include/common.php");
include("../include/db_connect.php");
include("../include/session.php");

get_admin_header();

//check for $_REQUEST['id'] here because this page should never be accessed without an id set
if(isset($_SESSION['admin_id']) && $_REQUEST['id']) {
	$club_id = escape(getAdminClub($_SESSION['admin_id']));
	$app_id = escape($_REQUEST['id']);
	
	if($club_id != 0) {
		//retrieve and display comments (if not found in table, comments have not been set yet so default to blank)
		$current_comments = "";
		$result = mysql_query("SELECT comments FROM club_notes WHERE application_id='$app_id' AND club_id='$club_id'");
		if($row = mysql_fetch_array($result)) {
			$current_comments = $row[0];
		}
		
		//updated comments is handled in view_submit for now so that user can return and to avoid code duplication
		echo "<form method=\"POST\" action=\"view_submit.php?id=$app_id\">";
		echo "<textarea name=\"comments\">$current_comments</textarea>";
		echo "<br /><input type=\"submit\" value=\"Save\">";
		echo "</form>";
	} else {
		echo "General application admin cannot store comments (no submissions).<br>";
	}
} else {
	header('Location: index.php?error=' . urlencode("You are not logged in!"));
}


get_admin_footer();
?>
