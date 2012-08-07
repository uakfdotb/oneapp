<?php
include("../config.php");
include("../include/common.php");
include("../include/db_connect.php");
include("../include/session.php");

if(isset($_SESSION['admin'])) {
	$club_id = $_SESSION['admin_club_id'];
	$user_id = $_SESSION['user_id'];
	$userInfo = getUserInformation($_SESSION['user_id']); //array of (username, email, name)
	
	if($club_id > 0) {
		if(isset($_REQUEST['old_password'])) {
			$pass = $_REQUEST['old_password'];
			if(verifyLogin($user_id,$_REQUEST['old_password'])===true) {
				if(isset($_REQUEST['description']) && isset($_REQUEST['view_time']) && isset($_REQUEST['open_time']) && isset($_REQUEST['close_time'])) {
					$description = escape($_REQUEST['description']);
					$view_time = strtotime($_REQUEST['view_time']);
					$open_time = strtotime($_REQUEST['open_time']);
					$close_time = strtotime($_REQUEST['close_time']);
					$num_recommend = escape($_REQUEST['num_recommend']);

					mysql_query("UPDATE clubs SET description='$description', view_time='$view_time', open_time='$open_time', close_time='$close_time', num_recommend='$num_recommend' WHERE id='$club_id'");
					$success = "Club information updated successfully.";
				}
				if(isset($_REQUEST['new_password']) && isset($_REQUEST['new_password_conf']) && isset($_REQUEST['email'])) {
					$update_res = updateAccount($user_id,$pass,$_REQUEST['new_password'],$_REQUEST['new_password_conf'],$_REQUEST['email']);
					if($update_res==0){
						$success = "Club and account info updated successfully!";
					} else if(abs($update_res)==1) {
						$error = "Invalid New Password!";
					} else if($update_res==-2) {
						$error = "Internal Error while updating account!";
					} else if($update_res==10) {
						$error = "Invalid new email!";
					} else if($update_res==11) {
						$error = "Passwords do not match!";
					}
				}
			} else {
				$error="Incorrect password! Please try again";
			}
		} else {
			$warning = "You need your current password to make any changes!";
		}
		
		$result = mysql_query("SELECT name, description, view_time, open_time, close_time, num_recommend FROM clubs WHERE id='$club_id'");
			if(isset($error)) {
				$inform['error'] = $error;
			} else if( isset($success) ){
				$inform['success'] = $success;
			} else if( isset($info) ){
				$inform['info'] = $info;
			} else if( isset($warning) ){
				$inform['warning'] = $warning;
			}
		if($row = mysql_fetch_array($result)) {
			$parameters = array('club_name' => $row['name'], 'description' => $row['description'], 'view_time' => $row['view_time'], 'open_time' => $row['open_time'], 'close_time' => $row['close_time'], 'num_recommend' => $row['num_recommend'], 'username' => $userInfo[0], 'email' => $userInfo[1], 'name' => $userInfo[2], 'inform' => $inform);
			
			get_page_advanced("man_club", "admin", $parameters);
		} else {
			get_page_advanced("message", "admin", array('message' => "Error: your club cannot be found in the clubs table.", 'title' => "Manage Club"));
		}
	} else {
			get_page_advanced("message", "admin", array('message' => "Error: general application does not have club settings.", 'title' => "Manage Club"));
	}
} else {
	header('Location: index.php?error=' . urlencode("You are not logged in!"));
}
