<?php
include("../config.php");
include("../include/common.php");
include("../include/db_connect.php");
include("../include/session.php");

include("../include/chk.php");

get_root_header();

if(isset($_SESSION['root'])) {
	if(isset($_REQUEST['delete'])) {
		checkNoHome();
	}

?>

<form method="post" action="check_nohome.php">
<input type="submit" name="delete" value="Delete questions whose club/category has been deleted" />
</form>

<?
}
get_root_footer();
?>
