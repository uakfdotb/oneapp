<?php
include("../config.php");
include("../include/common.php");
include("../include/db_connect.php");
include("../include/session.php");

include("../include/apply_gen.php");
include("../include/latex.php");

if(isset($_SESSION['admin_id'])) {
	$club_id = escape(getAdminClub($_SESSION['admin_id']));
	include("category_manager.php"); //sets database and whereString based on club/category
	
	$message = "";
	
	if(isset($_REQUEST['gen'])) {
		$result = mysql_query("SELECT varname, vardesc, vartype, '' FROM $database WHERE $whereString ORDER BY orderId");
		if($club_id != 0){
		       $whereString = "id = '" . $club_id . "'";
		       //$sectionheader = mysql_query("SELECT name FROM clubs WHERE $whereString");
		       $sectionheader = "Supplement";
		} else {
		       $section_id=$_SESSION['category'];
		       //$sectionheader = mysql_query("SELECT name FROM basecat where id='$section_id'");
		       $sectionheader = "General Application";
		}
		$createResult = generatePDFByResult($result, "../pdf/", $sectionheader);
	
		if(!$createResult[0]) {
			$message = "Error during PDF generation: " . $createResult[1];
		} else {
			$message = "PDF saved (<a href=\"../pdf/" . $createResult[1] . ".pdf\">link</a>)";
		}
	}
	
	get_page_advanced("gen_pdf", "admin", array('message' => $message, 'categories' => $categories));
} else {
	header('Location: index.php?error=' . urlencode("You are not logged in!"));
}
?>
