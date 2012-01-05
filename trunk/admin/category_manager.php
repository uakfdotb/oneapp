<?php

//not a security risk because they can see categories by logging in anyway
// if they access this directly they can't do very much

$database = "supplements";
$whereString = "club_id = '$club_id'";
$categories = array();

if($club_id == 0) {
	$database = "baseapp";

	if(isset($_REQUEST['category'])) {
		$_SESSION['category'] = escape($_REQUEST['category']);
	} else if(!isset($_SESSION['category'])) {
		$_SESSION['category'] = 0;
	}

	$whereString = "category = '" . $_SESSION['category'] . "'";

	//allow user to select category
	$result = mysql_query("SELECT id,name FROM basecat ORDER BY orderId");
	$categories[0] = "Profile";
	$categories[-1] = "Recommendation";
	
	while($row = mysql_fetch_array($result)) {
		$categories[$row['id']] = $row['name'];
	}
} else {
	$_SESSION['category'] = -2;
}

?>
