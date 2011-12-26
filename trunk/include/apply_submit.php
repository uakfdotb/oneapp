<?php

function isApplicationStarted($user_id, $club_id) {
	$result = mysql_query("SELECT COUNT(*) FROM applications WHERE user_id='$user_id' AND club_id='$club_id'");
	$row = mysql_fetch_array($result);
	
	if($row[0] > 0) { //already present
		return TRUE;
	} else {
		return FALSE;
	}
}

//0: success; -1: already started; -2: club doesn't exist; -3: not available at this time
function startApplication($user_id, $club_id) {
	$user_id = escape($user_id);
	$club_id = escape($club_id);
	
	if(isApplicationStarted($user_id, $club_id)) { //already present
		return -1;
	}
	
	//if it's a club, verify existence
	if($club_id != 0 && !clubExists($club_id)) {
		return -2;
	}
	
	//make sure it is available at this time
	if(!isAvailableWindow($club_id)) {
		return -3;
	}
	
	//add to applications table first
	mysql_query("INSERT INTO applications (user_id, club_id, submitted) VALUES ('$user_id', '$club_id', '')");
	$application_id = mysql_insert_id();
	
	//now insert blank answers to answers table
	if($club_id == 0) {
		$result = mysql_query("SELECT id FROM baseapp WHERE category != '0' AND category != '-1'");
	} else {
		$result = mysql_query("SELECT id FROM supplements WHERE club_id='$club_id'");
	}
	
	while($row = mysql_fetch_array($result)) {
		$question_id = escape($row['id']);
		mysql_query("INSERT INTO answers (application_id, var_id, val) VALUES ('$application_id', '$question_id', '')");
	}
	
	return 0;
}

//returns $answers, array $var_id = (answer_id, answer_value) for use with saveApplication
function processSubmission($array) {
	$answers = array();
	
	foreach($array as $key => $value) {
		if(string_begins_with($key, "a_")) {
			$parts = explode("_", substr($key, 2));
			
			if(count($parts) == 3) {
				$var_id = $parts[0];
				$answer_id = $parts[1];
				$repeat_id = $parts[2];
				
				if($repeat_id == 256) {
					$answers[$var_id] = array($answer_id, $value);
				} else {
					$value = str_replace("|", "?", $value); //| is going to be our delimiter
					
					if(!array_key_exists($var_id, $answers)) {
						$answers[$var_id] = array($answer_id, "");
					}
					
					$answers[$var_id][1] .= "|$repeat_id=$value";
				}
			}
		}
	}
	
	return $answers;
}

function saveApplication($user_id, $application_id, $answers) { //$answers is array of $var_id => (answer_id, answer_value)
	$user_id = escape($user_id);
	$application_id = escape($application_id);
	
	//verify application belongs to user and hasn't been submitted; this also checks that it is available
	if(checkApplication($user_id, $application_id) !== 0) {
		return FALSE;
	}
	
	//get club_id
	$result = mysql_query("SELECT club_id FROM applications WHERE id='$application_id' AND user_id='$user_id'");
	if($row = mysql_fetch_array($result)) {
		$club_id = escape($row[0]);
	} else {
		return FALSE;
	}
	
	foreach($answers as $var_id => $answer) {
		$var_id = escape($var_id);
		$answer_id = escape($answer[0]);
		
		//cut $answer[1] (the answer value) to max length
		if($club_id == 0) { //find which database we're dealing with
			$result = mysql_query("SELECT vartype FROM baseapp WHERE id='$var_id'");
		} else {
			$result = mysql_query("SELECT vartype FROM supplements WHERE id='$var_id'");
		}
		
		if($row = mysql_fetch_array($result)) {
			$type = $row[0];
		} else {
			continue;
		}
		
		$typeArray = getTypeArray($type);
		$maxLength = $typeArray['length'];
		$answer_value = escape(substr($answer[1], 0, $maxLength));
		
		mysql_query("UPDATE answers SET val='$answer_value' WHERE id='$answer_id' AND application_id='$application_id' AND var_id='$var_id'");
	}
	
	return TRUE;
}

