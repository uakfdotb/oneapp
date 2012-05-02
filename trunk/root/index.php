<?php
include("../include/common.php");
include("../config.php");
include("../include/db_connect.php");
include("../include/session.php");

if(isset($_REQUEST['action'])) {
	if($_REQUEST['action'] == 'logout') {
		session_unset();
		get_page_advanced("index_login", "root", array('success' => "You have been logged out!"));
	}
} else if(isset($_REQUEST['password'])) {
	if(checkRoot($_REQUEST['password'])) {
		$_SESSION['root'] = true;
		get_page_advanced("manage", "root", array('success' => "You are now logged in!"));
	} else {
		get_page_advanced("index_login", "root", array('error' => "Password is incorrect or you have been locked out."));
	}
} else if(isset($_SESSION['root'])) {
	get_page_advanced("index", "root");
} else {
	get_page_advanced("index_login", "root");
}
?>
