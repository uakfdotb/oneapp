<?php

//not a security risk because they can see categories by logging in anyway
// if they access this directly they can't do very much

$database = "baseapp";

if(isset($_REQUEST['category'])) {
	$category = escape($_REQUEST['category']);
} else {
	$category = 0;
}

$whereString = "category = '$category'";

//allow user to select category
echo '<form method="get" action="' . $_SERVER['REQUEST_URI'] . '">';
echo '<select name="category">';
echo '<option value="0">Profile</option>';
echo '<option value="-1">Recommendation</option>';

$result = mysql_query("SELECT id,name FROM basecat ORDER BY orderId");
while($row = mysql_fetch_array($result)) {
	$selectedString = "";
	if($row['id'] == $category) {
		$selectedString = " selected";
	}
	echo '<option value="' . $row['id'] . '"' . $selectedString . '>' . $row['name'] . '</option>';
}

echo '</select><input type="submit" value="Set category"></form>';

?>
