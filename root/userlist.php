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
	echo "<table width=100% class=\"borderon\"><tr><th><p class=\"admin_table_header\">ID</p></th><th><p class=\"admin_table_header\">Username</p></th><th><p class=\"admin_table_header\">Email</p></th>";
	
	//get the profile names
	foreach($profileHeader as $item) {
		echo "<th><p class=\"admin_table_header\">" . $item[0] . "</p></th>";
	}
	
	echo "<th><p class=\"admin_table_header\">Clear apps</p></th><th><p class=\"admin_table_header\">Delete user</p></th></tr>";
	
	while($row = mysql_fetch_array($result)) {
		$infoUser = getUserInformation($row[0]); //array of (username, email)
		$profileUser = getProfile($row[0]);
		
		echo '<form method="post" action="userlist.php">';
		echo '<input type="hidden" name="id" value="' . $row[0] . '"><tr align="center">';
		echo '<td><p>' . $row[0] . '</p></td>';
		echo '<td><p>' . $infoUser[0] . '</p></td>';
		echo '<td><p>' . $infoUser[1] . '</p></td>';
		
		foreach($profileUser as $item) {
			echo '<td><p>' . $item[1] . '</p></td>';
		}
		
		echo '<td><input type="submit" name="action" value="clear"></td>';
		echo '<td><input type="submit" name="action" value="delete!!"></td>';
		echo '</form></tr>';
	}
	
	echo "</table>";
}

get_root_footer();
?>
