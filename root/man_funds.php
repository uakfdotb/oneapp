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
				
			//increment from highest orderId
			$result = mysql_query("SELECT MAX(orderId) FROM purchase_confirm");
			if($row = mysql_fetch_array($result)) {
				if(is_null($row[0])) $orderId = 1;
				else $orderId = escape($row[0] + 1);
				
				mysql_query("INSERT INTO purchase_confirm (name, orderId) VALUES ('$name', '$orderId')");
			}
			$success = "Category added successfully!";
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
	
	$result = mysql_query("SELECT id,name FROM purchase_confirm ORDER BY orderId");
	$purchaseList = array();
		
	while($row = mysql_fetch_array($result)) {
		array_push($purchaseList, array($row[0], $row[1]));
	}

	$result = mysql_query("SELECT club_id, submit_time, status, amount FROM purchase_order WHERE status>0 ORDER BY status");
	$result_two = mysql_query("SELECT club_id, submit_time, status_time, amount, status FROM purchase_order WHERE status=0 OR status=-1");
	
	if(isset($success)) {
		get_page_advanced("man_funds", "root", array('success' => $success, 'pending' => $result, 'completed' => $result_two, 'purchaseList' => $purchaseList));
	} else {
		get_page_advanced("man_funds", "root", array('pending' => $result, 'completed' => $result_two, 'purchaseList' => $purchaseList));
	}

} else {
	header('Location: index.php');
}
?>
