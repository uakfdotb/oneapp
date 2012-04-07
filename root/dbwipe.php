<?php
include("../config.php");
include("../include/common.php");
include("../include/db_connect.php");
include("../include/session.php");

include("../include/chk.php");

if(isset($_SESSION['root'])) {
	$message = "";
	
	if(isset($_REQUEST['wipe']) && isset($_REQUEST['password'])) {
		if(checkRoot($_REQUEST['password'])) {
			//databaseWipe();
			$message = "This feature is disabled on the demo version.";
		} else {
			$message = "Invalid password. You have been logged out.";
			session_unset();
		}
	}
	
	get_page_advanced("dbwipe", "root", array('message' => $message));
} else {
	header('Location: index.php');
}
?>
