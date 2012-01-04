<?php
include("include/common.php");
include("config.php");
include("include/db_connect.php");
include("include/session.php");

include("include/apply_submit.php");

if(isset($_REQUEST['id'])) {
	$clubInfo = clubInfo($_REQUEST['id']);
	get_page('affclubs_info', array('clubInfo' => $clubInfo));
} else {
	$clubList = listClubs(true);
	get_page('affclubs', array('clubList' => $clubList));
}
?>
