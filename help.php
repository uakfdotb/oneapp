<?php
include("include/common.php");
include("config.php");
include("include/db_connect.php");
include("include/session.php");

if(isset($_REQUEST['page'])) {
	$helpName = stripAlphaNumeric($_REQUEST['page']);
} else {
	$helpName = "index";
}

$helpPage = "doc/help/" . basename($helpName) . ".html";

if(file_exists($helpPage)) {
	get_page('help', array('helpName' => $helpName, 'helpPage' => $helpPage, 'helpContents' => file_get_contents($helpPage)));
} else {
	get_page('message', array('title' => 'Error', 'message' => 'Requested help page could not be found.'));
}
?>
