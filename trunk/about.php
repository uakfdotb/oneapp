<?php
include("include/common.php");
include("config.php");
include("include/db_connect.php");
include("include/session.php");
$dbpage = "about";


get_page('about', array('dbpage' => $dbpage));
?>
