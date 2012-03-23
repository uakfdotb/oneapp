<?php
include("../config.php");
include("../include/common.php");
include("../include/db_connect.php");
include("../include/session.php");

if(isset($_SESSION['root']) && isset($_REQUEST['cat'])) {
	$cat = $_REQUEST['cat'];
	if(substr($cat, -4) == '.php') $cat = substr($cat, 0, -4);
	
	get_page_advanced("root_cat", "root", array('cat' => $cat));
} else {
	header('Location: index.php');
}
?>
