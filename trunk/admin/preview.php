<?php
include("../config.php");
include("../include/common.php");
include("../include/db_connect.php");
include("../include/session.php");

include("../include/apply_gen.php");
include("../include/latex.php");

if(isset($_SESSION['admin'])) {
	$club_id = $_SESSION['admin_club_id'];
	include("category_manager.php");
	
	$result = mysql_query("SELECT varname, vardesc, vartype FROM $database WHERE $whereString ORDER BY orderId");
	$questionList = array();

	while($row = mysql_fetch_array($result)) {
		array_push($questionList, array($row[0], $row[1], $row[2]));
	}
	$message = "";	
	if(isset($_REQUEST['gen'])) {
		$result = mysql_query("SELECT varname, vardesc, vartype, '' FROM $database WHERE $whereString ORDER BY orderId");
		if($club_id != 0) {
			$whereString = "id = '" . $club_id . "'";
			
			$clubInfo = clubInfo($club_id); //array (club name, club description, open_time, close_time, num_recommendations)
			$sectionheader = "Supplement: " . $clubInfo[0];
		} else {
			$sectionheader = "General Application";
		}
		$createResult = generatePDFByResult($result, "../pdf/", $sectionheader);
	
		if(!$createResult[0]) {
			$error = "Error during PDF generation: " . $createResult[1];
		} else {
			$basePath = basePath();
			$style = getStyle();
			$stylePath = $basePath . "/astyle/$style";
			$message = "<a href=\"../pdf/" . $createResult[1] . ".pdf\"><div class=\"nav-button-vertical small right\"><div class=\"pdf\" ></div></div></a>";
			$success="PDF made!";
		}
	}
	
	//categories list comes from the category manager
	if(isset($error)) {
		get_page_advanced("preview", "admin", array('questionList' => $questionList, 'categories' => $categories, 'error' => $error, 'message' => $message, 'categories' => $categories));
	} else if(isset($success)) {
		get_page_advanced("preview", "admin", array('questionList' => $questionList, 'categories' => $categories, 'success' => $success, 'message' => $message, 'categories' => $categories));
	} else {
		get_page_advanced("preview", "admin", array('questionList' => $questionList, 'categories' => $categories, 'message' => $message, 'categories' => $categories));
	}
} else {
	header('Location: index.php?error=' . urlencode("You are not logged in!"));
}
?>
