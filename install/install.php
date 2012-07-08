<?php
include("../include/common.php");
include("../config.php");
include("../include/db_connect.php");
include("../include/session.php");

include("../include/messaging.php");

//warning message
?>
<font color="red">WARNING: after installation is complete, you should delete the install directory.</font><br />
You may also wish to:

<ul>
<li><a href="../config_check.php">Check your configuration</a> (delete this file after you're done, too)</li>
<li><a href="../root/">Login to the root administration area</a></li>
<li><a href="http://xkcd.com/">Read XKCD</a></li>
</ul>

<hl>

<?
//create the tables if they haven't been created already
$fh = fopen("../install.sql", 'r');

if($fh) {
	echo "Creating tables (if they haven't been created already)<br />";
	
	while (($line = fgets($fh)) !== false) {
		$line = trim($line);
		if($line !== '') {
			mysql_query($line) or die("There was an error while attempting to create the oneapp tables.<br />" . mysql_error());
		}
	}
} else {
	die("Error: could not read from the install.sql file!");
}

//make sure that users aren't set up yet
echo "Checking users table<br />";
$result = mysql_query("SELECT COUNT(*) FROM users");
$row = mysql_fetch_row($result);

if($row[0] == 0) {
	echo "Creating site administrative user (username=admin, password is blank)<br />";
	
	mysql_query("INSERT INTO users (username, password, name, email, register_time, accessed) VALUES ('admin', '" . chash("") . "', 'Site Administrator', 'admin@example.com', '0', '0')");
	$admin_id = escape(mysql_insert_id());
	mysql_query("INSERT INTO user_groups (user_id, `group`) VALUES ('$admin_id', '0')");
	mysql_query("INSERT INTO user_groups (user_id, `group`) VALUES ('$admin_id', '-1')");
	
	initMessaging($admin_id);
	
	echo "<font color=\"green\">Installation is complete.</font>";
} else {
	die("Error: at least one user has been created. For security reasons, the users table must be empty to run this installation script.");
}

?>
