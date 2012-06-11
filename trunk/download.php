<?php
include("include/common.php");
include("config.php");
include("include/db_connect.php");
include("include/session.php");

$file = "submit/" . stripAlphaNumeric($_REQUEST['file']);
$filename = $_REQUEST['filename'];

if(file_exists($file)) {
	header('Content-Description: File Transfer');
	header('Content-Type: application/octet-stream');
	header('Content-Disposition: attachment; filename='.basename($filename));
	header('Content-Transfer-Encoding: binary');
	header('Expires: 0');
	header('Cache-Control: must-revalidate');
	header('Pragma: public');
	header('Content-Length: ' . filesize($file));
	ob_clean();
	flush();
	readfile($file);
} else {
	echo "Error: file not found!";
}

?>
