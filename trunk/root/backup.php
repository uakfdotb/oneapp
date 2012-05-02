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
			$success = "Backup created!";
		} else {
			$error = "Something went wrong! If this continues, contact us!";
		}
	}
	
	if(isset($success)) {
		get_page_advanced("backup", "root", array('backupLink' => $backupLink, 'success' =>$success ));
	} else if(isset($error)) {
		get_page_advanced("backup", "root", array('backupLink' => $backupLink, 'error' =>$error ));
	} else if(isset($warning)) {
		get_page_advanced("backup", "root", array('backupLink' => $backupLink, 'warning' =>$warning ));
	} else if(isset($info)) {
		get_page_advanced("backup", "root", array('backupLink' => $backupLink, 'info' =>$info ));
	} else {
		get_page_advanced("backup", "root", array('backupLink' => $backupLink));
	}
} else {
	header('Location: index.php');
}
?>
