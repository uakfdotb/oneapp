<?php
include("../config.php");
include("../include/common.php");
include("../include/db_connect.php");
include("../include/session.php");

$errorMessage = "";

if(isset($_REQUEST['error'])) {
	$errorMessage = $_REQUEST['error'];
}

if(isset($_REQUEST['username']) && isset($_REQUEST['password'])) {
	$checkResult = checkAdmin($_REQUEST['username'], $_REQUEST['password']);
	if($checkResult !== FALSE) {
		$_SESSION['admin_id'] = $checkResult;
	} else {
		$errorMessage = "Incorrect username/password. You may be locked from your account.";
	}
} else if(isset($_REQUEST['action'])) {
	if($_REQUEST['action'] == 'logout') {
		$errorMessage = "You are now logged out.";
		session_unset();
	}
}

if(isset($_SESSION['admin_id'])) {
	get_page_advanced("index", "admin");
} else {
	get_page_advanced("index_login", "admin", array('message' => $errorMessage));
}
?>
