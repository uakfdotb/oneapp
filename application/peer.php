<?php
include("../include/common.php");
include("../config.php");
include("../include/db_connect.php");
include("../include/session.php");

include("../include/recommend.php");

if(isset($_SESSION['user_id'])) {
	$message = "";
	
	if(isset($_REQUEST['name']) && isset($_REQUEST['email']) && isset($_REQUEST['message'])) {
		$requestResult = requestRecommendation($_SESSION['user_id'], $_REQUEST['name'], $_REQUEST['email'], $_REQUEST['message']);
		
		if($requestResult == 0) $message = "Recommendation request sent successfully!";
		else if($requestResult == 1) $message = "Error: invalid email address provided.";
		else if($requestResult == 2) $message = "Error: invalid name provided.";
		else if($requestResult == 3) $message = "Error: error while sending email (do not re-attempt; contact us instead).";
		else if($requestResult == 4) $message = "Error: you have requested too many recommendations already.";
		else if($requestResult == 5) $message = "Error: the email address provided has already received a recommendation result from you.";
	}
	
	$recList = listRecommendations($_SESSION['user_id']);
	get_page_apply("peer", array("recList" => $recList, "message" => $message));
} else {
	get_page_apply("message", array("title" => "Not Logged In", "message" => "You cannot access the application because you are not logged in. Please <a href=\"../login.php\">login first</a>."));
}

?>
