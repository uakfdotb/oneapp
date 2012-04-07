<?php
include("../config.php");
include("../include/common.php");
include("../include/db_connect.php");
include("../include/session.php");

include("../include/backup.php");

if(isset($_SESSION['root'])) {
	$backupLink = FALSE;
	
	if(isset($_REQUEST['backup'])) {
//do nothing
	}
	
	get_page_advanced("backup", "root", array('backupLink' => $backupLink));
} else {
	header('Location: index.php');
}
?>
