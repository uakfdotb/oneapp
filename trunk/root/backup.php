<?php
include("../config.php");
include("../include/common.php");
include("../include/db_connect.php");
include("../include/session.php");

include("../include/backup.php");

if(isset($_SESSION['root'])) {
	$backupLink = FALSE;
	
	if(isset($_REQUEST['backup'])) {
		$dbResult = backupDatabase();
		$fileResult = backupFiles();
		
		if($fileResult !== false) {
			$backupLink = array($dbResult, $fileResult[0], $fileResult[1]);
		}
	}
	
	get_page_advanced("backup", "root", array('backupLink' => $backupLink));
} else {
	header('Location: index.php');
}
?>
