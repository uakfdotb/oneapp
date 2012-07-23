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
		if(isset($_REQUEST['delete'])) {
			$temp_val = escape($_REQUEST['delete']);
			mysql_query("DELETE FROM purchase_order WHERE club_id='$club_id' AND id='$temp_val' AND status='0'");
		}
		//retrieve and display purchase history
		$pending = mysql_query("SELECT id, description, amount, submit_time, status_time, status, filename FROM purchase_order WHERE status>0 AND club_id='$club_id' AND id>=0 ORDER BY status_time DESC");
		$accept = mysql_query("SELECT id, description, amount, submit_time, status_time, status, filename FROM purchase_order WHERE status<0 AND status=-1 AND club_id='$club_id' AND id>=0 ORDER BY status_time DESC");
		$reject = mysql_query("SELECT id, description, amount, submit_time, status_time, status, filename FROM purchase_order WHERE status<-1 AND club_id='$club_id' AND id>=0 ORDER BY status_time DESC");
		$incomplete = mysql_query("SELECT id, description, amount, submit_time, status FROM purchase_order WHERE status=0 AND club_id='$club_id' AND id>=0 ORDER BY submit_time DESC");
		$deposit = mysql_query("SELECT id, description, amount, submit_time FROM purchase_order WHERE club_id='$club_id' AND id<0 and status=100 ORDER BY submit_time DESC");
		$balance = mysql_query("SELECT money FROM clubs WHERE id='$club_id'");
		if($money = mysql_fetch_array($balance)) {
			$money = $money['money'];
		} else {
			$money = 0;
		}
		
		$list = mysql_query("SELECT orderID from purchase_confirm ORDER BY -orderID");
		if($row = mysql_fetch_array($list)) {
			$max_list = $row[0];
		} else {
			$max_list = 1;
		}
		
		if(isset($_REQUEST['option'])) {
			if($_REQUEST['description'] == "" || $_REQUEST['amount'] <= 0) {
				get_page_advanced("purchase", "admin", array('deposit' => $deposit, 'incomplete' => $incomplete, 'pending' => $pending, 'accept' => $accept, 'reject' => $reject, 'balance' => $money, 'max_list' => $max_list, 'error' => "New orders require a description and amount!" ));
			} else if($_REQUEST['transfer_type']==-1) {
				$id = createPurchase($club_id, $_REQUEST['description'],$_REQUEST['amount']*$_REQUEST['transfer_type']);
				get_page_advanced("purchase_create", "admin", array('club_id' => $club_id, 'id' => $id));
			} else if($_REQUEST['transfer_type']==0) {
				$amount = $_REQUEST['amount'];
				createDeposit($club_id, $_REQUEST['description'],$_REQUEST['amount']);
				get_page_advanced("purchase", "admin", array('deposit' => $deposit, 'incomplete' => $incomplete, 'pending' => $pending, 'accept' => $accept, 'reject' => $reject, 'balance' => $money, 'max_list' => $max_list, 'success' => "\$$amount added to your account!"));
			}
		} else if(isset($_REQUEST['edit'])) {
			get_page_advanced("purchase_create", "admin", array('club_id' => $club_id, 'id' => $_REQUEST['edit']));
		} else {
			get_page_advanced("purchase", "admin", array('deposit' => $deposit, 'incomplete' => $incomplete, 'pending' => $pending, 'accept' => $accept, 'reject' => $reject, 'balance' => $money, 'max_list' => $max_list ));
		}
	} else {
		get_page_advanced("message", "admin", array('message' => "General application admin cannot make purchase orders.", 'title' => "Purchase Orders"));
	}
} else {
	header('Location: index.php?error=' . urlencode("You are not logged in!"));
}
?>
