<?php
include("../config.php");
include("../include/common.php");
include("../include/db_connect.php");
include("../include/session.php");

include("../include/recommend.php");

if(isset($_SESSION['root'])) {
	$recommendationResult = FALSE;
	$user_id = -1;
	
	if(isset($_REQUEST['user_id'])) {
		$user_id = escape($_REQUEST['user_id']);
		
		if(isset($_REQUEST['remove_id'])) {
			$recommend_id = escape($_REQUEST['remove_id']);
			
			mysql_query("DELETE FROM recommender_answers WHERE recommend_id = '$recommend_id'");
			mysql_query("DELETE FROM recommendations WHERE id = '$recommend_id'");
		}
		
		$result = mysql_query("SELECT * FROM recommendations WHERE user_id = '$user_id'");
	}
	
	get_page_advanced("rm_peer", "root", array('user_id' => $user_id, 'recommendationResult' => $recommendationResult));
} else {
	header('Location: index.php');
}
?>
