<?php
include("../config.php");
include("../include/common.php");
include("../include/db_connect.php");
include("../include/session.php");

//include("../include/purchase.php");

if(isset($_SESSION['admin'])) {
	$club_id = $_SESSION['admin_club_id'];
	$user_id = $_SESSION['user_id'];
	
	if($club_id != 0) {
		//retrieve and display purchase history
		$result = mysql_query("SELECT description, amount, submit_time, status FROM spending WHERE club_id='$club_id'");
		$balance = mysql_query("SELECT money FROM clubs WHERE id='$club_id'");
		$money = mysql_fetch_array($balance);
		$money = $money['money'];
		if(isset($option)) {
			$id = createPurchase($club_id);
			get_page_advanced("purchase_create", "admin", array('club_id' => $club_id, 'id' => $id));
		} else {
			get_page_advanced("purchase", "admin", array('purchaseHistory' => $result, 'balance' => $money ));
		}
	} else {
		get_page_advanced("message", "admin", array('message' => "General application admin does not have a club to manage.", 'title' => "View submissions"));
	}
} else {
	//header('Location: index.php?error=' . urlencode("You are not logged in!"));
}
?>
