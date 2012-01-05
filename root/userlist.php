<?php
include("../config.php");
include("../include/common.php");
include("../include/db_connect.php");
include("../include/session.php");

if(isset($_SESSION['root'])) {
	if(isset($_REQUEST['action']) && isset($_REQUEST['id'])) {
		$action = $_REQUEST['action'];
		$user_id = escape($_REQUEST['id']);
		
		if($action == 'reset') {
			//clear all application data of the user
			mysql_query("DELETE FROM answers USING applications INNER JOIN answers WHERE applications.user_id = '$user_id' AND applications.id = answers.application_id");
			mysql_query("DELETE FROM applications WHERE user_id = '$user_id'");
		} else if($action == 'delete!!') {
			//keep application data in case it's useful later
			mysql_query("DELETE FROM users WHERE id = '$user_id'");
		}
	}
	
	$result = mysql_query("SELECT id, accessed FROM users");
	$profileHeader = getProfile(0); //0 is invalid user ID; returns array of (profile question, user response, ID)
	
	$users = array(); // array of (last_login_time, (username, email), profile_array)
	
	while($row = mysql_fetch_array($result)) {
		$infoUser = getUserInformation($row[0]); //array of (username, email)
		$profileUser = getProfile($row[0]);
		
		$users[$row[0]] = array($row[1], $infoUser, $profileUser);
	}
	
	get_page_advanced("userlist", "root", array('userList' => $users, 'profileHeader' => $profileHeader));
}
?>
