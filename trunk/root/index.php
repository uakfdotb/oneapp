<?php
include("../include/common.php");
include("../config.php");
include("../include/db_connect.php");
include("../include/session.php");

if(isset($_REQUEST['action'])) {
	if($_REQUEST['action'] == 'logout') {
		session_unset();
		get_page_advanced("message", "root", array('message' => "You have been logged out. Click <a href=\"index.php\">here</a> to continue.", 'title' => "Logged out"));
	}
} else if(isset($_REQUEST['password'])) {
	if(checkRoot($_REQUEST['password'])) {
		$_SESSION['root'] = true;
		get_page_advanced("message", "root", array('message' => "Click <a href=\"index.php\">here</a> to continue.", 'title' => "Logged in"));
	} else {
		get_page_advanced("message", "root", array('message' => "Password is incorrect or you have been locked out. Click <a href=\"index.php\">here</a> to continue.", 'title' => "Login failed"));
	}
} else if(isset($_SESSION['root'])) {
	get_page_advanced("index", "root");
} else {
	get_page_advanced("index_login", "root");
}
?>
