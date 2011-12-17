<html>
<body>

<?php
include("header.php");
include("../config.php");
include("../include/common.php");
include("../include/db_connect.php");
include("../include/session.php");

if(isset($_SESSION['root'])) {
	if(isset($_REQUEST['action'])) {
		$action = $_REQUEST['action'];
		
		if($action == 'add') {
			addAdmin($_REQUEST['username'], $_REQUEST['password'], $_REQUEST['email'], $_REQUEST['club_id']);
			echo "Admin added successfully! Click <a href=\"man_admins.php\">here</a> to continue.";
		} else if($action == 'delete') {
			$admin_id = escape($_REQUEST['id']);
			mysql_query("DELETE FROM admins WHERE id='$admin_id'");
			echo "Admin deleted successfully! Click <a href=\"man_admins.php\">here</a> to continue.";
		} else if($action == 'update') {
			updateAdmin($_REQUEST['id'], $_REQUEST['username'], $_REQUEST['password'], $_REQUEST['email'], $_REQUEST['club_id']);
			echo "Admin updated successfully! Click <a href=\"man_admins.php\">here</a> to continue.";
		}
	} else {
		$result = mysql_query("SELECT id,club_id,username,email FROM admins");
		
		echo '<form action="man_admins.php?action=add" method="post">';
		echo 'Admin username<input type="text" name="username">';
		echo '<br>Password <input type="password" name="password">';
		echo '<br>Email address <input type="text" name="email">';
		echo '<br>Club ID <input type="text" name="club_id">';
		echo '<br><input type="submit" value="Add admin">';
		echo '</form>';
		
		echo "<table><tr><th>Username</th><th>Email</th><th>Club ID</th><th>Change pass</th><th>Update</th><th>Delete</th></tr>";
		
		while($row = mysql_fetch_array($result)) {
			echo "<form method=\"post\" action=\"man_admins.php\">";
			echo "<input type=\"hidden\" name=\"id\" value=\"" . $row['id'] . "\">";
			echo "<tr><td><input type=\"text\" name=\"username\" value=\"" . $row['username'] . "\"></td>";
			echo "<td><input type=\"text\" name=\"email\" value=\"" . $row['email'] . "\"></td>";
			echo "<td><input type=\"text\" name=\"club_id\" value=\"" . $row['club_id'] . "\"></td>";
			echo "<td><input type=\"password\" name=\"password\"></td>";
			echo "<td><input type=\"submit\" name=\"action\" value=\"update\"></td>";
			echo "<td><input type=\"submit\" name=\"action\" value=\"delete\"></td>";
			echo "</tr></form>";
		}
		
		echo "</table>";
	}
}
?>

</body>
</html>
