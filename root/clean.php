<?php
include("../config.php");
include("../include/common.php");
include("../include/db_connect.php");
include("../include/session.php");

include("../include/statistics.php");

if(isset($_SESSION['root'])) {
	get_page_advanced("clean", "root");
} else {
	header('Location: index.php');
}
?>
