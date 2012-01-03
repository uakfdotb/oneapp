<?php
include("../config.php");
include("../include/common.php");
include("../include/db_connect.php");
include("../include/session.php");

include("../include/apply_gen.php");
include("../include/latex.php");

get_admin_header();

if(isset($_SESSION['admin_id'])) {
	$club_id = escape(getAdminClub($_SESSION['admin_id']));
	
	$database = "supplements";
	$whereString = "club_id = '$club_id'";
	$catHidden = ""; //outputted for forms in case we need category specification
	
	if($club_id == 0) { //use category instead of club_id if we're dealing with the base application
		include("category_manager.php");
	}
	
	if(isset($_REQUEST['gen'])) {
		$result = mysql_query("SELECT varname, vardesc, vartype, '' FROM $database WHERE $whereString ORDER BY orderId");
		$createResult = generatePDFByResult($result, "../pdf/");
	
		if(!$createResult[0]) {
			echo "Error during PDF generation: " . $createResult[1];
		} else {
			echo "PDF saved (<a href=\"../pdf/" . $createResult[1] . ".pdf\">link</a>)";
		}
	}
	
	echo '<form method="post" action="gen_pdf.php">';
	echo $catHidden;
	echo '<input type="submit" name="gen" value="Generate">';
	echo '</form>';
} else {
	header('Location: index.php?error=' . urlencode("You are not logged in!"));
}

get_admin_footer();
?>
