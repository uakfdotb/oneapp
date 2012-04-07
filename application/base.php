<?php
include("../include/common.php");
include("../config.php");
include("../include/db_connect.php");
include("../include/session.php");

include("../include/apply_gen.php");
include("../include/apply_submit.php");

if(isset($_SESSION['user_id'])) {
	$categoryList = listCategories();
	if(isApplicationStarted($_SESSION['user_id'], 0)) {
		get_page_advanced("base", "apply", array("categories" => $categoryList));
	} else {
		if(isset($_REQUEST['action']) && $_REQUEST['action'] == "start") {
			$result = startApplication($_SESSION['user_id'], 0);
			if($result == 0) {
				$success = "General application started!";
				get_page_advanced("base","apply", array("success" => $success, "categories" => $categoryList));
			} else {
				$error = "General application not started! There was an error while starting your general application.";
				get_page_advanced("base","apply", array("error" => $error));
			}
		} else {
			$warning = "You have not yet started the general application!";
			get_page_advanced("base_notstarted", "apply", array("warning" => $warning));
		}
	}
} else {
	get_page_advanced("message", "apply", array("title" => "Not Logged In", "message" => "You cannot access the application because you are not logged in. Please <a href=\"../login.php\">login first</a>."));
}

?>
