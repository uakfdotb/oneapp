<?php
include("../config.php");
include("../include/common.php");
include("../include/db_connect.php");
include("../include/session.php");

include("../include/purchase.php");

if(isset($_SESSION['admin'])) {
	$club_id = $_SESSION['admin_club_id'];
	$user_id = $_SESSION['user_id'];
	
	if($club_id != 0) {
		//validate purchase order
		$name = authenticatePurchase($_REQUEST['id'],$_REQUEST['club_id'])
		if($name !== FALSE) {
			$message = "";
			if(isset($_REQUEST['submit'])) {
				$data = processSubmission($_REQUEST);
				$submitResult = submitPurchase($_REQUEST['id'], $data);
			
				if($submitResult == 0) $message = "Purchase Order submitted successfully";
				else if($submitResult == -1) $message = "Error: already submitted.";
				else if($submitResult == -2) $message = "Error: internal error.";
				else if($submitResult == -3) $message = "Error: form is incomplete.";
			}
		
			get_page("purchase_create", array("id" => $_REQUEST['id'], "message" => $message, "club_id" => $_REQUEST['club_id']));
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
