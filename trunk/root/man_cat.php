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
			$name = escape($_REQUEST['name']);
			
			mysql_query("INSERT INTO basecat (name) VALUES ('$name')");
			echo "Category added successfully! Click <a href=\"man_cat.php\">here</a> to continue.";
		} else if($action == 'delete') {
			$cat_id = escape($_REQUEST['id']);
			mysql_query("DELETE FROM basecat WHERE id='$cat_id'");
			echo "Category deleted successfully! Click <a href=\"man_cat.php\">here</a> to continue.";
		} else if($action == 'update') {
			$cat_id = escape($_REQUEST['id']);
			$name = escape($_REQUEST['name']);
			
			mysql_query("UPDATE basecat SET name='$name' WHERE id='$cat_id'");
			echo "Category name updated successfully! Click <a href=\"man_cat.php\">here</a> to continue.";
		}
	} else {
		$result = mysql_query("SELECT id,name FROM basecat");
		
		echo '<form action="man_cat.php?action=add" method="post">';
		echo 'Category name<input type="text" name="name">';
		echo '<input type="submit" value="Add category">';
		echo '</form>';
		
		echo "<table><tr><th>Category name</th><th>Update</th><th>Delete</th></tr>";
		
		while($row = mysql_fetch_array($result)) {
			echo "<form method=\"post\" action=\"man_cat.php\">";
			echo "<input type=\"hidden\" name=\"id\" value=\"" . $row['id'] . "\">";
			echo "<tr><td><input type=\"text\" name=\"name\" value=\"" . $row['name'] . "\"></td>";
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
