<?php
include("../config.php");
include("../include/common.php");
include("../include/db_connect.php");
include("../include/session.php");

include("../include/purchase.php");

if(isset($_SESSION['root'])) {
	if(isset($_REQUEST['action'])) {
		$action = $_REQUEST['action'];
		
		if($action == 'add') {
			$name = escape($_REQUEST['name']);
			$userId = getUserId($name);
			if($userId !== FALSE) {	
				$result = mysql_query("SELECT users.username FROM users, user_groups, purchase_confirm WHERE user_groups.user_id=$userId AND user_groups.group=-1 AND purchase_confirm.id NOT IN ($userId)");
				if($row = mysql_fetch_array($result) ) {
					//increment from highest orderId
					$result = mysql_query("SELECT MAX(orderId) FROM purchase_confirm");
					if($row = mysql_fetch_array($result)) {
						if(is_null($row[0])) $orderId = 1;
						else $orderId = escape($row[0] + 1);
				
						mysql_query("INSERT INTO purchase_confirm (id, name, orderId) VALUES ('$userId', '$name', '$orderId')");
					}
					$success = "Category added successfully!";
				} else {
					$error = "Username is not associated with root account or already has role in purchases";
				}
			} else {
				$error = "Username not found.";
			}
		} else if($action == 'delete' || $action == 'Delete') {
			$cat_id = escape($_REQUEST['id']);
			mysql_query("DELETE FROM purchase_confirm WHERE id='$cat_id'");
			$success = "Category deleted successfully!";
		} else if($action == 'update' || $action == 'Update') {
			$cat_id = escape($_REQUEST['id']);
			$name = escape($_REQUEST['name']);
			
			mysql_query("UPDATE purchase_confirm SET name='$name' WHERE id='$cat_id'");
			$success = "Category updated successfully!";
		} else if($action == 'up' || $action == 'down') {
			$cat_id = escape($_REQUEST['id']);
			
			$result = mysql_query("SELECT orderId FROM purchase_confirm WHERE id='$cat_id'");
			
			if($row = mysql_fetch_array($result)) {
				$orderId = $row[0]; //this is the original orderId of the question selected
				
				$operation = "<"; //take next lower orderId if moving up, or next higher orderId if moving down
				$type = "MAX";
				if($_REQUEST['action'] == "down") {
					$operation = ">";
					$type = "MIN";
				}
			
				$result = mysql_query("SELECT $type(orderId) FROM purchase_confirm WHERE orderId $operation '$orderId'");
			
				if($row = mysql_fetch_array($result)) {
					if(!is_null($row[0])) {
						$rowOrderId = escape($row[0]); //this is the target orderId to swap with
						mysql_query("UPDATE purchase_confirm SET orderId='$orderId' WHERE orderId='$rowOrderId'");
						mysql_query("UPDATE purchase_confirm SET orderId='$rowOrderId' WHERE id='$cat_id'");
					}
				}
			
				$success = "Category moved successfully!";
			} //else category could not be found
		}
	}
	
	if(isset($_REQUEST['status_change'])) {
		$list = mysql_query("SELECT orderID from purchase_confirm ORDER BY -orderID");
		if($row = mysql_fetch_array($list)) {
			$max_list = $row[0];
		} else {
			$max_list = 1;
		}
		$local_purchase_id = abs($_REQUEST['status_change']);
		$result = mysql_query("SELECT status,club_id,amount FROM purchase_order WHERE id='$local_purchase_id'");
		$row = mysql_fetch_array($result);
		$curr_time = time();
		if($_REQUEST['status_change']<0) {
			$success="Purchase order rejected";
			mysql_query("UPDATE purchase_order SET status='-10*status', status_time='$curr_time' WHERE id='$local_purchase_id'");
		} else if($row['0'] < $max_list) {
			$success="Purchase order sent to next stage";
			mysql_query("UPDATE purchase_order SET status=status+1, status_time='$curr_time' WHERE id='$local_purchase_id'");
		} else {
			$success="Purchase order approved";
			mysql_query("UPDATE purchase_order SET status=-1, status_time='$curr_time' WHERE id='$local_purchase_id'");
			$club_id = $row['club_id'];
			$amount = $row['amount'];
			mysql_query("UPDATE clubs SET money=money+$amount WHERE id='$club_id'")or die (mysql_error()); ;
		}
	}
	
	$result = mysql_query("SELECT id,name FROM purchase_confirm ORDER BY orderId");
	$purchaseList = array();
		
	while($row = mysql_fetch_array($result)) {
		array_push($purchaseList, array($row[0], $row[1]));
	}
	$result = mysql_query("SELECT users.username FROM users, user_groups WHERE user_groups.user_id=users.id AND user_groups.group=-1");
	
	while($row = mysql_fetch_array($result)) {
		$userList[] = array($row[0]);
	}

	$result = mysql_query("SELECT id, club_id, submit_time, status, amount,filename FROM purchase_order WHERE status>0 ORDER BY status");
	$result_two = mysql_query("SELECT club_id, submit_time, status_time, amount, status FROM purchase_order WHERE status<=0");
	
	if(isset($success)) {
		get_page_advanced("man_funds", "root", array('success' => $success, 'pending' => $result, 'completed' => $result_two, 'purchaseList' => $purchaseList, 'userList' => $userList));
	} else if(isset($error)) {
		get_page_advanced("man_funds", "root", array('error' => $error, 'pending' => $result, 'completed' => $result_two, 'purchaseList' => $purchaseList, 'userList' => $userList));
	} else {
		get_page_advanced("man_funds", "root", array('pending' => $result, 'completed' => $result_two, 'purchaseList' => $purchaseList, 'userList' => $userList));
	}

} else {
	header('Location: index.php');
}
?>
