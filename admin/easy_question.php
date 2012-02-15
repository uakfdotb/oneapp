<?php
include("../config.php");
include("../include/common.php");
include("../include/db_connect.php");
include("../include/session.php");

include("../include/apply_gen.php");
include("../include/latex.php");

if(isset($_SESSION['admin_id'])) {
	$club_id = escape(getAdminClub($_SESSION['admin_id']));
	
	if(isset($_REQUEST['type'])) {
		if(isset($_REQUEST['done'])) {
			$type = trim($_REQUEST['type']);
			$name = trim($_REQUEST['name']);
			if(strlen($name)<=1){
				$name = " ";
			}

			$description = str_replace("\r", "", trim($_REQUEST['description']));
			if($type == "select") $description = str_replace("\n", "; ", $description);
			if(strlen($description)<=1){
				$description = " ";
			}

			$status = "optional";
			if(isset($_REQUEST['status'])) $status = trim($_REQUEST['status']);
			
			$showchars = "false";
			if(isset($_REQUEST['showchars'])) $showchars = trim($_REQUEST['showchars']);
			
			$length = 10000;
			if(isset($_REQUEST['length'])) $length = trim($_REQUEST['length']);
			
			$method = "";
			if(isset($_REQUEST['method'])) $method = trim($_REQUEST['method']);
			
			$size = "medium";
			if(isset($_REQUEST['size'])) $size = trim($_REQUEST['size']);

			$generate = $name . "\n";
			$generate .= $description . "\n";
			$generate .= "type:$type; status:$status";
			if($type=="essay" || $type=="short") {
				$generate .= "; showchars:$showchars; length:$length; size:$size";
			} else if($type=="select") {
				   $generate .= "; method:$method";
			}
			get_page_advanced("easyq_generated", "admin", array('generate' => $generate));
		} else {
			get_page_advanced("easyq_question", "admin", array('type' => $_REQUEST['type']));
		}
	} else {
		get_page_advanced("easyq_type", "admin");
	}
} else {
	header('Location: index.php?error=' . urlencode("You are not logged in!"));
}
?>
