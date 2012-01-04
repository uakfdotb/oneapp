<?php
include("../config.php");
include("../include/common.php");
include("../include/db_connect.php");
include("../include/session.php");

include("../include/chk.php");

get_root_header();

if(isset($_SESSION['root'])) {
	if(isset($_REQUEST['delete'])) {
		checkExtraPDFs(true);
	} else {
		$pdfArray = checkExtraPDFs();
		
		echo "<ul>";
		foreach($pdfArray as $path) {
			echo "<li><a href=\"$path\">$path</a></li>";
		}
		echo "</ul>";
	}

?>

<form method="post" action="check_pdf.php">
<input type="submit" name="delete" value="Delete extra PDFs" />
</form>

<?
}
get_root_footer();
?>
