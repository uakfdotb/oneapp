<?php

//returns an array of (id, name, email, status) elements
function listRecommendations($user_id) {
	$user_id = escape($user_id);
	$result = mysql_query("SELECT id, author, email, status FROM recommendations WHERE user_id = '$user_id'");
	$recommend_array = array();
	
	while($row = mysql_fetch_row($result)) {
		array_push($recommend_array, array($row[0], $row[1], $row[2], $row[3]));
	}
	
	return $recommend_array;
}

//returns false if not submitted, else returns newState
function toggleRecommendation($user_id, $id) {
	$id = escape($id);
	$user_id = escape($user_id);
	
	//make sure it's submitted
	$result = mysql_query("SELECT status FROM recommendations WHERE id = '$id' AND user_id = '$user_id'");
	$newState = 1;
	
	if($row = mysql_fetch_array($result)) {
		if($row[0] == 0) {
			return FALSE;
		} else if($row[0] == 1) {
			$newState = 2;
		}
	} else {
		return FALSE;
	}
	
	mysql_query("UPDATE recommendations SET status='$newState' WHERE id='$id'");
	return $newState;
}

//0: success; 1: invalid email address provided; 2: invalid name provided;
//3: email error; 4: too many recommendations; 5: email sent already
//6: locked out
function requestRecommendation($user_id, $author, $email, $message) {
	if(!checkLock("peer")) {
		return 6;
	}
	
	$config = $GLOBALS['config'];
	
	$user_id = escape($user_id);
	$author = escape($author);
	$email = escape($email);
	
	if(!validEmail($email)) {
		return 1;
	}
	
	if(strlen($author) <= 3) {
		return 2;
	}
	
	//make sure there aren't too many recommendations already
	$result = mysql_query("SELECT COUNT(*) FROM recommendations WHERE user_id = '$user_id'");
	$row = mysql_fetch_row($result);
	if($row[0] >= $config['max_recommend']) {
		return 4; //too many recommendations
	}
	
	//ensure this email hasn't been asked with this user already
	$result = mysql_query("SELECT COUNT(*) FROM recommendations WHERE user_id = '$user_id' AND email = '$email'");
	$row = mysql_fetch_row($result);
	if($row[0] > 0) {
		return 5; //email address already asked
	}
	
	lockAction("peer");
	
	//first create an instance
	$instance_id = customCreate(customGetCategory('recommend', true), $user_id);
	
	//insert into recommendations table
	$auth = escape(uid(64));
	mysql_query("INSERT INTO recommendations (user_id, instance_id, author, email, auth, status, filename) VALUES ('$user_id', '$instance_id', '$author', '$email', '$auth', '0', '')");
	$recommend_id = mysql_insert_id();
	
	$userinfo = getUserInformation($user_id); //array (username, email address, name)
	
	//send email now
	$content = page_db("request_recommendation");
	$content = str_replace('$USERNAME$', $userinfo[0], $content);
	$content = str_replace('$USEREMAIL$', $userinfo[1], $content);
	$content = str_replace('$NAME$', $userinfo[2], $content);
	$content = str_replace('$AUTHOR$', $author, $content);
	$content = str_replace('$EMAIL$', $email, $content);
	$content = str_replace('$MESSAGE$', page_convert($message), $content);
	$content = str_replace('$AUTH$', $auth, $content);
	$content = str_replace('$SUBMIT_ADDRESS$', $config['site_address'] . "/recommend.php?id=$recommend_id&user_id=$user_id&auth=$auth", $content);
	
	$result = one_mail("Recommendation request", $content, $email);
	
	if($result) {
		return 0;
	} else {
		return 3;
	}
}

//returns false on failure or recommender name on success
function authenticateRecommendation($recommend_id, $user_id, $auth) {
	$recommend_id = escape($recommend_id);
	$user_id = escape($user_id);
	
	$result = mysql_query("SELECT auth, author FROM recommendations WHERE id = '$recommend_id' AND user_id = '$user_id'");
	
	if($row = mysql_fetch_array($result)) {
		if($row[0] ==  $auth) {
			return $row[1];
		} else {
			return false;
		}
	} else {
		return false;
	}
}

function writeRecommendation($recommend_id, $user_id, $auth) {
	//determine whether recommendation should be mutable, and get instance id at the same time
	$mutable = true;
	$result = mysql_query("SELECT status, instance_id FROM recommendations WHERE id = '$recommend_id'");
	$instance_id = 0;
	
	if($row = mysql_fetch_array($result)) {
		if($row[0] != 0) {
			$mutable = false;
		}
		
		$instance_id = $row[1];
	} else {
		return -2;
	}
	
	//use custom to display the fields
	customDisplay($instance_id, "recommend.php?id=$recommend_id&user_id=$user_id&auth=$auth&submit=submit", $mutable, 'I\'m done. Submit.');
}

//0: success; -1: already submitted; -2: internal error; -3: incomplete
function submitRecommendation($recommend_id, $recommendation) {
	$recommend_id = escape($recommend_id);
	
	//make sure not already submitted; also get recommender name and instance id
	$result = mysql_query("SELECT status, author, instance_id FROM recommendations WHERE id = '$recommend_id'");
	
	if($row = mysql_fetch_array($result)) {
		if($row[0] != 0) {
			return -1;
		} else {
			$recommender_name = $row[1];
			$instance_id = $row[2];
		}
	} else {
		return -2;
	}
	
	$error = customSave($instance_id, $recommendation);
	
	if($error !== TRUE) {
		return -2;
	}
	
	//create the PDF
	$filename = customSubmit($instance_id, "Recommendation letter", $recommender_name);
	
	if($filename === -1) { //if error during PDF generation
		return -2;
	} else if($filename === -2) { //if incomplete
		return -3;
	}
	
	mysql_query("UPDATE recommendations SET status='1', filename='$filename' WHERE id = '$recommend_id'");
	return 0;
}

function getStatusString($status) {
	if($status == 0) return "incomplete";
	else if($status == 1) return "complete (enabled)";
	else return "complete (disabled)";
}

?>
