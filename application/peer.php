<?php
include("../include/common.php");
include("../config.php");
include("../include/db_connect.php");
include("../include/session.php");

include("../include/recommend.php");

if(isset($_SESSION['user_id'])) {
	
	if(isset($_REQUEST['name']) && isset($_REQUEST['email']) && isset($_REQUEST['message'])) {
		$requestResult = requestRecommendation($_SESSION['user_id'], $_REQUEST['name'], $_REQUEST['email'], $_REQUEST['message']);
		
		if($requestResult == 0) $success = "Recommendation request sent successfully!";
		else if($requestResult == 1) $error = "Invalid email address provided.";
		else if($requestResult == 2) $error = "Invalid name provided.";
		else if($requestResult == 3) $error = "Error while sending email (do not re-attempt; contact us instead).";
		else if($requestResult == 4) $error = "You have requested too many recommendations! See help if you have more issues.";
		else if($requestResult == 5) $error = "The email address provided has already received a recommendation result from you.";
	} else if(isset($_REQUEST['toggle']) && isset($_REQUEST['id'])) {
		toggleRecommendation($_SESSION['user_id'], $_REQUEST['id']);
	}
	
	$recList = listRecommendations($_SESSION['user_id']);
	if(count($recList)==0) $info="You currently have not requested any recommendations!";
	if(isset($success)){
		get_page_advanced("peer", "apply", array("recList" => $recList, "success" => $success));
	} else if(isset($error)){
		get_page_advanced("peer", "apply", array("recList" => $recList, "error" => $error));
	} else if(isset($info)){
		get_page_advanced("peer", "apply", array("recList" => $recList, "info" => $info));
	} else {
		get_page_advanced("peer", "apply", array("recList" => $recList));
	}
} else {
	get_page_advanced("message", "apply", array("title" => "Not Logged In", "message" => "You cannot access the application because you are not logged in. Please <a href=\"../login.php\">login first</a>."));
}

?>
