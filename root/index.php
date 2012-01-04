<?php
include("../include/common.php");
include("../config.php");
include("../include/db_connect.php");
include("../include/session.php");

get_root_header();

if(isset($_REQUEST['action'])) {
	if($_REQUEST['action'] == 'logout') {
		unset($_SESSION['root']);
		echo "You have been logged out. Click <a href=\"index.php\">here</a> to continue.";
	}
} else if(isset($_REQUEST['password'])) {
	if(checkRoot($_REQUEST['password'])) {
		$_SESSION['root'] = true;
		echo "Click <a href=\"index.php\">here</a> to continue.";
	} else {
		echo "Password is incorrect or you have been locked out. Click <a href=\"index.php\">here</a> to continue.";
	}
} else if(isset($_SESSION['root'])) {
?>
	<h1>Welcome Root!</h1>
	<p>As a root administrator, you can add clubs, delete clubs, add admin and delete admin. If you have any problems please refer to the root manual.</p>
<?
} else {
?>
	<form method="POST" action="index.php">
	Password: <input type="password" name="password"><br>
	<input type="submit" name="submit" value="Submit">
	</form>
<?
}

get_root_footer();
?>
