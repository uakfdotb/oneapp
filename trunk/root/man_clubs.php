<?php
include("../config.php");
include("../include/common.php");
include("../include/db_connect.php");
include("../include/session.php");

if(isset($_SESSION['root'])) {
	$message = "";
	
	if(isset($_REQUEST['action'])) {
		$action = $_REQUEST['action'];
		
		if($action == 'add_club') {
			$name = escape($_REQUEST['name']);
			$description = escape($_REQUEST['description']);
			
			mysql_query("INSERT INTO clubs (name, description, view_time, open_time, close_time) VALUES ('$name', '$description', '0', '0', '0')");
			$message = "Club added successfully! Click <a href=\"man_clubs.php\">here</a> to continue.";
		} else if($action == 'delete') {
			$club_id = escape($_REQUEST['id']);
			mysql_query("DELETE FROM clubs WHERE id='$club_id'");
			$message = "Club deleted successfully! Click <a href=\"man_clubs.php\">here</a> to continue.";
		} else if($action == 'update') {
			$club_id = escape($_REQUEST['id']);
			$description = escape($_REQUEST['description']);
			
			mysql_query("UPDATE clubs SET description='$description' WHERE id='$club_id'");
			$message = "Club updated successfully! Click <a href=\"man_clubs.php\">here</a> to continue.";
		}
	}
	
	$result = mysql_query("SELECT id,name,description FROM clubs");
	get_page_advanced("man_clubs", "root", array('message' => $message, 'clubsResult' => $result));
} else {
	header('Location: index.php');
}
?>
