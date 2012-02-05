<?php

//returns array of stat_name => (stat_value, maximum)
function calculateStatistics() {
	global $config;
	$stat_array = array();
	$indent = '&nbsp;&nbsp;&nbsp;&nbsp;';
	
	//number of clubs
	$result = mysql_query("SELECT COUNT(*) FROM clubs");
	$row = mysql_fetch_array($result);
	$numClubs = $row[0];
	if(isset($config['limits']) && isset($config['limits']['clubs']) && $config['limits']['clubs'] > 0)
		$stat_array['Clubs'] = array($numClubs, $config['limits']['clubs']);
	else
		$stat_array['Clubs'] = array($numClubs, -1);
	
	//number of users
	$result = mysql_query("SELECT COUNT(*) FROM users");
	$row = mysql_fetch_array($result);
	$numUsers = $row[0];
	if(isset($config['limits']) && isset($config['limits']['users']) && $config['limits']['users'] > 0)
		$stat_array['Users'] = array($numUsers, $config['limits']['users']);
	else
		$stat_array['Users'] = array($numUsers, -1);
	
	//total number of applications
	$result = mysql_query("SELECT COUNT(*) FROM applications");
	$row = mysql_fetch_array($result);
	$stat_array['Applications'] = array($row[0], -1); //-1 disables graph generation
	
	//number of general applications requested (should be close to # users)
	$result = mysql_query("SELECT COUNT(*) FROM applications WHERE club_id = '0'");
	$row = mysql_fetch_array($result);
	$numGen = $row[0];
	$stat_array['General applications'] = array($row[0], -1);
	
	//number of submitted general applications
	$result = mysql_query("SELECT COUNT(*) FROM applications WHERE club_id = '0' AND submitted != ''");
	$row = mysql_fetch_array($result);
	$numGenSubmitted = $row[0];
	$stat_array[$indent . 'Submitted general applications'] = array($numGenSubmitted, $numGen);
	
	//number of unsubmitted general applications; just subtract (total - number submitted)
	$numUnsubmittedGen = $numGen - $numGenSubmitted;
	$stat_array[$indent . 'Unsubmitted general applications'] = array($numUnsubmittedGen, $numGen);
	
	//number of general application questions
	$result = mysql_query("SELECT COUNT(*) FROM baseapp");
	$row = mysql_fetch_array($result);
	$stat_array[$indent . 'General application questions'] = array($row[0], -1);
	
	//number of supplements requested (users may request multiple)
	$result = mysql_query("SELECT COUNT(*) FROM applications WHERE club_id != '0'");
	$row = mysql_fetch_array($result);
	$numSup = $row[0];
	$stat_array['Supplements requested'] = array($numSup, -1);
	
	//number of submitted supplements
	$result = mysql_query("SELECT COUNT(*) FROM applications WHERE club_id != '0' AND submitted != ''");
	$row = mysql_fetch_array($result);
	$numSupSubmitted = $row[0];
	$stat_array[$indent . 'Submitted supplements'] = array($numSupSubmitted, $numSup);
	
	//number of unsubmitted supplements
	$numUnsubmittedSup = $numSup - $numSupSubmitted;
	$stat_array[$indent . 'Unsubmitted supplements'] = array($numUnsubmittedSup, $numSup);
	
	//number of supplement questions (total)
	$result = mysql_query("SELECT COUNT(*) FROM supplements");
	$row = mysql_fetch_array($result);
	$stat_array[$indent . 'Supplement questions'] = array($row[0], -1);
	
	//number of recommendations requested
	$result = mysql_query("SELECT COUNT(*) FROM recommendations");
	$row = mysql_fetch_array($result);
	$numRec = $row[0];
	$stat_array['Recommendations'] = array($numRec, $numRec);
	
	//number of recommendations submitted
	$result = mysql_query("SELECT COUNT(*) FROM recommendations WHERE status != '0'");
	$row = mysql_fetch_array($result);
	$stat_array['Recommendations submitted'] = array($row[0], $numRec);
	
	return $stat_array;
}

//returns array (users submitted, users applied, users total)
function adminStatistics($club_id) {
	$club_id = escape($club_id);
	
	$result = mysql_query("SELECT COUNT(*) FROM applications WHERE club_id = '$club_id' AND submitted != ''");
	$row = mysql_fetch_array($result);
	$usersSubmitted = $row[0];
	
	$result = mysql_query("SELECT COUNT(*) FROM applications WHERE club_id = '$club_id'");
	$row = mysql_fetch_array($result);
	$usersApplied = $row[0];
	
	$result = mysql_query("SELECT COUNT(*) FROM users");
	$row = mysql_fetch_array($result);
	$usersTotal = $row[0];
	
	return array($usersSubmitted, $usersApplied, $usersTotal);
}

//returns array of club id => (club name, # submitted, # applied)
function clubStatistics() {
	$result = mysql_query("SELECT id, name FROM clubs");
	$clubStatistics = array();
	
	while($row = mysql_fetch_array($result)) {
		$adminStatistics = adminStatistics($row['id']);
		$clubStatistics[$row['id']] = array($row['name'], $adminStatistics[0], $adminStatistics[1]);
	}
	
	return $clubStatistics;
}

//returns array of (array of (user_id, username) started, array of (user_id, username) completed)
function clubApplicationList($club_id) {
	$club_id = escape($club_id);
	$result = mysql_query("SELECT applications.submitted, applications.user_id, users.username FROM applications, users WHERE applications.club_id = '$club_id' AND applications.user_id = users.id ORDER BY users.username");
	
	$usersStarted = array();
	$usersCompleted = array();
	
	while($row = mysql_fetch_row($result)) {
		if($row[0] == '') {
			array_push($usersStarted, array($row[1], $row[2]));
		} else {
			array_push($usersCompleted, array($row[1], $row[2]));
		}
	}
	
	return array($usersStarted, $usersCompleted);
}

//array of (question name, array(choice -> #)); note that total responses can be derived from adminStatistics
function responseStatistics($club_id, $include_short, $limit) {
	global $config;
	$club_id = escape($club_id);
	
	//first, get a map of variables ids that either type=short or type=select
	$result = mysql_query("SELECT id, varname, vartype FROM supplements WHERE club_id = '$club_id' ORDER BY orderId");
	$responseMap = array();
	
	while($row = mysql_fetch_array($result)) {
		$typeArray = getTypeArray($row['vartype']);
		
		if(($typeArray['type'] == "short" && $include_short) || $typeArray['type'] == "select") {
			$responseMap[$row['id']] = array($row['varname'], array());
		}
	}
	
	//now get the user responses
	$result = mysql_query("SELECT answers.var_id, answers.val FROM answers, applications WHERE answers.application_id = applications.id AND applications.club_id = '$club_id'");
	
	while($row = mysql_fetch_array($result)) {
		if(array_key_exists($row[0], $responseMap)) { //this is true unless supplements desynchronize
			//response might have multiple parts with form_array_delimiter
			$responseArray = explode($config['form_array_delimiter'], $row[1]);
			
			foreach($responseArray as $response) {
				if(!array_key_exists($response, $responseMap[$row[0]][1])) { //if we haven't encountered this response yet for this question
					$responseMap[$row[0]][1][$response] = 0;
				} else if($responseMap[$row[0]][1][$response] >= $limit) { //if we're going to be displaying too many options
					continue;
				}
			
				$responseMap[$row[0]][1][$response]++;
			}
		}
	}
	
	return $responseMap;
}

?>
