<?php
include("../config.php");
include("../include/common.php");
include("../include/db_connect.php");
include("../include/session.php");

if(isset($_SESSION['admin'])) {
	$club_id = $_SESSION['admin_club_id'];
	
	if(isset($_REQUEST['target']) && isset($_REQUEST['subject']) && isset($_REQUEST['body'])) {
		sendAdminGroupMessage($_SESSION['user_id'], $club_id, $_REQUEST['target'], $_REQUEST['subject'], $_REQUEST['body']);
	}
	
	get_page_advanced("message", "admin", array('message' => $message, 'categories' => $categories));
} else {
	header('Location: index.php');
}
?>
