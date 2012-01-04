<?php
include("../config.php");
include("../include/common.php");
include("../include/db_connect.php");
include("../include/session.php");

get_root_header();

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
		echo '<form action="man_admins.php?action=add" method="post"><table class="borderon" align="center">';
		echo '<tr><td align="right"><p class="messpart">Admin username</p></td><td><input type="text" name="username" style="width:100%"></td></tr>';
		echo '<tr><td align="right"><p class="messpart">Password</p></td><td><input type="password" name="password" style="width:100%"></td></tr>';
		echo '<tr><td align="right"><p class="messpart">Email address</p></td><td><input type="text" name="email" style="width:100%"></td></tr>';
		echo '<tr><td align="right"><p class="messpart">Club ID</p></td><td><input type="text" name="club_id" style="width:100%"></td></tr>';
		echo '<tr><td align="right" colspan="2"><input type="submit" value="Add admin"></td></tr>';
		echo '</table></form><br><br>';
		
		echo "<table width=100%><tr><th><p class=\"mess\">Username</th></p><th><p class=\"mess\">Email</p></th><th><p class=\"mess\">Club ID</p></th><th><p class=\"mess\">Change pass</p></th><th><p class=\"mess\">Update</p></th><th><p class=\"mess\">Delete</p></th></tr>";
		
		while($row = mysql_fetch_array($result)) {
			echo "<form method=\"post\" action=\"man_admins.php\">";
			echo "<input type=\"hidden\" name=\"id\" value=\"" . $row['id'] . "\">";
			echo "<tr><td><input type=\"text\" name=\"username\" value=\"" . $row['username'] . "\" style=\"width:100%\"></td>";
			echo "<td><input type=\"text\" name=\"email\" value=\"" . $row['email'] . "\" style=\"width:100%\"></td>";
			echo "<td><input type=\"text\" name=\"club_id\" value=\"" . $row['club_id'] . "\" style=\"width:100%\"></td>";
			echo "<td><input type=\"password\" name=\"password\" style=\"width:100%\"></td>";
			echo "<td><input type=\"submit\" name=\"action\" value=\"update\"></td>";
			echo "<td><input type=\"submit\" name=\"action\" value=\"delete\"></td>";
			echo "</tr></form>";
		}
		
		echo "</table>";
	}
}

get_root_footer();
?>
