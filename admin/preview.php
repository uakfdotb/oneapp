<html>
<body>
<h2>Hello, Administrator</h2>

<?php
include("../config.php");
include("../include/common.php");
include("../include/db_connect.php");
include("../include/session.php");

include("../include/apply_gen.php");

if(isset($_SESSION['admin_id'])) {
	$club_id = escape(getAdminClub($_SESSION['admin_id']));
	
	$database = "supplements";
	$whereString = "club_id = '$club_id'";
	
	if($club_id == 0) { //use category instead of club_id if we're dealing with the base application
		$database = "baseapp";
		
		if(isset($_REQUEST['category'])) {
			$category = escape($_REQUEST['category']);
		} else {
			$category = 0;
		}
		
		$whereString = "category = '$category'";
		
		//allow user to select category
		echo '<form method="get" action="preview.php">';
		echo '<select name="category">';
		echo '<option value="0">Profile</option>';
		echo '<option value="-1">Recommendation</option>';
		
		$result = mysql_query("SELECT id,name FROM basecat");
		while($row = mysql_fetch_array($result)) {
			$selectedString = "";
			if($row['id'] == $category) {
				$selectedString = " selected";
			}
			echo '<option value="' . $row['id'] . '"' . $selectedString . '>' . $row['name'] . '</option>';
		}
		
		echo '</select><input type="submit" value="Set category"></form>';
	}
	
	$result = mysql_query("SELECT varname, vardesc, vartype FROM $database WHERE $whereString ORDER BY orderId");
	
	while($row = mysql_fetch_array($result)) {
		writeField(0, 0, $row['varname'], $row['vardesc'], $row['vartype']);
	}
}
?>

<a href="./">back</a>
</body>
</html>
