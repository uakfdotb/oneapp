<?php
include("../config.php");
include("../include/common.php");
include("../include/db_connect.php");
include("../include/session.php");

get_root_header();

if(isset($_SESSION['root'])) {
	if(isset($_REQUEST['action'])) {
		$action = $_REQUEST['action'];
		
		if($action == 'add_club') {
			$name = escape($_REQUEST['name']);
			$description = escape($_REQUEST['description']);
			
			mysql_query("INSERT INTO clubs (name, description, view_time, open_time, close_time) VALUES ('$name', '$description', '0', '0', '0')");
			echo "Club added successfully! Click <a href=\"man_clubs.php\">here</a> to continue.";
		} else if($action == 'delete') {
			$club_id = escape($_REQUEST['id']);
			mysql_query("DELETE FROM clubs WHERE id='$club_id'");
			echo "Club deleted successfully! Click <a href=\"man_clubs.php\">here</a> to continue.";
		} else if($action == 'update') {
			$club_id = escape($_REQUEST['id']);
			$description = escape($_REQUEST['description']);
			
			mysql_query("UPDATE clubs SET description='$description' WHERE id='$club_id'");
			echo "Club updated successfully! Click <a href=\"man_clubs.php\">here</a> to continue.";
		}
	} else {
		$result = mysql_query("SELECT id,name,description FROM clubs");
		
		echo '<form action="man_clubs.php?action=add_club" method="post"><table class="borderon">';
		echo '<tr><td align="right"><p>Club name</p></td><td><input type="text" name="name" style="width:100%"></td></tr>';
		echo '<tr><td align="right"><p>Description</p></td><td><textarea name="description" style="width:100%;resize:none"></textarea></td></tr>';
		echo '<tr><td colspan="2" align="right"><input type="submit" value="Add club"></td></tr>';
		echo '</table></form><br><br>';
		
		echo "<table class=\"borderon\" width=100% cellspacing=0><tr><th><p class=\"admin_table_header\">ID</p></th><th><p class=\"admin_table_header\">Club name</p></th><th><p class=\"admin_table_header\">Description</p></th><th><p class=\"admin_table_header\">Edit</p></th><th><p class=\"admin_table_header\">Delete</p></th></tr>";
		
		while($row = mysql_fetch_array($result)) {
			echo "<form method=\"post\" action=\"man_clubs.php\">";
			echo "<input type=\"hidden\" name=\"id\" value=\"" . $row['id'] . "\">";
			echo "<tr align=\"center\"><td><p>" . $row['id'] . "</p></td>";
			echo "<td><p>" . $row['name'] . "</p></td>";
			echo "<td><textarea name=\"description\" style=\"width:100%;resize:none\">" . $row['description'] . "</textarea></td>";
			
			echo "<td><input type=\"submit\" name=\"action\" value=\"update\"></td>";
			echo "<td><input type=\"submit\" name=\"action\" value=\"delete\"></td>";
			echo "</tr></form>";
		}
		
		echo "</table>";
	}
}

get_root_footer();
?>
