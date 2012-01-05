<?php

//returns an array of the paths of extra PDFs
function checkExtraPDFs($doDelete = false) {
	//list directory
	$submitPath = "../submit";
	$fileList = list_directory($submitPath);
	
	//get all submitted PDFs
	$result = mysql_query("SELECT submitted FROM applications WHERE submitted != ''");
	while($row = mysql_fetch_array($result)) {
		$submitFiles = explode(":", $row[0]);
		
		foreach($submitFiles as $submitFile) {
			$index = array_search($submitFile . ".pdf", $fileList);
			
			if($index !== FALSE) {
				unset($fileList[$index]);
			}
		}
	}
	
	$result = mysql_query("SELECT filename FROM recommendations WHERE filename != ''");
	while($row = mysql_fetch_array($result)) {
		$submitFile = $row[0];
		$index = array_search($submitFile . ".pdf", $fileList);
		
		if($index !== FALSE) {
			unset($fileList[$index]);
		}
	}
	
	$pdfArray = array();
	foreach($fileList as $file) {
		$path = $submitPath . "/" . $file;
		$pdfArray[] = $path;
		
		if($doDelete) {
			unlink($path);
		}
	}
	
	return $pdfArray;
}

//checks for mismatched entries in supplements and answers tables that occurs when a club changes it's application
// returns array of strings describing mismatches
// does not check general application
function checkMismatchedApplications($club_id, $act = false) { //$act means whether or not to fix
	if($club_id == '' || $club_id == 0) {
		return array("Error: club ID invalid (general application check not supported)<br />");
	}
	
	$club_id = escape($club_id);
	$mismatches = array();
	
	//first get the base list from supplements
	$result = mysql_query("SELECT id FROM supplements WHERE club_id = '$club_id'");
	$id_array = array();
	
	while($row = mysql_fetch_row($result)) {
		$id_array[$row[0]] = true;
	}
	
	//loop through each application
	$result = mysql_query("SELECT id, submitted FROM applications WHERE club_id = '$club_id'");
	
	while($row = mysql_fetch_row($result)) {
		$app_id = escape($row[0]);
		$submittedStatus = $row[1] != ''; //true if already submitted
		
		//get the variable IDs
		$app_result = mysql_query("SELECT id, var_id FROM answers WHERE application_id = '$app_id'");
		$ans_array = array();
		
		while($answer_row = mysql_fetch_row($app_result)) {
			$answer_id = $answer_row[0];
			$var_id = $answer_row[1];
			
			if(!array_key_exists($var_id, $id_array)) { //this question has been deleted
				array_push($mismatches, "Extra question $var_id at answers.id=$answer_id, applications.id=$app_id<br>");
				
				if($submittedStatus) {
					array_push($mismatches, "WARNING: $app_id has already been submitted<br>");
				}
				
				if($act) {
					mysql_query("DELETE FROM answers WHERE id='$answer_id'");
				}
			} else {
				$ans_array[$var_id] = true;
			}
		}
		
		//check for new questions in id_array
		foreach($id_array as $var_id => $dummy) {
			if(!array_key_exists($var_id, $ans_array)) {
				array_push($mismatches, "Missing question $var_id on applications.id=$app_id<br>");
				
				if($submittedStatus) {
					array_push($mismatches, "WARNING: $app_id has already been submitted<br>");
				}
				
				if($act) {
					mysql_query("INSERT INTO answers (application_id, var_id, val) VALUES ('$app_id', '$var_id', '')");
				}
			}
		}
	}
	
	return $mismatches;
}

//checks for questions without a "home"
// this means questions whose category or club has been deleted
// todo: this seems a bit inefficient
function checkNoHome() {
	mysql_query("DELETE FROM baseapp WHERE category != '0' AND category != '-1' AND (SELECT COUNT(id) FROM basecat WHERE id = baseapp.category) < 1");
	mysql_query("DELETE FROM supplements WHERE (SELECT COUNT(id) FROM clubs WHERE id = supplements.club_id) < 1");
}

?>
