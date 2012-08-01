<?php
include("../include/common.php");
include("../config.php");
include("../include/db_connect.php");
include("../include/session.php");

include("../include/recommend.php");
include("../include/custom.php");

if(isset($_SESSION['user_id'])) {
	$inform = array();
	
	if(isset($_REQUEST['name']) && isset($_REQUEST['email']) && isset($_REQUEST['message'])) {
		$requestResult = requestRecommendation($_SESSION['user_id'], $_REQUEST['name'], $_REQUEST['email'], $_REQUEST['message']);
		
		if($requestResult == 0) $inform["success"] = "Recommendation request sent successfully to " . $_REQUEST['name'] . "!";
		else if($requestResult == 1) $inform["error"] = "Invalid email address (" . $_REQUEST['email'] . ") provided.";
		else if($requestResult == 2) $inform["error"] = "Invalid name (" . $_REQUEST['name'] . ") provided!";
		else if($requestResult == 3) $inform["error"] = "Internal Error! Do not re-attempt! Contact us instead!";
		else if($requestResult == 4) $inform["error"] = "You have requested too many recommendations!";
		else if($requestResult == 5) $inform["error"] = "The email address provided has already received a recommendation request from you!";
	} else if(isset($_REQUEST['toggle']) && isset($_REQUEST['id'])) {
		$result = toggleRecommendation($_SESSION['user_id'], $_REQUEST['id']);
		if($result===FALSE) {
			$inform["warning"] = "Recommendation has not yet been recieved!";
		} else {
			$inform["success"] = "Recommendation status changed!";
		}
	}
	
	$recList = listRecommendations($_SESSION['user_id']);
	
	$info = getUserInformation($_SESSION['user_id']);
	$name = $info[2];
	get_page_advanced("peer", "apply", array("recList" => $recList, "name" => $name, "inform" => $inform));
} else {
	get_page_advanced("message", "apply", array("title" => "Not Logged In", "message" => "You cannot access the application because you are not logged in. Please <a href=\"../login.php\">login first</a>."));
}

?>
