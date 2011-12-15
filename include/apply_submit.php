<?php

function startApplication($user_id, $club_id) {
	$user_id = escape($user_id);
	$club_id = escape($club_id);
	
	//make sure not already started
	$result = mysql_query("SELECT COUNT(*) FROM applications WHERE user_id='$user_id' AND club_id='$club_id'");
	$row = mysql_fetch_array($result);
	
	if($row[0] > 0) { //already present
		return FALSE;
	}
	
	//add to applications table first
	mysql_query("INSERT INTO applications (user_id, club_id, submitted) VALUES ('$user_id', '$club_id', '0')");
	
	if($supplement_id == 0) {
		$result = mysql_query("SELECT id FROM baseapp WHERE category != '0'");
	} else {
		$result = mysql_query("SELECT id FROM supplements WHERE club_id='$club_id'");
	}
	
	while($row = mysql_fetch_array($result)) {
		$question_id = escape($row['id']);
		mysql_query("INSERT INTO answers (application_id, var_id, val) VALUES ('$application_id', '$question_id', '')");
	}
	
	return TRUE;
}

function saveApplication($user_id, $application_id, $answers) {
	$user_id = escape($user_id);
	$application_id = escape($application_id);
	
	//verify application belongs to user and hasn't been submitted
	$result = mysql_query("SELECT submitted FROM applications WHERE id='$application_id' AND user_id='$user_id'");
	
	if($row = mysql_fetch_array($result)) {
		if($row['submitted'] == '1') { //already submitted
			return FALSE;
		}
	} else { //does not belong to user or doesn't exist
		return FALSE;
	}
	
	foreach($answers as $var_id => $answer) {
		$var_id = escape($var_id);
		$answer_id = escape($answer[0]);
		$answer_value = escape($answer[1]);
		
		mysql_query("UPDATE answers SET val='$answer_value' WHERE id='$answer_id' AND application_id='$application_id'");
	}
	
	return TRUE;
}

function submitApplication($user_id, $application_id) {
	$user_id = escape($user_id);
	$application_id = escape($application_id);
	
	//verify application belongs to user and hasn't been submitted
	$result = mysql_query("SELECT submitted FROM applications WHERE id='$application_id' AND user_id='$user_id'");
	
	if($row = mysql_fetch_array($result)) {
		if($row['submitted'] == '1') { //already submitted
			return FALSE;
		}
	} else { //does not belong to user or doesn't exist
		return FALSE;
	}
	
	//submit it
	mysql_query("UPDATE applications SET submitted='1' WHERE id='$application_id'");
	return TRUE;
}

?>
