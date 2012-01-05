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
}

//0: success; 1: invalid email address provided; 2: invalid name provided;
//3: email error; 4: too many recommendations; 5: email sent already
//6: locked out
function requestRecommendation($user_id, $name, $email, $message) {
	if(!checkLock("peer")) {
		return 6;
	}
	
	$config = $GLOBALS['config'];
	
	$user_id = escape($user_id);
	$name = escape($name);
	$email = escape($email);
	
	if(!validEmail($email)) {
		return 1;
	}
	
	if(strlen($name) <= 3) {
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
	
	//first insert into recommendations table
	$auth = escape(uid(64));
	mysql_query("INSERT INTO recommendations (user_id, author, email, auth, status, filename) VALUES ('$user_id', '$name', '$email', '$auth', '0', '')");
	$recommend_id = mysql_insert_id();
	
	//insert into recommender_answers table
	$result = mysql_query("SELECT id FROM baseapp WHERE category = '-1'"); //-1 denotes peer recommendation category
	
	while($row = mysql_fetch_array($result)) {
		$question_id = escape($row['id']);
		mysql_query("INSERT INTO recommender_answers (recommend_id, var_id, val) VALUES ('$recommend_id', '$question_id', '')");
	}
	
	//send email now
	$content = page_db("request_recommendation");
	$content = str_replace('$NAME$', $name, $content);
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
	$mutable = true;
	$result = mysql_query("SELECT status FROM recommendations WHERE id = '$recommend_id'");
	if($row = mysql_fetch_array($result)) {
		if($row[0] != 0) {
			$mutable = false;
		}
	} else {
		return -2;
	}
	
	$result = mysql_query("SELECT recommender_answers.id, baseapp.id, baseapp.varname, baseapp.vardesc, baseapp.vartype, recommender_answers.val FROM recommender_answers, baseapp WHERE recommender_answers.recommend_id = '$recommend_id' AND baseapp.id = recommender_answers.var_id AND baseapp.category = '-1' ORDER BY baseapp.orderId");
	
	echo '<SCRIPT LANGUAGE="JavaScript" SRC="style/limit.js"></SCRIPT>';
	echo "<form method=\"POST\" action=\"recommend.php?id=$recommend_id&user_id=$user_id&auth=$auth&submit=submit\"><table width=400px";
	
	while($row = mysql_fetch_row($result)) {
		writeField($row[1], $row[0], $row[2], $row[3], $row[4], $row[5], $mutable);
	}
	
	echo '<tr><tr colspan="2" align="center"><input type="submit" value="I\'m done. Submit."></tr></td>';
	echo "</table></form>";
}

//0: success; -1: already submitted; -2: internal error; -3: incomplete
function submitRecommendation($recommend_id, $recommendation) {
	$recommend_id = escape($recommend_id);
	
	//make sure not already submitted
	$result = mysql_query("SELECT status FROM recommendations WHERE id = '$recommend_id'");
	if($row = mysql_fetch_array($result)) {
		if($row[0] != 0) {
			return -1;
		}
	} else {
		return -2;
	}
	
	foreach($recommendation as $var_id => $answer) {
		$var_id = escape($var_id);
		$answer_id = escape($answer[0]);
		$answer_value = escape(substr($answer[1], 0, 16384));
		
		mysql_query("UPDATE recommender_answers SET val='$answer_value' WHERE id='$answer_id' AND recommend_id='$recommend_id' AND var_id='$var_id'");
	}
	
	//make sure all fields have been filled completely
	$result = mysql_query("SELECT baseapp.varname, baseapp.vartype FROM recommender_answers, baseapp WHERE recommender_answers.recommend_id='$recommend_id' AND recommender_answers.var_id = baseapp.id AND recommender_answers.val = ''");
	
	while($row = mysql_fetch_array($result)) {
		$typeArray = getTypeArray($row[1]);
		
		if($typeArray['status'] == "required") {
			return -3;
		}
	}
	
	//create the PDF
	$result = mysql_query("SELECT baseapp.varname, baseapp.vartype, recommender_answers.val FROM recommender_answers, baseapp WHERE recommender_answers.recommend_id = '$recommend_id' AND baseapp.id = recommender_answers.var_id ORDER BY baseapp.orderId");
	$createResult = generatePDFByResult($result, "submit/");
	
	if(!$createResult[0]) { //if error during PDF generation
		return -2;
	}
	
	$filename = $createResult[1];
	mysql_query("UPDATE recommendations SET status='1', filename='$filename' WHERE id = '$recommend_id'");
	return 0;
}

function getStatusString($status) {
	if($status == 0) return "incomplete";
	else if($status == 1) return "complete (enabled)";
	else return "complete  (disabled)";
}

?>
