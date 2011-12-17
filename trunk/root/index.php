<html>
<body>

<?php
include("../include/common.php");
include("../config.php");
include("../include/db_connect.php");
include("../include/session.php");

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
   include("header.php");
} else {
?>
    <form method="POST" action="index.php">
    Password: <input type="password" name="password"><br>
    <input type="submit" name="submit" value="Submit">
    </form>
<?
}
?>
</body>
</html>
