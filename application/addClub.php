<?php
include("../include/common.php");
include("../config.php");
include("../include/db_connect.php");
include("../include/session.php");

include("../include/apply_gen.php");
include("../include/apply_submit.php");

if(isset($_SESSION['user_id'])) {
	
				$clubList = listClubs();
				$clubStart = array();
				$clubClose = array();
		
				foreach($clubList as $item) {
					$clubInfo = clubInfo($item[0]);
					$clubStart[$item[0]] = $clubInfo[2];
					$clubClose[$item[0]] = $clubInfo[3];
				}
				
				
	if(isset($_REQUEST['club'])) {
		$result = startApplication($_SESSION['user_id'], $_REQUEST['club']);
		if($result == 0) {
			$success = "Club added successfully!";
			get_page_advanced("addclub", "apply", array("clubs" => $clubList, 'clubStart' => $clubStart, 'clubClose' => $clubClose, 'success' => $success));
			//get_page_advanced("message", "apply", array("title" => "Club added successfully", "message" => "The requested club has been added successfully. You can view the <a href=\"clubs.php\">list of clubs</a> you are applying to or <a href=\"addClub.php\">add another club</a>.", "redirect" => "clubs.php"));
		} else if($result == -1) {
			$error = "Addition failed! This organization has already been added!";
			get_page_advanced("addclub", "apply", array("clubs" => $clubList, 'clubStart' => $clubStart, 'clubClose' => $clubClose, 'error' => $error));
			//get_page_advanced("message", "apply", array("title" => "Addition failed", "message" => "This club has already been added. Click <a href=\"clubs.php\">here</a> to return to the list of clubs you are applying to."));
		} else if($result == -2) {
			$error = "Addition failed! This organization does not exist!";
			get_page_advanced("addclub", "apply", array("clubs" => $clubList, 'clubStart' => $clubStart, 'clubClose' => $clubClose, 'error' => $error));
			//get_page_advanced("message", "apply", array("title" => "Addition failed", "message" => "The specified club does not exist. Click <a href=\"clubs.php\">here</a> to return to the list of clubs you are applying to."));
		} else if($result == -3) {
			$error = "Addition failed! This organization is currently unavailable!";
			get_page_advanced("addclub", "apply", array("clubs" => $clubList, 'clubStart' => $clubStart, 'clubClose' => $clubClose, 'error' => $error));
			//get_page_advanced("message", "apply", array("title" => "Addition failed", "message" => "The club is not available at this time. Click <a href=\"clubs.php\">here</a> to return to the list of clubs you are applying to."));
		} else {
			$error = "Addition failed! There was an error while adding $result!";
			get_page_advanced("addclub", "apply", array("clubs" => $clubList, 'clubStart' => $clubStart, 'clubClose' => $clubClose, 'error' => $error));
			//get_page_advanced("message", "apply", array("title" => "Addition failed", "message" => "There was an error while adding a club: $result. Click <a href=\"clubs.php\">here</a> to return to the list of clubs you are applying to."));
		}
	} else {
		get_page_advanced("addclub", "apply", array("clubs" => $clubList, 'clubStart' => $clubStart, 'clubClose' => $clubClose));
	}
} else {
	get_page_advanced("message", "apply", array("title" => "Not Logged In", "message" => "You cannot access the application because you are not logged in. Please <a href=\"../login.php\">login first</a>."));
}

?>
