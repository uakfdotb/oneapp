<?php
include("../config.php");
include("../include/common.php");
include("../include/db_connect.php");
include("../include/session.php");

get_admin_header();

if(isset($_SESSION['admin_id'])) {
	$club_id = escape(getAdminClub($_SESSION['admin_id']));
	
	if($club_id != 0) {
		//first, notes enabled/disabled settings
		if(isset($_REQUEST['notesupdate'])) {
			$box_enabled = isset($_REQUEST['box_enabled']) ? 1 : 0;
			$cat_enabled = isset($_REQUEST['cat_enabled']) ? 1 : 0;
			
			mysql_query("UPDATE admins SET box_enabled = '$box_enabled', cat_enabled = '$cat_enabled' WHERE id = '" . $_SESSION['admin_id'] . "'");
		}
		
		$result = mysql_query("SELECT box_enabled, cat_enabled FROM admins WHERE id='" . $_SESSION['admin_id'] . "'");
		
		if($row = mysql_fetch_array($result)) {
			$box_checked = "";
			$cat_checked = "";
			
			if($row['box_enabled'] == 1) $box_checked = " checked";
			if($row['cat_enabled'] == 1) $cat_checked = " checked";
?>
			<form method="post" action="man_notes.php">
			<input type="checkbox" name="box_enabled" value="true" <?= $box_checked ?>/> Textboxes enabled
			<br /><input type="checkbox" name="cat_enabled" value="true" <?= $cat_checked ?>/> Categories enabled
			<br /><input type="submit" name="notesupdate" value="Update" />
			</form>
<?
		}
		
		//now, the categories for the notes_category feature
		
		if(isset($_REQUEST['name']) && isset($_REQUEST['action'])) {
			$catName = escape($_REQUEST['name']);
			
			if($_REQUEST['action'] == "delete") {
				mysql_query("DELETE FROM club_notes_categories WHERE club_id = '$club_id' AND name = '$catName'");
			} else if($_REQUEST['action'] == "add") {
				mysql_query("INSERT INTO club_notes_categories (name, club_id) VALUES ('$catName', '$club_id')");
			}
		}
		
		$result = mysql_query("SELECT name FROM club_notes_categories WHERE club_id = '$club_id'");
		echo "<table><tr><th>Category name</th><th>Delete</th></tr>";
		
		while($row = mysql_fetch_array($result)) {
			echo "<tr><td>" . $row[0] . "</td>";
			echo "<td><form method=\"post\" action=\"man_notes.php?name=" . urlencode($row[0]) . "\">";
			echo "<input type=\"submit\" name=\"action\" value=\"delete\" />";
			echo "</form></td></tr>";
		}
		
		echo "</table>";
		
		echo '<form method="POST" action="man_notes.php?action=add">';
		echo 'Category name <input type="text" name="name" />';
		echo '<input type="submit" value="Add category" />';
		echo '</form>';
	} else {
		echo "General application cannot view submissions, so note functions are not available.<br>";
	}
} else {
	header('Location: index.php?error=' . urlencode("You are not logged in!"));
}

get_admin_footer();
?>
