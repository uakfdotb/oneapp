<?php
include("../config.php");
include("../include/common.php");
include("../include/db_connect.php");
include("../include/session.php");

if(isset($_SESSION['admin_id']) && isset($_REQUEST['id'])) {
	//todo: admins currently can get information of users that didn't apply to their club
	$user_id = escape($_REQUEST['id']);
	$userinfo = getUserInformation($user_id); //userinfo is array(username, email)
	$username = $userinfo[0];
	$profile = getProfile($user_id);
	
	get_page_advanced("user_detail", "admin", array('username' => $username, 'profile' => $profile));
} else {
	header('Location: index.php');
}
?>
