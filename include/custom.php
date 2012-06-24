<?php

//gets the id of a category by name, or FALSE on failure
//if force is true, creates the category if it doesn't exist
function customGetCategory($category_name, $force = false) {
	$category_name = escape($category_name);
	
	$result = mysql_query("SELECT id FROM custom_cat WHERE name = '$category_name'");
	
	if($row = mysql_fetch_row($result)) {
		return $row[0];
	} else {
		if($force) {
			mysql_query("INSERT INTO custom_cat (name) VALUES ('$category_name')");
			return mysql_insert_id();
		} else {
			return false;
		}
	}
}

//returns array of category id => category name
function customCategories() {
	$result = mysql_query("SELECT id, name FROM custom_cat");
	$categories = array();
	
	while($row = mysql_fetch_array($result)) {
		$categories[$row[0]] = $row[1];
	}
	
	return $categories;
}

//returns array of (user id, user name, category id, category name)
function customAdmins() {
	$result = mysql_query("SELECT user_custom.user_id, user_custom.category, users.username, custom_cat.name FROM user_custom LEFT JOIN users ON users.id = user_custom.user_id LEFT JOIN custom_cat ON custom_cat.id = user_custom.category");
	$array = array();
	
	while($row = mysql_fetch_row($result)) {
		$array[] = array($row[0], $row[2], $row[1], $row[3]);
	}
	
	return $array;
}

//returns array of category id => category name that admin can manage
function customAdminCategories($user_id) {
	$user_id = escape($user_id);

	$result = mysql_query("SELECT user_custom.category, custom_cat.name FROM user_custom LEFT JOIN custom_cat ON custom_cat.id = user_custom.category WHERE user_custom.user_id = '$user_id'");
	$categories = array();
	
	while($row = mysql_fetch_array($result)) {
		$categories[$row[0]] = $row[1];
	}
	
	return $categories;
}

//can be used to add, remove, or alter an existing custom category association
// if cat_id = false or association doesn't exist, association will be added
// if new_cat_id = false, association will be removed
// otherwise, association will be altered
//returns TRUE in success, FALSE on failure
function customAlterAdmin($user_id, $cat_id, $new_cat_id) {
	$user_id = escape($user_id);
	
	if($cat_id !== FALSE) {
		$cat_id = escape($cat_id);
	}
	
	if($new_cat_id !== FALSE) {
		$new_cat_id = escape($new_cat_id);
	}
	
	$old_association = FALSE;
	
	//verify existing association
	if($cat_id !== false) {
		$result = mysql_query("SELECT COUNT(*) FROM user_custom WHERE user_id = '$user_id' AND category = '$cat_id'");
		$row = mysql_fetch_row($result);
		
		if($row[0] > 0) {
			$old_association = TRUE;
		}
	}
	
	//invalidate new_cat_id if it exists already
	// in this case, we just delete cat_id association
	if($new_cat_id !== false) {
		$result = mysql_query("SELECT COUNT(*) FROM user_custom WHERE user_id = '$user_id' AND category = '$new_cat_id'");
		$row = mysql_fetch_row($result);
		
		if($row[0] > 0) {
			$new_cat_id = false;
		}
	}
	
	if($old_association) {
		//update or delete existing association
		if($new_cat_id === false) {
			mysql_query("DELETE FROM user_custom WHERE user_id = '$user_id' AND category = '$cat_id'");
			
			//if user has no more custom categories, remove from custom field group
			$result = mysql_query("SELECT COUNT(*) FROM user_custom WHERE user_id = '$user_id'");
			$row = mysql_fetch_row($result);
			
			if($row[0] == 0) {
				alterAdminGroups($user_id, -2, false);
			}
		} else {
			mysql_query("UPDATE user_custom SET category = '$new_cat_id' WHERE user_id = '$user_id' AND category = '$cat_id'");
		}
	} else if($new_cat_id !== false) { //only add an association if we're not trying to delete it!
		mysql_query("INSERT INTO user_custom (user_id, category) VALUES ('$user_id', '$new_cat_id')");
		
		//add custom field group if needed
		alterAdminGroups($user_id, false, -2);
	}
	
	return TRUE;
}

//returns instance id on success, or false on failure
function customCreate($category, $user_id, $status = '') {
	$category = escape($category);
	$user_id = escape($user_id);
	$status = escape($status);
	
	//add instance
	mysql_query("INSERT INTO custom_instance (category, user_id, status) VALUES ('$category', '$user_id', '$status')");
	$instance_id = mysql_insert_id();
	
	//now insert blank answers to custom_response
	$result = mysql_query("SELECT id FROM custom WHERE category = '$category'");
	
	while($row = mysql_fetch_array($result)) {
		$question_id = escape($row['id']);
		mysql_query("INSERT INTO custom_response (instance_id, var_id, val) VALUES ('$instance_id', '$question_id', '')");
	}
	
	return $instance_id;
}

//deletes all data on an instance
function customDestroy($instance_id) {
	$instance_id = escape($instance_id);
	
	mysql_query("DELETE FROM custom_response WHERE instance_id = '$instance_id'");
	mysql_query("DELETE FROM custom_instance WHERE id = '$instance_id'");
	
}

