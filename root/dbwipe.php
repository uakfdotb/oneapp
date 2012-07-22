<?php
include("../config.php");
include("../include/common.php");
include("../include/db_connect.php");
include("../include/session.php");

include("../include/chk.php");

if(isset($_SESSION['root'])) {
	
	if(isset($_REQUEST['wipe']) && isset($_REQUEST['password'])) {
		if(checkLogin($_SESSION['user_id'], $_REQUEST['password'])) {
			databaseWipe();
			$success = "Your database has been completely wiped.";
		} else {
			$error = "Invalid password! You have been logged out for security purposes!";
			session_unset();
		}
	}
	
	if(isset($success)) {
		get_page_advanced("dbwipe", "root", array('success' => $success));
	} else if(isset($error)) {
		get_page_advanced("dbwipe", "root", array('error' => $error));
	} else if(isset($warning)) {
		get_page_advanced("dbwipe", "root", array('warning' => $warning));
	} else if(isset($info)) {
		get_page_advanced("dbwipe", "root", array('info' => $info));
	} else {
		get_page_advanced("dbwipe", "root");
	} 
} else {
	header('Location: index.php');
}
?>
