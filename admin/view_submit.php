<?php
include("../config.php");
include("../include/common.php");
include("../include/db_connect.php");
include("../include/session.php");

include("../include/apply_submit.php");

get_admin_header();

if(isset($_SESSION['admin_id'])) {
	$club_id = escape(getAdminClub($_SESSION['admin_id']));
	
	//check if this admin is using textboxes and categories
	$result = mysql_query("SELECT box_enabled, cat_enabled FROM admins WHERE id='" . escape($_SESSION['admin_id']) . "'");
	$row = mysql_fetch_array($result);
	$box_enabled = $row['box_enabled'];
	$cat_enabled = $row['cat_enabled'];
	
	$array = listCompletedApplications($club_id);

	echo "<table><tr><th>App ID</th><th>User ID</th><th>General application</th><th>Supplement</th><th>Peer recommendations</th>";
	
	if($box_enabled) echo "<th>The Box</th>";
	if($cat_enabled) {
		echo "<th>Category</th>";
		
		//we also need to retrieve the list of categories
		$catResult = mysql_query("SELECT name FROM club_notes_categories WHERE club_id = '$club_id'");
		$catList = array();
		
		while($row = mysql_fetch_array($catResult)) {
			array_push($catList, $row[0]);
		}
	}
	
	if($box_enabled || $cat_enabled) {
		echo "<th>Update</th>";
		
		//we also need to construct a map from the application database IDs to the box and category note values
		$toolsResult = mysql_query("SELECT application_id, box, category FROM club_notes WHERE club_id = '$club_id'");
		$toolsMap = array();
		
		while($row = mysql_fetch_array($toolsResult)) {
			$toolsMap[$row['application_id']] = array($row['box'], $row['category']);
		}
	}
	
	echo "</tr>";

	foreach($array as $item) {
		$appId = $item[0];
		echo "<form method=\"post\" action=view_submit.php?id=$appId>";
		
		$userId = '<a href="user_detail.php?id=' . $item[1] . '">' . $item[1] . '</a>';
		$generalApp = '<a href="../submit/' . $item[2] . '.pdf">' . $item[2] . '</a>';
		$supplement = '<a href="../submit/' . $item[3] . '.pdf">' . $item[3] . '</a>';
		
		$peerString = "";
		foreach($item[4] as $peerEntry) {
			$peerString .= '<a href="../submit/' . $peerEntry . '.pdf">' . $peerEntry . '</a> | ';
		}
	
		echo "<tr><td>$appId</td><td>$userId</td><td>$generalApp</td><td>$supplement</td><td>$peerString</td>";
		
		if($box_enabled) {
			if(isset($toolsMap[$appId])) $boxValue = $toolsMap[$appId][0];
			else $boxValue = "";
			
			echo "<td><input type=\"text\" value=\"$boxValue\" name=\"box\" /></td>";
		}
		
		if($cat_enabled) {
			if(isset($toolsMap[$appId])) $catValue = $toolsMap[$appId][1];
			else $catValue = "";
			
			//display a list of categories, and pre-select the catValue on dropdown
			echo "<td><select name=\"category\">";
			
			foreach($catList as $catElement) {
				$selectedString = ($catElement == $catValue) ? " selected" : "";
				echo "<option name=\"$catElement\"$selectedString>$catElement</option>";
			}
			
			echo "</td>";
		}
		
		if($box_enabled || $cat_enabled) {
			echo '<td><input type="submit" value="update" /></td>';
		}
		
		echo '</tr>';
	}
	
	echo "</table>";
}

get_admin_footer();
?>
