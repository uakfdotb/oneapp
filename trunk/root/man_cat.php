<?php
include("../config.php");
include("../include/common.php");
include("../include/db_connect.php");
include("../include/session.php");

if(isset($_SESSION['root'])) {
	$message = "";
	
	if(isset($_REQUEST['action'])) {
		$action = $_REQUEST['action'];
		
		if($action == 'add') {
			$name = escape($_REQUEST['name']);
				
			//increment from highest orderId
			$result = mysql_query("SELECT MAX(orderId) FROM basecat");
			if($row = mysql_fetch_array($result)) {
				if(is_null($row[0])) $orderId = 1;
				else $orderId = escape($row[0] + 1);
				
				mysql_query("INSERT INTO basecat (name, orderId) VALUES ('$name', '$orderId')");
			}
			$message = "Category added successfully! Click <a href=\"man_cat.php\">here</a> to continue.";
		} else if($action == 'delete') {
			$cat_id = escape($_REQUEST['id']);
			mysql_query("DELETE FROM basecat WHERE id='$cat_id'");
			$message = "Category deleted successfully! Click <a href=\"man_cat.php\">here</a> to continue.";
		} else if($action == 'update') {
			$cat_id = escape($_REQUEST['id']);
			$name = escape($_REQUEST['name']);
			
			mysql_query("UPDATE basecat SET name='$name' WHERE id='$cat_id'");
			$message = "Category updated successfully! Click <a href=\"man_cat.php\">here</a> to continue.";
		} else if($action == 'up' || $action == 'down') {
			$cat_id = escape($_REQUEST['id']);
			
			$result = mysql_query("SELECT orderId FROM basecat WHERE id='$cat_id'");
			
			if($row = mysql_fetch_array($result)) {
				$orderId = $row[0]; //this is the original orderId of the question selected
				
				$operation = "<"; //take next lower orderId if moving up, or next higher orderId if moving down
				$type = "MAX";
				if($_REQUEST['action'] == "down") {
					$operation = ">";
					$type = "MIN";
				}
			
				$result = mysql_query("SELECT $type(orderId) FROM basecat WHERE orderId $operation '$orderId'");
			
				if($row = mysql_fetch_array($result)) {
					if(!is_null($row[0])) {
						$rowOrderId = escape($row[0]); //this is the target orderId to swap with
						mysql_query("UPDATE basecat SET orderId='$orderId' WHERE orderId='$rowOrderId'");
						mysql_query("UPDATE basecat SET orderId='$rowOrderId' WHERE id='$cat_id'");
					}
				}
			
				$message = "Category updated successfully! Click <a href=\"man_cat.php\">here</a> to continue.";
			} //else category could not be found
		}
	}
	
	$result = mysql_query("SELECT id,name FROM basecat ORDER BY orderId");
	$catList = array();
		
	while($row = mysql_fetch_array($result)) {
		array_push($catList, array($row[0], $row[1]));
	}
	
	get_page_advanced("man_cat", "root", array('message' => $message, 'catList' => $catList));
} else {
	header('Location: index.php');
}
?>
