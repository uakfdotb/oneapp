<?php
include("../config.php");
include("../include/common.php");
include("../include/db_connect.php");
include("../include/session.php");

if(isset($_SESSION['root'])) {
	
	if(isset($_REQUEST['action'])) {
		$action = $_REQUEST['action'];
		
		if($action == 'add_club') {
			$name = escape($_REQUEST['name']);
			$description = escape($_REQUEST['description']);
			$money = escape($_REQUEST['money']);
			
			//verify that limit has not been reached
			$limitFail = false;
			if(isset($config['limits']) && isset($config['limits']['clubs']) && $config['limits']['clubs'] > 0) {
				$result = mysql_query("SELECT COUNT(*) FROM clubs");
				$row = mysql_fetch_array($result);
				
				if($row[0] >= $config['limits']['clubs']) {
					$error = "Limit on # clubs has been reached! Update limits in configuration or contact your hosting provider.";
					$limitFail = true;
				}
			}
			
			if(!$limitFail) {
				mysql_query("INSERT INTO clubs (name, description, view_time, open_time, close_time, money) VALUES ('$name', '$description', '0', '0', '0', '$money')");
				$success = "Club added successfully!";
			}
		} else if($action == 'delete') {
			$club_id = escape($_REQUEST['id']);
			mysql_query("DELETE FROM clubs WHERE id='$club_id'");
			$success = "Club deleted successfully!";
		} else if($action == 'update') {
			$club_id = escape($_REQUEST['id']);
			$description = escape($_REQUEST['description']);
			
			mysql_query("UPDATE clubs SET description='$description' WHERE id='$club_id'");
			$success = "Club updated successfully!";
		}
	}
	
	$result = mysql_query("SELECT id,name,description,money FROM clubs");
	if(isset($error)){
		get_page_advanced("man_clubs", "root", array('error' => $error, 'clubsResult' => $result));
	} else if(isset($success)) {
		get_page_advanced("man_clubs", "root", array('success' => $success, 'clubsResult' => $result));
	} else {
		get_page_advanced("man_clubs", "root", array('clubsResult' => $result));
	}
} else {
	header('Location: index.php');
}
?>