function submitApplication($user_id, $application_id) {
	$user_id = escape($user_id);
	$application_id = escape($application_id);
	
	//verify application belongs to user and hasn't been submitted
	$checkResult = checkApplication($user_id, $application_id, true);
	
	if($checkResult[0] !== 0) {
		return "check failed";
	}
	
	//verify that the user is not trying to submit the general application
	if($checkResult[1] == 0) {
		return "";
	}
	
	//verify that the application can be submitted at this time
	// (checkResult checks view_time, not open_time)
	if(!isAvailableWindow($checkResult[1], true)) {
		return "application cannot be submitted at this time";
	}
	
	//verify that enough peer recommendations have been inputted; grab the filenames while we're at it
	$result = mysql_query("SELECT num_recommend FROM clubs WHERE id = '" . $checkResult[1] . "'");
	$recommendResult = mysql_query("SELECT filename FROM recommendations WHERE user_id = '$user_id' AND status = '1'");
	
	if($row = mysql_fetch_array($result)) {
		if($row[0] > mysql_num_rows($recommendResult)) {
			return "not enough peer recommendations";
		}
	} else {
		return "internal error, club not found";
	}
	
	$peerString = "";
	while($row = mysql_fetch_array($recommendResult)) {
		$peerString .= ":" . $row[0];
	}
	
	//create supplement PDF
	$createSupplementResult = createApplicationPDF($user_id, $application_id, "../submit/");
	
	if($createSupplementResult[0] === FALSE) { //true is success, string is error message
		return $createSupplementResult[1];
	}
	
	//create general application PDF
	$gen_app_id = getApplicationByUserClub($user_id, 0);
	$createGeneralResult = createApplicationPDF($user_id, $gen_app_id, "../submit/");

	if($createGeneralResult[0] === FALSE) { //true is success, string is error message
		return $createGeneralResult[1];
	}
	
	//update database
	$submitName = escape($createGeneralResult[1] . ":" . $createSupplementResult[1] . $peerString);
	mysql_query("UPDATE applications SET submitted='$submitName' WHERE id='$application_id' AND user_id='$user_id'");
	
	return TRUE;
}

//returns array of strings, which are warnings
function checkCompletedApplication($user_id, $club_id, $application_id) {
	$user_id = escape($user_id);
	$club_id = escape($club_id);
	$application_id = escape($application_id);
	
	//verify application belongs to user and hasn't been submitted
	$checkResult = checkApplication($user_id, $application_id, true);
	if($checkResult[0] !== 0) {
		return array("This application cannot be submitted at this time (has not been started or not in available window).");
	}
	
	if($club_id != $checkResult[1]) {
		return array("Club ID is incorrect!");
	}
	
	$warnings = array();
	
	if($club_id == 0) {
		$result = mysql_query("SELECT baseapp.varname, baseapp.vartype FROM answers, baseapp WHERE answers.application_id='$application_id' AND answers.var_id = baseapp.id AND answers.val = ''");
	} else {
		$result = mysql_query("SELECT supplements.varname, supplements.vartype FROM answers, supplements WHERE answers.application_id='$application_id' AND answers.var_id = supplements.id AND answers.val = ''");
	}
	
	while($row = mysql_fetch_array($result)) {
		$typeArray = getTypeArray($row[1]);
		
		if($typeArray['status'] != "optional") {
			array_push($warnings, "Answer to the required question \"" . $row[0] . "\" has not been completed.");
		}
	}
	
	return $warnings;
}

//returns array of (club_id, club_name)
function listClubs() {
	$result = mysql_query("SELECT id, name FROM clubs");
	
	$list = array();
	while($row = mysql_fetch_array($result)) {
		array_push($list, array($row[0], $row[1]));
	}
	
	return $list;
}

function clubExists($club_id) {
	$club_id = escape($club_id);
	$result = mysql_query("SELECT COUNT(*) FROM clubs WHERE id='$club_id'");
	$row = mysql_fetch_array($result);
	
	if($row[0] == 0) {
		return false;
	} else {
		return true;
	}
}

//returns array of (category_id, category_name)
function listCategories() {
	$result = mysql_query("SELECT id, name FROM basecat");
	
	$list = array();
	while($row = mysql_fetch_array($result)) {
		array_push($list, array($row[0], $row[1]));
	}
	
	return $list;
}

//returns application ID
function getApplication($user_id, $club_id) {
	$user_id = escape($user_id);
	$club_id = escape($club_id);
	
	$result = mysql_query("SELECT id FROM applications WHERE user_id='$user_id' AND club_id='$club_id'");
	
	if($row = mysql_fetch_array($result)) {
		return $row[0];
	} else {
		return FALSE;
	}
}

//returns array of (id, user_id, general application PDF, supplement PDF, array(peer rec PDFs))
function listCompletedApplications($club_id) {
	$club_id = escape($club_id);
	$result = mysql_query("SELECT id, user_id, submitted FROM applications WHERE club_id='$club_id' AND submitted != ''");
	
	$array = array();
	while($row = mysql_fetch_array($result)) {
		$submitParts = explode(":", $row['submitted']);
		
		$peerArray = array();
		for($i = 2; $i < count($submitParts); $i++) {
			array_push($peerArray, $submitParts[$i]);
		}
		
		array_push($array, array($row['id'], $row['user_id'], $submitParts[0], $submitParts[1], $peerArray));
	}
	
	return $array;
}

?>
