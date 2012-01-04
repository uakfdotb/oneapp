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
	$box_enabled = ($row['box_enabled'] == 1) ? true : false;
	$cat_enabled = ($row['cat_enabled'] == 1) ? true : false;
		
	//we will need to construct a map from the application database IDs to the box and category note values if enabled
	// we do this now so that we can check if an entry exists already for updating the notes table
	if($box_enabled || $cat_enabled) {
		$toolsResult = mysql_query("SELECT application_id, box, category FROM club_notes WHERE club_id = '$club_id'");
		$toolsMap = array();
	
		while($row = mysql_fetch_array($toolsResult)) {
			$toolsMap[$row['application_id']] = array($row['box'], $row['category']);
		}
	}
	
	//check if notes table needs to be updated; use toolsMap to see if INSERT or UPDATE should be used
	if(($box_enabled || $cat_enabled) && isset($_REQUEST['id'])) {
		$application_id = escape($_REQUEST['id']);
		
		//verify that it belongs to this admin's club
		$result = mysql_query("SELECT club_id FROM applications WHERE id = '$application_id'");
		
		if($row = mysql_fetch_array($result)) { //application exists
			if($row[0] == $club_id) { //club is correct
				//if the tools map does not contain the ID, then we have to add it to database
				if(!isset($toolsMap[$application_id])) {
					$toolsMap[$application_id] = array('', '');
					mysql_query("INSERT INTO club_notes (application_id, club_id) VALUES ('$application_id', '$club_id')");
				}
				
				//now we check what needs to be updated
				// since we pre-retrieved toolsMap, we have to update it to reflect the changes
				
				$updateString = "";
		
				if($box_enabled && isset($_REQUEST['box'])) {
					$updateString .= "box = '" . escape($_REQUEST['box']) . "', ";
					$toolsMap[$application_id][0] = $_REQUEST['box'];
				}
		
				if($cat_enabled && isset($_REQUEST['category'])) {
					$updateString .= "category = '" . escape($_REQUEST['category']) . "', ";
					$toolsMap[$application_id][1] = $_REQUEST['category'];
				}
			
				if(strlen($updateString) > 0) {
				
					$updateString = substr($updateString, 0, -2);
					mysql_query("UPDATE club_notes SET $updateString WHERE application_id='$application_id' AND club_id='$club_id'");
				}
			}
		}
	}
	
	//box filter manager
	if($box_enabled) {
		//filter might already be set, so retrieve it
		// todo: somehow merge this code with the catfilter code, because it's the same..
		$boxFilter = "";
		if(isset($_REQUEST['boxFilter'])) {
			//store filter in session so that we can get it when user changes something
			// this way, we don't have to worry about setting it everywhere
			$boxFilter = $_REQUEST['boxFilter'];
			$_SESSION['boxFilter'] = $boxFilter;
		} else if(isset($_SESSION['boxFilter'])) {
			$boxFilter = $_SESSION['boxFilter'];
		}
	
		//just show a field with the filter text written by default
		echo '<form method="POST" action="view_submit.php">';
		echo "Textbox filter: <input type=\"text\" name=\"boxFilter\" value=\"$boxFilter\">";
		echo "<input type=\"submit\" value=\"Filter\">";
		echo "</form>";
	}
	
	//category filter manager
	if($cat_enabled) {
		//first, we retrieve a list of categories (this will be used in dropdown as well)
		$catResult = mysql_query("SELECT name FROM club_notes_categories WHERE club_id = '$club_id'");
		$catList = array();
	
		while($row = mysql_fetch_array($catResult)) {
			array_push($catList, $row[0]);
		}
	
		// filter might already be set, so retrieve it
		$catFilter = "";
		if(isset($_REQUEST['catFilter'])) {
			//store catfilter in session so that we can get it when user changes something
			// this way, we don't have to worry about setting it everywhere
			$catFilter = $_REQUEST['catFilter'];
			$_SESSION['catFilter'] = $catFilter;
		} else if(isset($_SESSION['catFilter'])) {
			$catFilter = $_SESSION['catFilter'];
		}
	
		// now, we give user a filter selection dropdown, preselecting the current filter if any
		echo '<form method="POST" action="view_submit.php">';
		echo "Category filter: <select name=\"catFilter\">";
		echo "<option value=\"\">No filtering</option>";
	
		foreach($catList as $catElement) {
			$selectedString = ($catElement == $catFilter) ? " selected" : "";
			echo "<option value=\"$catElement\"$selectedString>$catElement</option>";
		}
	
		echo "</select><input type=\"submit\" value=\"Filter\">";
		echo "</form>";
	}
	
	//list the applications, applying filters only when we loop (inefficient but okay)
	$array = listCompletedApplications($club_id);

	echo "<table><tr><th><p class=\"admin_table_header\">App ID</p></th><th><p class=\"admin_table_header\">User ID</p></th><th><p class=\"admin_table_header\">General application</p></th><th><p class=\"admin_table_header\">Supplement</p></th><th><p class=\"admin_table_header\">Recommendations</p></th>";
	
	if($box_enabled) echo "<th><p class=\"admin_table_header\">The Box</p></th>";
	if($cat_enabled) echo "<th><p class=\"admin_table_header\">Category</p></th>";
	if($box_enabled || $cat_enabled) echo "<th><p class=\"admin_table_header\">Update</p></th>";
	
	echo "</tr>";

	foreach($array as $item) {
		$appId = $item[0];
		
		//filtering; skip if match fails
		if($box_enabled && $boxFilter != "" && (!isset($toolsMap[$appId]) || strpos($toolsMap[$appId][0], $boxFilter) === FALSE)) continue;
		if($cat_enabled && $catFilter != "" && (!isset($toolsMap[$appId]) || $toolsMap[$appId][1] != $catFilter)) continue;
		
		//form needed in case the update categories or box
		if($box_enabled || $cat_enabled) echo "<form method=\"post\" action=view_submit.php?id=$appId>";
		
		$userId = '<p><a href="user_detail.php?id=' . $item[1] . '">' . $item[1] . '</a></p>';
		$generalApp = '<p><a href="../submit/' . $item[2] . '.pdf">Download</a></p>';
		$supplement = '<p><a href="../submit/' . $item[3] . '.pdf">Download</a></p>';
		
		$peerString = "";
		foreach($item[4] as $peerEntry) {
			$peerString .= '<a href="../submit/' . $peerEntry . '.pdf">Download</a> | ';
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
			
			echo "</select></td>";
		}
		
		if($box_enabled || $cat_enabled) {
			echo '<td><input type="submit" value="update" /></td>';
		}
		
		if($box_enabled || $cat_enabled) echo "</form>";
		echo '</tr>';
	}
	
	echo "</table>";
} else {
	header('Location: index.php?error=' . urlencode("You are not logged in!"));
}

get_admin_footer();
?>
