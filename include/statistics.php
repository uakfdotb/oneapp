<?php

//returns array of stat_name => (stat_value, maximum)
function calculateStatistics() {
	global $config;
	$stat_array = array();
	
	//number of clubs
	$result = mysql_query("SELECT COUNT(*) FROM clubs");
	$row = mysql_fetch_array($result);
	$numClubs = $row[0];
	if(isset($config['limits']) && isset($config['limits']['clubs']) && $config['limits']['clubs'] > 0)
		$stat_array['Clubs'] = array($numClubs, $config['limits']['clubs']);
	else
		$stat_array['Clubs'] = array($numClubs, $numClubs);
	
	//number of users
	$result = mysql_query("SELECT COUNT(*) FROM users");
	$row = mysql_fetch_array($result);
	$numUsers = $row[0];
	if(isset($config['limits']) && isset($config['limits']['users']) && $config['limits']['users'] > 0)
		$stat_array['Users'] = array($numUsers, $config['limits']['users']);
	else
		$stat_array['Users'] = array($numUsers, $numUsers);
	
	//total number of applications
	$result = mysql_query("SELECT COUNT(*) FROM applications");
	$row = mysql_fetch_array($result);
	$stat_array['Applications'] = array($row[0], -1); //-1 disables graph generation
	
	//number of general applications requested (should be close to # users)
	$result = mysql_query("SELECT COUNT(*) FROM applications WHERE club_id = '0'");
	$row = mysql_fetch_array($result);
	$numGen = $row[0];
	$stat_array['General applications'] = array($row[0], $row[0]);
	
	//number of submitted general applications
	$result = mysql_query("SELECT COUNT(*) FROM applications WHERE club_id = '0' AND submitted != ''");
	$row = mysql_fetch_array($result);
	$numGenSubmitted = $row[0];
	$stat_array['Submitted general applications'] = array($numGenSubmitted, $numGen);
	
	//number of unsubmitted general applications; just subtract (total - number submitted)
	$numUnsubmittedGen = $numGen - $numGenSubmitted;
	$stat_array['Unsubmitted general applications'] = array($numUnsubmittedGen, $numGen);
	
	//number of general application questions
	$result = mysql_query("SELECT COUNT(*) FROM baseapp");
	$row = mysql_fetch_array($result);
	$stat_array['General application questions'] = array($row[0], -1);
	
	//number of supplements requested (users may request multiple)
	$result = mysql_query("SELECT COUNT(*) FROM applications WHERE club_id != '0'");
	$row = mysql_fetch_array($result);
	$numSup = $row[0];
	$stat_array['Supplements requested'] = array($numSup, $numSup);
	
	//number of submitted supplements
	$result = mysql_query("SELECT COUNT(*) FROM applications WHERE club_id != '0' AND submitted != ''");
	$row = mysql_fetch_array($result);
	$numSupSubmitted = $row[0];
	$stat_array['Submitted supplements'] = array($numSupSubmitted, $numSup);
	
	//number of unsubmitted supplements
	$numUnsubmittedSup = $numSup - $numSupSubmitted;
	$stat_array['Unsubmitted supplements'] = array($numUnsubmittedSup, $numSup);
	
	//number of supplement questions (total)
	$result = mysql_query("SELECT COUNT(*) FROM supplements");
	$row = mysql_fetch_array($result);
	$stat_array['Supplement questions'] = array($row[0], -1);
	
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

?>
