<?php
include("../config.php");
include("../include/common.php");
include("../include/db_connect.php");
include("../include/session.php");

if(isset($_SESSION['root']) && isset($_REQUEST['id'])) {
	//this is copied from admin's user_detail...
	$user_id = escape($_REQUEST['id']);
	$userinfo = getUserInformation($user_id); //userinfo is array(username, email, name)
	$profile = getProfile($user_id);
	
	get_page_advanced("user_detail", "root", array('username' => $userinfo[0], 'email' => $userinfo[1], 'name' => $userinfo[2], 'profile' => $profile));
} else {
	header('Location: index.php');
}
?>
