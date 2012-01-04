<?php

//returns array of stat_name => stat_value
function calculateStatistics() {
	$stat_array = array();
	
	//number of clubs
	$result = mysql_query("SELECT COUNT(*) FROM clubs");
	$row = mysql_fetch_array($result);
	$stat_array['Clubs'] = $row[0];
	
	//number of users
	$result = mysql_query("SELECT COUNT(*) FROM users");
	$row = mysql_fetch_array($result);
	$stat_array['Users'] = $row[0];
	
	//total number of applications
	$result = mysql_query("SELECT COUNT(*) FROM applications");
	$row = mysql_fetch_array($result);
	$stat_array['Applications'] = $row[0];
	
	//number of submitted applications (each person may have multiple submissions)
	$result = mysql_query("SELECT COUNT(*) FROM applications WHERE submitted != ''");
	$row = mysql_fetch_array($result);
	$stat_array['Submitted Apps'] = $row[0];
	
	//number of unsubmitted applications is simply (total - number submitted)
	$stat_array['Unsubmitted Apps'] = $stat_array['Applications'] - $stat_array['Submitted Apps'];
	
	//number of general application questions
	$result = mysql_query("SELECT COUNT(*) FROM baseapp");
	$row = mysql_fetch_array($result);
	$stat_array['General Applications questions'] = $row[0];
	
	//number of supplement questions (total)
	$result = mysql_query("SELECT COUNT(*) FROM supplements");
	$row = mysql_fetch_array($result);
	$stat_array['Supplement questions'] = $row[0];
	
	//number of recommendations requested
	$result = mysql_query("SELECT COUNT(*) FROM recommendations");
	$row = mysql_fetch_array($result);
	$stat_array['Recommendations'] = $row[0];
	
	//number of recommendations submitted
	$result = mysql_query("SELECT COUNT(*) FROM recommendations WHERE status != '0'");
	$row = mysql_fetch_array($result);
	$stat_array['Recommendations submitted'] = $row[0];
	
	return $stat_array;
}

?>
