<?php
include("../config.php");
include("../include/common.php");
include("../include/db_connect.php");
include("../include/session.php");

include("../include/purchase.php");
include("../include/apply_gen.php");
include("../include/apply_submit.php");
include("../include/latex.php");
include("../include/custom.php");

if(isset($_SESSION['admin'])) {
	$club_id = $_SESSION['admin_club_id'];
	$user_id = $_SESSION['user_id'];
	
	if($club_id != 0) {
		//validate purchase order
		$name = authenticatePurchase($_REQUEST['id'],$_REQUEST['club_id']);
		if($name !== FALSE) {
			if(isset($_REQUEST['submit'])) {
				$data = processSubmission($_REQUEST);
				$submitResult = submitPurchase($_REQUEST['id'], $data);
			
				if($submitResult == 0) $success = "Purchase Order submitted successfully";
				else if($submitResult == -1) $error = "Error: already submitted.";
				else if($submitResult == -2) $error = "Error: internal error.";
				else if($submitResult == -3) $error = "Error: form is incomplete.";
				else if($submitResult == -4) $error = "Error: form is not.";
			}
			
			if(isset($success)) {
				get_page_advanced("purchase_create", "admin", array("id" => $_REQUEST['id'], 'success' => $success, "club_id" => $_REQUEST['club_id']));
			} else if(isset($error)) {
				get_page_advanced("purchase_create", "admin", array("id" => $_REQUEST['id'], 'error' => $error, "club_id" => $_REQUEST['club_id']));
			} else {
				get_page_advanced("purchase_create", "admin", array("id" => $_REQUEST['id'], "club_id" => $_REQUEST['club_id']));
			}
		
		} else {
			get_page("message", array("title" => "Error", "message" => "The data provided appears to be invalid. This page is for the submission of purchase orders. If you believe you are receiving this message in error, have not received an email, or are experiencing technical difficulties, please contact us."));
		}
	} else {
		get_page_advanced("message", "admin", array('message' => "General application admin does not have a club to manage.", 'title' => "View submissions"));
	}
} else {
	header('Location: index.php?error=' . urlencode("You are not logged in!"));
}
?>
