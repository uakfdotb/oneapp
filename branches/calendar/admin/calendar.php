<?php
include("../config.php");
include("../include/common.php");
include("../include/db_connect.php");
include("../include/session.php");

//check for $_REQUEST['id'] here because this page should never be accessed without an id set
if(isset($_SESSION['admin'])) {
	$club_id = $_SESSION['admin_club_id'];
	$user_id = $_SESSION['user_id'];
	
	if($club_id > 0) {
		$club_info = clubInfo($club_id);
		$club_name = $club_info[0];
	}
	else {
		$club_name = "Unknown";
	}
	
	$current_comments = "";
	$result = mysql_query("SELECT comments FROM club_notes WHERE application_id='$app_id' AND user_id='$user_id'");
	if($row = mysql_fetch_array($result)) {
		$current_comments = $row[0];
	}
	
	get_page_advanced("comments", "admin", array('comments' => $current_comments, 'app_id' => $app_id));
} else {
	header('Location: index.php');
}
?>
