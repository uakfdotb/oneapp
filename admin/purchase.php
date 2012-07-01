<?php

include("../config.php");
include("../include/common.php");
include("../include/db_connect.php");
include("../include/session.php");

include("../include/purchase.php");
include("../include/apply_gen.php");
include("../include/apply_submit.php");
include("../include/latex.php");
include("../include/custom.php");

if(isset($_SESSION['admin'])) {
	$club_id = $_SESSION['admin_club_id'];
	$user_id = $_SESSION['user_id'];
	
	if($club_id > 0) {
		//retrieve and display purchase history
		$result = mysql_query("SELECT id,description, amount, submit_time, status FROM purchase_order WHERE club_id='$club_id'");
		$balance = mysql_query("SELECT money FROM clubs WHERE id='$club_id'");
		if($money = mysql_fetch_array($balance)) {
			$money = $money['money'];
		} else {
			$money = 0;
		}
		if(isset($_REQUEST['option'])) {
			$id = createPurchase($club_id);
			get_page_advanced("purchase_create", "admin", array('club_id' => $club_id, 'id' => $id));
		} if(isset($_REQUEST['edit'])) {
			get_page_advanced("purchase_create", "admin", array('club_id' => $club_id, 'id' => $_REQUEST['edit']));
		} else {
			get_page_advanced("purchase", "admin", array('purchaseHistory' => $result, 'balance' => $money ));
		}
	} else {
		get_page_advanced("message", "admin", array('message' => "General application admin cannot make purchase orders.", 'title' => "Purchase Orders"));
	}
} else {
	header('Location: index.php?error=' . urlencode("You are not logged in!"));
}
?>
