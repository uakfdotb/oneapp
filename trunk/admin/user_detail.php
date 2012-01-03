<?php
include("../config.php");
include("../include/common.php");
include("../include/db_connect.php");
include("../include/session.php");

get_admin_header();

if(isset($_SESSION['admin_id']) && isset($_REQUEST['id'])) {
	//todo: admins currently can get information of users that didn't apply to their club
	$user_id = escape($_REQUEST['id']);
	$userinfo = getUserInformation($user_id); //userinfo is array(username, email)
	$username = $userinfo[0];
	$profile = getProfile($user_id);
	
	echo "<b>Username</b>: $username<br>";
	
	foreach($profile as $item) {
		echo "<b>" . $item[0] . "</b>: " . $item[1] . "<br>";
	}
}
else{

      header('Location: index.php?action=logout&ex=.php');
}


get_admin_footer();
?>
