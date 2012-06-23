<?php

//add a subscription
function addSubscription($user_id, $club_id) {
	//make sure this user isn't already subscribed
	if(!checkSubscription($user_id, $club_id)) {
		$user_id = escape($user_id);
		$club_id = escape($club_id);
		
		//make sure club exists
		$result = mysql_query("SELECT COUNT(*) FROM clubs WHERE id = '$club_id'");
		$row = mysql_fetch_row($result);
		
		if($row[0] > 0) {
			mysql_query("INSERT INTO subscriptions (user_id, club_id) VALUES ('$user_id', '$club_id')");
		}
	}
}

//remove a subscription
function removeSubscription($user_id, $club_id) {
	$user_id = escape($user_id);
	$club_id = escape($club_id);
	
	mysql_query("DELETE FROM subscriptions WHERE user_id = '$user_id' AND club_id = '$club_id'");
}

//check whether subscribed
//true: subscribed; false: otherwise
function checkSubscription($user_id, $club_id) {
	$user_id = escape($user_id);
	$club_id = escape($club_id);
	
	$result = mysql_query("SELECT COUNT(*) FROM subscriptions WHERE user_id = '$user_id' AND club_id = '$club_id'");
	$row = mysql_fetch_row($result);
	
	return $row[0] > 0;
}

//list clubs a user subscribed to
//returns id of each club
function listSubscriptions($user_id) {
	$user_id = escape($user_id);
	$array = array();
	
	$result = mysql_query("SELECT club_id FROM subscriptions WHERE user_id = '$user_id'");
	
	while($row = mysql_fetch_row($result)) {
		$array[] = $row[0];
	}
	
	return $array;
}

//list users subscribed to club
//returns array of user_id
function listSubscribers($club_id) {
	$club_id = escape($club_id);
	$array = array();
	
	$result = mysql_query("SELECT user_id FROM subscriptions WHERE club_id = '$club_id'");
	
	while($row = mysql_fetch_row($result)) {
		$array[] = $row[0];
	}
	
	return $array;
}

//list users subscribed to club
//returns array of user_id => (username, email address, name)
function listSubscriberInfo($club_id) {
	$club_id = escape($club_id);
	$array = array();
	
	$result = mysql_query("SELECT users.id, users.username, users.email, users.name FROM subscriptions LEFT JOIN users ON subscriptions.user_id = users.id WHERE club_id = '$club_id'");
	
	while($row = mysql_fetch_row($result)) {
		$array[$row[0]] = array($row[1], $row[2], $row[3]);
	}
	
	return $array;
}

?>