//displays contents of a custom instance
function customDisplay($instance_id, $target_page, $mutable = true, $submit_text = "Submit") {
	$instance_id = escape($instance_id);
	
	$result = mysql_query("SELECT custom_response.id, custom.id, custom.varname, custom.vardesc, custom.vartype, custom_response.val FROM custom_response LEFT JOIN custom ON custom.id = custom_response.var_id WHERE instance_id = '$instance_id' ORDER BY custom.orderId");
	
	echo '<SCRIPT LANGUAGE="JavaScript" SRC="../style/limit.js"></SCRIPT>';
	echo "<form enctype=\"multipart/form-data\" method=\"POST\" action=\"$target_page\"><table><tr><td width\"60%\"></td><td></td></tr>";
	echo '<tr><td colspan="2" align="right"><input type="submit" value="' . $submit_text . '" style="width:100px"></td></tr><tr style="background-color:#ABB4BA"><td colspan="2" style="height:1px"></td></tr><tr><td colspan="2" style="height:10px"></td></tr>';
	
	while($row = mysql_fetch_row($result)) {
		writeField($row[1], $row[0], $row[2], $row[3], $row[4], $row[5], $mutable);
	}
	
	echo '<tr><td colspan="2" style="height:10px"></td><tr style="background-color:#ABB4BA"><td colspan="2" style="height:1px"></td></tr></tr><tr><td colspan="2" align="right"><input type="submit" value="' . $submit_text . '" style="width:100px"></td></tr>';
	echo "</table></form>";
}

//retrieves status of a custom instance
function customGetStatus($instance_id) {
	$instance_id = escape($instance_id);
	
	$result = mysql_query("SELECT status FROM custom_instance WHERE id = '$instance_id'");
	
	if($row = mysql_fetch_row($result)) {
		return $row[0];
	} else {
		return false;
	}
}

//sets status of a custom instance
function customSetStatus($instance_id, $newStatus) {
	$instance_id = escape($instance_id);
	$newStatus = escape($newStatus);
	
	$result = mysql_query("UPDATE custom_instance SET status = '$newStatus' WHERE id = '$instance_id'");
}

//TRUE: success; string: failure (error description)
function customSave($instance_id, $responses) { //$responses is array of $var_id => (response_id, response_value)
	$instance_id = escape($instance_id);
	$error = TRUE; //TRUE means no error
	
	foreach($responses as $var_id => $response) {
		$var_id = escape($var_id);
		$response_id = escape($response[0]);
		
		//cut $response[1] (the response value) to max length
		$result = mysql_query("SELECT vartype FROM custom WHERE id='$var_id'");
		
		if($row = mysql_fetch_array($result)) {
			$type = $row[0];
		} else {
			continue;
		}
		
		$typeArray = getTypeArray($type);
		
		//deal with files
		if($typeArray['type'] == "upload") {
			if(isset($_FILES[$response[1]]) && !empty($_FILES[$response[1]]) && $_FILES[$response[1]]['error'] == 0) {
				$filename = basename($_FILES[$response[1]]['name']);
				$ext = substr($filename, strrpos($filename, '.') + 1);
				
				$possibleExtensions = explode(",", $typeArray['extensions']);
				$maxFileSize = $typeArray['maxsize'];
				
				if((empty($possibleExtensions) || $possibleExtensions[0] == '' || in_array(strtolower($ext), $possibleExtensions)) && $_FILES[$response[1]]["size"] < $maxFileSize) {
					//find an unused name for the file
					do {
						$file_id = uid(32);
						$newname = basePath() . "/submit/" . $file_id;
					} while(file_exists($newname));
					
					//attempt to move the uploaded file to its new place
					if(move_uploaded_file($_FILES[$response[1]]['tmp_name'], $newname)) {
					    $response_value = escape("file:" . $file_id . ":" . str_replace(":", "", $filename));
					} else {
					    $error = "file upload failed";
					    $response_value = '';
					}
				} else {
					$error = "file extension is not accepted or file size is too large";
					$response_value = '';
				}
			}
		} else { //cut if not a file
			$maxLength = $typeArray['length'];
			$response_value = escape(substr($response[1], 0, $maxLength));
		}
		
		mysql_query("UPDATE custom_response SET val='$response_value' WHERE id='$response_id' AND instance_id='$instance_id' AND var_id='$var_id'");
	}
	
	return $error;
}

//creates PDF of a custom instance
//filename string: success; -1: internal error; -2: incomplete
function customSubmit($instance_id, $sectionheader = "Custom", $extrainfo = "Custom") {
	$instance_id = escape($instance_id);
	
	//make sure all fields have been filled completely
	$result = mysql_query("SELECT custom.vartype FROM custom_response LEFT JOIN custom ON custom_response.var_id = custom.id WHERE custom_response.instance_id='$instance_id' AND custom_response.val = ''");
	
	while($row = mysql_fetch_array($result)) {
		$typeArray = getTypeArray($row[0]);
		
		if($typeArray['status'] == "required") {
			return -2;
		}
	}
	
	//create the PDF
	$result = mysql_query("SELECT custom.varname, custom.vardesc, custom.vartype, custom_response.val FROM custom_response LEFT JOIN custom ON custom_response.var_id = custom.id WHERE custom_response.instance_id = '$instance_id' ORDER BY custom.orderId");
	
	$createResult = generatePDFByResult($result, "submit/", $sectionheader, $extrainfo);
	
	if(!$createResult[0]) { //if error during PDF generation
		return -1;
	}
	
	$filename = $createResult[1];
	return $filename;
}

?>
