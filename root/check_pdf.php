<?php
include("../config.php");
include("../include/common.php");
include("../include/db_connect.php");
include("../include/session.php");

include("../include/chk.php");

if(isset($_SESSION['root'])) {
	$pdfArray = false;
	
	if(isset($_REQUEST['delete'])) {
		checkExtraPDFs(true);
	} else {
		$pdfArray = checkExtraPDFs();
	}
	
	get_page_advanced("check_pdf", "root", array('pdfArray' => $pdfArray));
}
?>
