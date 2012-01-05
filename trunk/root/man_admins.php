<?php
include("../config.php");
include("../include/common.php");
include("../include/db_connect.php");
include("../include/session.php");

if(isset($_SESSION['root'])) {
	$message = "";
	
	if(isset($_REQUEST['action'])) {
		$action = $_REQUEST['action'];
		
		if($action == 'add') {
			addAdmin($_REQUEST['username'], $_REQUEST['password'], $_REQUEST['email'], $_REQUEST['club_id']);
			$message = "Admin added successfully! Click <a href=\"man_admins.php\">here</a> to continue.";
		} else if($action == 'delete') {
			$admin_id = escape($_REQUEST['id']);
			mysql_query("DELETE FROM admins WHERE id='$admin_id'");
			$message =  "Admin deleted successfully! Click <a href=\"man_admins.php\">here</a> to continue.";
		} else if($action == 'update') {
			updateAdmin($_REQUEST['id'], $_REQUEST['username'], $_REQUEST['password'], $_REQUEST['email'], $_REQUEST['club_id']);
			$message =  "Admin updated successfully! Click <a href=\"man_admins.php\">here</a> to continue.";
		}
	}
	
	$result = mysql_query("SELECT id, club_id, username, email FROM admins");
	$adminList = array();
	
	while($row = mysql_fetch_array($result)) {
		array_push($adminList, array($row[0], $row[1], $row[2], $row[3]));
	}
	
	get_page_advanced("man_admins", "root", array('message' => $message, 'adminList' => $adminList));
} else {
	header('Location: index.php');
}
?>
