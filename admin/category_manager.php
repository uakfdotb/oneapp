<?php

//not a security risk because they can see categories by logging in anyway
// if they access this directly they can't do very much

$database = "supplements";
$whereString = "club_id = '$club_id'";
$categories = array();

if($club_id == 0) { //general application
	$database = "baseapp";

	if(isset($_REQUEST['category'])) {
		$_SESSION['category'] = escape($_REQUEST['category']);
	} else if(!isset($_SESSION['category'])) {
		$_SESSION['category'] = 0;
	}

	$whereString = "category = '" . $_SESSION['category'] . "'";

	//allow user to select category
	$result = mysql_query("SELECT id, name FROM basecat ORDER BY orderId");
	$categories[0] = "Profile";
	
	while($row = mysql_fetch_array($result)) {
		$categories[$row['id']] = $row['name'];
	}
} else if($club_id == -2) { //custom fields
	$database = "custom";
	
	if(isset($_REQUEST['category'])) {
		$_SESSION['category'] = escape($_REQUEST['category']);
	} else if(!isset($_SESSION['category'])) {
		$_SESSION['category'] = 1;
	}
	
	$whereString = "category = '" . $_SESSION['category'] . "'";

	//allow user to select category
	$result = mysql_query("SELECT id, name FROM custom_cat");
	
	while($row = mysql_fetch_array($result)) {
		$categories[$row['id']] = $row['name'];
	}
} else {
	$_SESSION['category'] = -2;
}

?>
