<?php
include("../config.php");
include("../include/common.php");
include("../include/db_connect.php");
include("../include/session.php");

if(isset($_SESSION['admin_id'])) {
	$club_id = escape(getAdminClub($_SESSION['admin_id']));
	
	if($club_id != 0) {
		//first, notes enabled/disabled settings
		if(isset($_REQUEST['notesupdate'])) {
			$box_enabled = isset($_REQUEST['box_enabled']) ? 1 : 0;
			$cat_enabled = isset($_REQUEST['cat_enabled']) ? 1 : 0;
			$comment_enabled = isset($_REQUEST['comment_enabled']) ? 1 : 0;
			
			mysql_query("UPDATE admins SET box_enabled = '$box_enabled', cat_enabled = '$cat_enabled', comment_enabled = '$comment_enabled' WHERE id = '" . $_SESSION['admin_id'] . "'");
		}
		
		$result = mysql_query("SELECT box_enabled, cat_enabled, comment_enabled FROM admins WHERE id='" . $_SESSION['admin_id'] . "'");
		
		$box_enabled = false;
		$cat_enabled = false;
		$comment_enabled = false;
		
		if($row = mysql_fetch_array($result)) {
			$box_enabled = $row['box_enabled'] == 1;
			$cat_enabled = $row['cat_enabled'] == 1;
			$comment_enabled = $row['comment_enabled'] == 1;
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
		$categories = array();
		
		while($row = mysql_fetch_array($result)) {
			array_push($categories, $row[0]);
		}
		
		get_page_advanced("man_notes", "admin", array('box_enabled' => $box_enabled, 'cat_enabled' => $cat_enabled, 'comment_enabled' => $comment_enabled, 'categories' => $categories));
	} else {
		get_page_advanced("message", "admin", array('message' => "General application cannot view submissions, so note functions are not available.", 'title' => "Manage Club"));
	}
} else {
	header('Location: index.php?error=' . urlencode("You are not logged in!"));
}
?>
