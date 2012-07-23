<?php
include("../config.php");
include("../include/common.php");
include("../include/db_connect.php");
include("../include/session.php");

include("../include/custom.php");

if(isset($_SESSION['root'])) {
	//make sure default custom categories exist
	customGetCategory("recommend", true);

	if(isset($_REQUEST['action'])) {
		$action = $_REQUEST['action'];
		
		if($action == 'add' && isset($_REQUEST['username']) && isset($_REQUEST['group_id'])) {
			$user_id = getUserId($_REQUEST['username']);
			if($user_id !== FALSE) {
				if(substr($_REQUEST['group_id'], 0, 1) == 'g') {
					if(alterAdminGroups($user_id, false, substr($_REQUEST['group_id'], 1))) {
						$success = "Admin added successfully!";
					} else {
						$error = "Admin not added! This admin may already be associated with that group!";
					}
				} else if(substr($_REQUEST['group_id'], 0, 1) == 'c') {
					if(customAlterAdmin($user_id, false, substr($_REQUEST['group_id'], 1))) {
						$success = "Admin added successfully!";
					} else {
						$error = "Admin not added! This admin may already be associated with that group!";
					}
				}
			} else {
				$error = "Username not found.";
			}
		} else if(($action == 'remove' || $action == "Remove") && isset($_REQUEST['id']) && isset($_REQUEST['group_id_orig'])) {
			if(substr($_REQUEST['group_id_orig'], 0, 1) == 'g') {
				alterAdminGroups($_REQUEST['id'], substr($_REQUEST['group_id_orig'], 1), false);
			} else if(substr($_REQUEST['group_id_orig'], 0, 1) == 'c') {
				customAlterAdmin($_REQUEST['id'], substr($_REQUEST['group_id_orig'], 1), false);
			}
			
			$success =  "Admin removed successfully.";
		} else if(($action == 'update' || $action == 'Update') && isset($_REQUEST['id']) && isset($_REQUEST['group_id_orig']) && isset($_REQUEST['group_id'])) {
			if(substr($_REQUEST['group_id'], 0, 1) == 'g') {
				alterAdminGroups($_REQUEST['id'], substr($_REQUEST['group_id_orig'], 1), substr($_REQUEST['group_id'], 1));
			} else if(substr($_REQUEST['group_id'], 0, 1) == 'c') {
				customAlterAdmin($_REQUEST['id'], substr($_REQUEST['group_id_orig'], 1), substr($_REQUEST['group_id'], 1));
			}
			
			$success = "Admin updated successfully.";
		}
	}
	
	//get list of possible groups
	//there are three types we have to consider:
	// 1. clubs, in user_groups
	// 2. special groups, in user_groups
	// 3. custom field groups, in user_custom
	//we label the first two with g and the third with c
	$clubsList = listClubsIdName();
	$catList = customCategories();
	
	$groupList = array();
	
	$groupList["g0"] = "General application";
	$groupList["g-1"] = "Root admin";
	//don't include custom field group, because we're including the actual custom categories
	
	foreach($clubsList as $club_id => $club_name) {
		$groupList["g" . $club_id] = $club_name;
	}
	
	foreach($catList as $cat_id => $cat_name) {
		$groupList["c" . $cat_id] = $cat_name;
	}
	
	//now create the list of admins, using same notation as above
	$adminList = array();
	$result = mysql_query("SELECT user_groups.user_id, user_groups.`group`, users.username FROM user_groups LEFT JOIN users ON user_groups.user_id = users.id WHERE user_groups.`group` != '-2' ORDER BY user_groups.`group`");
	
	while($row = mysql_fetch_array($result)) {
		//try to find group name
		$groupId = 'g' . $row[1];
		$groupName = "unknown, id=" . $groupId;
		
		if(isset($groupList[$groupId])) {
			$groupName = $groupList[$groupId];
		}
		
		$adminList[] = array($row[0], $row[2], $groupId, $groupName);
	}
	
	$customAdmins = customAdmins(); //array of (user id, user name, category id, category name)
	
	foreach($customAdmins as $admin) {
		$adminList[] = array($admin[0], $admin[1], 'c' . $admin[2], $admin[3]);
	}
	
	$result = mysql_query("SELECT username, name FROM users");
	
	while($row = mysql_fetch_array($result)) {
		$userList[] = array($row[0], $row[1]);
	}
	
	$parameters = array();
	$parameters['adminList'] = $adminList;
	$parameters['groupList'] = $groupList;
	$parameters['userList'] = $userList;
	
	if(isset($error)) {
		$parameters['error'] = $error;
	} else if(isset($success)) {
		$parameters['success'] = $success;
	}
	
	get_page_advanced("man_admins", "root", $parameters);
} else {
	header('Location: index.php');
}
?>
