<?php
include("../config.php");
include("../include/common.php");
include("../include/db_connect.php");
include("../include/session.php");

if(isset($_SESSION['root'])) {
	$page = FALSE;
	$contents = FALSE;
	
	if(isset($_REQUEST['action']) && isset($_REQUEST['page'])) {
		$page = $_REQUEST['page'];
	
		if($_REQUEST['action'] == "Edit") {
			if(isset($_REQUEST['contents'])) {
				savePage($page, $_REQUEST['contents']);
			}
			
			$contents = page_db_part($page);
		} else if($_REQUEST['action'] == "Delete") {
			deletePage($page);
		} else if($_REQUEST['action'] == "add") {
			savePage($page, "");
		}
	}

	$result = mysql_query("SELECT name FROM pages");
	//we can't pass a variable named "page", so we set as "epage" for edit page
	get_page_advanced("man_pages", "root", array('epage' => $page, 'contents' => $contents, 'pagesResult' => $result));
}
?>
