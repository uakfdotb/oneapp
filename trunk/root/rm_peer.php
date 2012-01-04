<?php
include("../config.php");
include("../include/common.php");
include("../include/db_connect.php");
include("../include/session.php");

get_root_header();

if(isset($_SESSION['root'])) {
	echo '<form method="GET" action="rm_peer.php">';
        echo 'User ID: <input type="text" name="user_id" />';
        echo ' <input type="submit" value="List">';
        echo '</form><br><br>';

	if(isset($_REQUEST['user_id'])) {

		$user_id = escape($_REQUEST['user_id']);
		if(isset($_REQUEST['remove_id'])) {
			$recommend_id = escape($_REQUEST['remove_id']);
			
			mysql_query("DELETE FROM recommender_answers WHERE recommend_id = '$recommend_id'");
			mysql_query("DELETE FROM recommendations WHERE id = '$recommend_id'");
		}
		
		$result = mysql_query("SELECT * FROM recommendations WHERE user_id = '$user_id'");
		echo '<table class="borderon" width=100%><tr><th><p class="admin_table_header">Author</p></th><th><p class="admin_table_header">Email</p></th><th width=100px><p class="admin_table_header">Auth</p></th><th><p class="admin_table_header">Status</p></th><th><p class="admin_table_header">File</p></th><th><p class="admin_table_header">Delete</p></th></tr>';
		
		$rowcounter = 1; //used to identify which row we are on for banding
		while($row = mysql_fetch_array($result)) {
			echo '<tr align="center" class="band' . $rowcounter%2 . '">';
			echo '<td><p>' . $row['author'] . '</p></td>';
			echo '<td><p>' . $row['email'] . '</p></td>';
			echo '<td><p>' . wordwrap($row['auth'], 15, "<br>", true) . '</p></td>';
			
			//find the status string
			// status of 0 means incomplete, 1 means complete and enabled, 2 means complete and disabled
			$statusString = ($row['status'] == "0") ? "incomplete" : "complete (enabled)";
			if($row['status'] == 2) $statusString = "complete (disabled)";
			echo "<td><p>" . $statusString . "</p></td>";
			
			if($row['filename'] != '') {
				echo '<td><a href="../submit/' . $row['filename'] . '.pdf">link</a></td>';
			} else {
				echo '<td><p>N/A</p></td>';
			}
			
			echo "<td><form method=\"POST\" action=\"rm_peer.php?user_id=$user_id&remove_id=" . $row['id'] . "\">";
			echo '<input type="submit" value="Delete" /></form></td>';
			
			echo '</tr>';
			
			$rowcounter=$rowcounter+1;
		}
		
		echo '</table>';
	}
	
}

get_root_footer();
?>
