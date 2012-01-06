<?php

//inserts a question
// database is either supplements or baseapp
// whereString is in the form of "club_id = <>" for supplements or "category = <>" for baseapp
function insertQuestion($varname, $vardesc, $vartype, $club_id, $database, $whereString) {
	//basic error checking
	include_once(includePath() . "/apply_gen.php");
	$typeArray = toArray($vartype);
	if(!isset($typeArray['type'])) {
		return "type map does not contain required 'type' attribute";
	}
	
	if($varname == '' || ($typeArray['type'] == "select" && $vardesc == '')) {
		return "name (or description if type=select) of variable left blank";
	}
	
	//add spaces to type array
	$vartype = str_replace(";", "; ", $vartype);
	
	if($database != "supplements" && $database != "baseapp") {
		return "internal error: invalid database";
	}
	
	$varname = escape($varname);
	$vardesc = escape($vardesc);
	$vartype = escape($vartype);
	$club_id = escape($club_id);
	
	//increment from highest orderId
	$result = mysql_query("SELECT MAX(orderId) FROM $database WHERE $whereString");

	if($row = mysql_fetch_array($result)) {
		if(is_null($row[0])) $orderId = 1;
		else $orderId = escape($row[0] + 1);
	
		if($club_id == 0) {
			mysql_query("INSERT INTO baseapp (orderId, varname, vardesc, vartype, category) VALUES ('$orderId', '$varname', '$vardesc', '$vartype', '" . $_SESSION['category'] . "')");
		} else {
			mysql_query("INSERT INTO supplements (orderId, varname, vardesc, vartype, club_id) VALUES ('$orderId', '$varname', '$vardesc', '$vartype', '$club_id')");
		}
	
		return true;
	} else {
		return "internal error"; //this shouldn't occur, since MAX would return null if no rows are found
	}
}

function deleteQuestions($database, $whereString) {
	mysql_query("DELETE FROM $database WHERE $whereString");
}

?>
