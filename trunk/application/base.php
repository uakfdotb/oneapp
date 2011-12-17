<?php
include("../include/common.php");
include("../config.php");
include("../include/db_connect.php");
include("../include/session.php");

include("../include/apply_submit.php");

if(isset($_SESSION['user_id'])) {
	if(isApplicationStarted($_SESSION['user_id'], 0)) {
		$categoryList = listCategories();
		get_page_apply("base", array("categories" => $categoryList));
	} else {
		if(isset($_REQUEST['action']) && $_REQUEST['action'] == "start") {
			$result = startApplication($_SESSION['user_id'], 0);
			
			if($result) {
				get_page("message", array("stylepath" => "../style", "title" => "General application started", "message" => "You have started the general application. Please <a href=\"base.php\">click here</a> to continue."));
			} else {
				get_page("message", array("stylepath" => "../style", "title" => "Error", "message" => "There was an error while starting your general application. Please <a href=\"base.php\">click here</a> to continue."));
			}
		} else {
			get_page_apply("base_notstarted");
		}
	}
} else {
	get_page("message", array("stylepath" => "../style", "title" => "Not Logged In", "message" => "You cannot access the application because you are not logged in. Please <a href=\"../login.php\">login first</a>."));
}

?>
