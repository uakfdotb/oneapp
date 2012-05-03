<?php
include("../config.php");
include("../include/common.php");
include("../include/db_connect.php");
include("../include/session.php");

if(isset($_SESSION['root'])) {
	if(isset($_REQUEST['action']) && isset($_REQUEST['id'])) {
		$action = $_REQUEST['action'];
		$user_id = escape($_REQUEST['id']);
		
		if($action == 'Reset') {
			//clear all application data of the user
			mysql_query("DELETE FROM answers USING applications INNER JOIN answers WHERE applications.user_id = '$user_id' AND applications.id = answers.application_id");
			mysql_query("DELETE FROM applications WHERE user_id = '$user_id'");
			$success = "Application reset!";
		} else if($action == 'Delete') {
			//keep application data in case it's useful later
			mysql_query("DELETE FROM users WHERE id = '$user_id'");
			$success = "User deleted!";
		}
	}
	
	$result = mysql_query("SELECT id, accessed FROM users");
	
	$users = array(); // array of (last_login_time, (username, email, name))
	
	while($row = mysql_fetch_array($result)) {
		$infoUser = getUserInformation($row[0]); //array of (username, email, name)
		$users[$row[0]] = array($row[1], $infoUser);
	}
	
	if(isset($success)){
		get_page_advanced("userlist", "root", array('success' => $success, 'userList' => $users));
	} else {
		get_page_advanced("userlist", "root", array('userList' => $users));
	}
} else {
	header('Location: index.php');
}
?>
