<?php
//returns an array of (id, submit_time, status_time, status, amount) elements for a certain club
function listPurchases($club_id) {
	$club_id = escape($club_id);
	$result = mysql_query("SELECT id, submit_time, status_time, status, amount FROM purchase_orders WHERE club_id = '$club_id'");
	$purchase_array = array();
	
	while($row = mysql_fetch_row($result)) {
		array_push($purchase_array, array($row[0], $row[1], $row[2], $row[3]));
	}
	
	return $purchase_array;
}

//0: success; -1: internal error
function createPurchase($club_id, $purchase_description, $amount) {
	$purchase_description = escape($purchase_description);
	$amount = escape($amount);
	//first create an instance
	$instance_id = customCreate(customGetCategory('purchase', true), $club_id);
	$curr_time = time();
	//insert into purchase table
	mysql_query("INSERT INTO purchase_order (club_id, instance_id, status, filename, submit_time, description, amount) VALUES ('$club_id', '$instance_id', '0', '', '$curr_time', '$purchase_description', '$amount' )");
	$purchase_id = mysql_insert_id();
	if($purchase_id) {
		return $purchase_id;
	} else {
		return -1;
	}
}



function writePurchase($purchase_id, $club_id) {
	$mutable = true;
	$result = mysql_query("SELECT status, instance_id FROM purchase_order WHERE id = '$purchase_id'");
	if($row = mysql_fetch_array($result)) {
		if($row[0] != 0) {
			$mutable = false;
		}
		$instance_id = $row[1];
	} else {
		return -2;
	}
	
	
	//use custom to display the fields
	customDisplay($instance_id, "purchase_process.php?id=$purchase_id&club_id=$club_id&submit=submit", $mutable, 'I\'m done. Submit.');
}

//returns false on failure or recommender name on success
function authenticatePurchase($purchase_id, $club_id) {
	$purchase_id = escape($purchase_id);
	$club_id = escape($club_id);
	
	$result = mysql_query("SELECT club_id FROM purchase_order WHERE id = '$purchase_id'");
	
	if($row = mysql_fetch_array($result)) {
		if($row[0] ==  $club_id) {
			return $row[0];
		} else {
			return false;
		}
	} else {
		return false;
	}
}


//0: success; -1: already submitted; -2: internal error; -3: incomplete
function submitPurchase($purchase_id, $purchase) {
	$purchase_id = escape($purchase_id);
	
	//make sure not already submitted
	$result = mysql_query("SELECT status, club_id, instance_id FROM purchase_order WHERE id = '$purchase_id'");
	
	if($row = mysql_fetch_array($result)) {
		if($row[0] != 0) {
			return -1;
		} else {
			$purchase_name = $row[1];
			$instance_id = $row[2];
		}
	} else {
		return -2;
	}
	
	$error = customSave($instance_id, $purchase);
	
	if($error !== TRUE) {
		return -2;
	}
	
	//create the PDF
	$filename = customSubmit($instance_id, "Puchase Order", $purchase_name);
	
	if($filename === -1) { //if error during PDF generation
		return -2;
	} else if($filename === -2) { //if incomplete
		return -3;
	}
	
	mysql_query("UPDATE purchase_order SET status='1', filename='$filename' WHERE id = '$purchase_id'");
	return 0;
}

function getPurchaseStatusString($status) {
	if($status == 0) {
		return "incomplete";
	} else if($status == -1 ) {
		return "accepted";
	} else if($status <= -2 ) {
		$val = abs($status)/10;
		$result = mysql_query("SELECT name FROM purchase_confirm WHERE orderID = '$val'");
		if($row = mysql_fetch_array($result)) {
			$return_string = "rejected  by " . $row[0];
			return $return_string;
		} else {
			return "rejected";
		}
	} else {
		$result = mysql_query("SELECT name FROM purchase_confirm WHERE orderID = '$status'");
		if($row = mysql_fetch_array($result)) {
			return $row[0];
		} else {
			return "Error";
		}
	}
}

?>
