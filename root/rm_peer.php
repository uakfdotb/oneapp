<?php
include("../config.php");
include("../include/common.php");
include("../include/db_connect.php");
include("../include/session.php");

include("../include/recommend.php");
include("../include/custom.php");

if(isset($_SESSION['root'])) {
	$recommendationResult = FALSE;
	$user_id = -1;
	
	if(isset($_REQUEST['user_id'])) {
		$user_id = escape($_REQUEST['user_id']);
		
		if(isset($_REQUEST['remove_id'])) {
			$recommend_id = escape($_REQUEST['remove_id']);
			
			//get instance id
			$result = mysql_query("SELECT instance_id from recommendations WHERE id = '$recommend_id'");
			
			if($row = mysql_fetch_row($result)) {
				$instance_id = $row[0];
				mysql_query("DELETE FROM recommendations WHERE id = '$recommend_id'");
				customDestroy($instance_id);
			}
		}
		
		$recommendationResult = mysql_query("SELECT * FROM recommendations WHERE user_id = '$user_id'");
	}
	
	$result = mysql_query("SELECT id,username FROM users ORDER BY id");
	get_page_advanced("rm_peer", "root", array('user_id' => $user_id, 'recommendationResult' => $recommendationResult, 'userdata' => $result));
} else {
	header('Location: index.php');
}
?>
