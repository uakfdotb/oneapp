<?php
include("../config.php");
include("../include/common.php");
include("../include/db_connect.php");
include("../include/session.php");

include("../include/chk.php");

if(isset($_SESSION['root'])) {
	if(isset($_REQUEST['delete'])) {
		checkNoHome();
	}
	
	get_page_advanced("check_nohome", "root");
} else {
	header('Location: index.php');
}
?>
