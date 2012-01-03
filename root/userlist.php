<?php
include("../config.php");
include("../include/common.php");
include("../include/db_connect.php");
include("../include/session.php");

get_root_header();

if(isset($_SESSION['root'])) {
	if(isset($_REQUEST['action']) && isset($_REQUEST['id'])) {
		$action = $_REQUEST['action'];
		$user_id = escape($_REQUEST['id']);
		
		if($action == 'clear') {
			//clear all application data of the user
			mysql_query("DELETE FROM answers USING applications INNER JOIN answers WHERE applications.user_id = '$user_id' AND applications.id = answers.application_id");
			mysql_query("DELETE FROM applications WHERE user_id = '$user_id'");
		} else if($action == 'delete!!') {
			//keep application data in case it's useful later
			mysql_query("DELETE FROM users WHERE id = '$user_id'");
		}
	}
	
	$result = mysql_query("SELECT id FROM users");
	
	$profileHeader = getProfile(0); //0 is invalid user ID; returns array of (profile question, user response, ID)
	echo "<table><tr><th>ID</th><th>Username</th><th>Email</th>";
	
	//get the profile names
	foreach($profileHeader as $item) {
		echo "<th>" . $item[0] . "</th>";
	}
	
	echo "<th>Clear apps</th><th>Delete user</th></tr>";
	
	while($row = mysql_fetch_array($result)) {
		$infoUser = getUserInformation($row[0]); //array of (username, email)
		$profileUser = getProfile($row[0]);
		
		echo '<form method="post" action="userlist.php">';
		echo '<input type="hidden" name="id" value="' . $row[0] . '"><tr>';
		echo '<td>' . $row[0] . '</td>';
		echo '<td>' . $infoUser[0] . '</td>';
		echo '<td>' . $infoUser[1] . '</td>';
		
		foreach($profileUser as $item) {
			echo '<td>' . $item[1] . '</td>';
		}
		
		echo '<td><input type="submit" name="action" value="clear"></td>';
		echo '<td><input type="submit" name="action" value="delete!!"></td>';
		echo '</form></tr>';
	}
	
	echo "</table>";
}

get_root_footer();
?>
