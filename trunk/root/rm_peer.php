<?php
include("../config.php");
include("../include/common.php");
include("../include/db_connect.php");
include("../include/session.php");

get_root_header();

if(isset($_SESSION['root'])) {
	if(isset($_REQUEST['user_id'])) {
		$user_id = escape($_REQUEST['user_id']);
		if(isset($_REQUEST['remove_id'])) {
			$recommend_id = escape($_REQUEST['remove_id']);
			
			mysql_query("DELETE FROM recommender_answers WHERE recommend_id = '$recommend_id'");
			mysql_query("DELETE FROM recommendations WHERE id = '$recommend_id'");
		}
		
		$result = mysql_query("SELECT * FROM recommendations WHERE user_id = '$user_id'");
		echo '<table><tr><th>Author</th><th>Email</th><th>Auth</th><th>Status</th><th>File</th><th>Delete</th></tr>';
		
		while($row = mysql_fetch_array($result)) {
			echo '<tr>';
			echo '<td>' . $row['author'] . '</td>';
			echo '<td>' . $row['email'] . '</td>';
			echo '<td>' . $row['auth'] . '</td>';
			
			$statusString = ($row['status'] == "0") ? "incomplete" : "complete (enabled)";
			if($row['status'] == 2) $statusString = "complete (disabled)";
			echo "<td>" . $statusString . "</td>";
			
			if($row['filename'] != '') {
				echo '<td><a href="../submit/' . $row['filename'] . '.pdf">link</a></td>';
			} else {
				echo '<td>N/A</td>';
			}
			
			echo "<td><form method=\"POST\" action=\"rm_peer.php?user_id=$user_id&remove_id=" . $row['id'] . "\">";
			echo '<input type="submit" value="Delete" /></form></td>';
			
			echo '</tr>';
		}
	}
	
	echo '<form method="GET" action="rm_peer.php">';
	echo 'User ID: <input type="text" name="user_id" />';
	echo ' <input type="submit" value="List">';
	echo '</form>';
}

get_root_footer();
?>
