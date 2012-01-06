<?php
include("include/common.php");
include("config.php");
include("include/db_connect.php");
include("include/session.php");

include("include/recommend.php");
include("include/apply_gen.php");
include("include/apply_submit.php");
include("include/latex.php");

if(isset($_SESSION['user_id'])) {
	get_page("message", array("title" => "Logged In", "message" => "You are already logged in (you must logout before you can submit a recommendation)! Click <a href=\"application/\">here</a> to continue."));
} else if(isset($_REQUEST['id']) && isset($_REQUEST['user_id']) && isset($_REQUEST['auth'])) {
	//validate the id, user_id, and auth
	$name = authenticateRecommendation($_REQUEST['id'], $_REQUEST['user_id'], $_REQUEST['auth']);
	if($name !== FALSE) {
		$message = "";
		if(isset($_REQUEST['submit'])) {
			$data = processSubmission($_REQUEST);
			$submitResult = submitRecommendation($_REQUEST['id'], $data);
			
			if($submitResult == 0) $message = "Recommendation submitted successfully";
			else if($submitResult == -1) $message = "Error: recommendation already submitted.";
			else if($submitResult == -2) $message = "Error: internal error.";
			else if($submitResult == -3) $message = "Error: recommendation form is incomplete.";
		}
		
		get_page("recommend", array("id" => $_REQUEST['id'], "message" => $message, "user_id" => $_REQUEST['user_id'], "auth" => $_REQUEST['auth']));
	} else {
		get_page("message", array("title" => "Error", "message" => "The data provided appears to be invalid. This page is for the submission of peer recommendations. Please follow the link given in the email to submit a peer recommendation. If you believe you are receiving this message in error, have not received an email, or are experiencing technical difficulties, please contact us."));
	}
} else {
	get_page("message", array("title" => "Error", "message" => "This page is for the submission of peer recommendations. Please follow the link given in the email to submit a peer recommendation. If you believe you are receiving this message in error, have not received an email, or are experiencing technical difficulties, please contact us."));
}

?>
