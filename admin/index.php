<html>
<body>
<h2>Hello, Administrator</h2>

<?php
include("../config.php");
include("../include/common.php");
include("../include/db_connect.php");
include("../include/session.php");

if(isset($_REQUEST['username']) && isset($_REQUEST['password'])) {
	$checkResult = checkAdmin($_REQUEST['username'], $_REQUEST['password']);
    if($checkResult !== FALSE) {
    	$_SESSION['admin_id'] = $checkResult;
    	echo "Click <a href=\"index.php\">here</a> to continue.";
    } else {
        echo "Username or password is incorrect, or you have been locked out for multiple attempts. Click <a href=\"index.php\">here</a> to continue.";
    }
} else if(isset($_REQUEST['action'])) {
	if($_REQUEST['action'] == 'logout') {
		unset($_SESSION['admin_id']);
		echo "You are now logged out. Click <a href=\"index.php\">here</a> to continue.";
	}
} else if(isset($_SESSION['admin_id'])) {
    echo "<a href=\"man_questions.php\">Manage questions</a>";
    
    echo "<br><br><a href=\"index.php?action=logout\">Logout</a>";
} else {
?>

    <form method="POST" action="index.php">
    Username: <input type="text" name="username"><br>
    Password: <input type="password" name="password"><br>
    <input type="submit" name="submit" value="Submit">
    </form>

<?
}
?>

</body>
</html>
