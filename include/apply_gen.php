<?php

function writeApplicationHeader($club_id, $application_id, $category_id) {
	echo '<SCRIPT LANGUAGE="JavaScript" SRC="../style/limit.js"></SCRIPT>';
	echo "<form method=\"POST\" action=\"app.php?club_id=$club_id&app_id=$application_id&cat_id=$category_id&action=submit\"><table>";
	echo '<tr><td colspan="2" align="center"><input type="submit" value="Save"></td></tr>';
}

function writeApplicationFooter() {
	echo '<tr><td colspan="2" align="center"><input type="submit" value="Save"></td></tr>';
	echo "</table></form>";
}

//writes a field
// repeat_id = 256 means that there is no repetition; -1 doesn't work and 0 is used as an actual ID
function writeField($id, $answer_id, $name, $desc, $type, $answer = "", $mutable = true, $repeat_id = 256) {
	$mutableString = "";
	if(!$mutable) {
		$mutableString = " readonly=\"readonly\"";
	}
	
	//trim the string fields
	$name = trim($name);
	$desc = trim($desc);
	$type = trim($type);
	
	$fieldName = "a_" . $id . "_" . $answer_id . "_" . $repeat_id;

	$type_array = getTypeArray($type);
	$maxLength = $type_array['length'];
	$lengthRemaining = $maxLength - strlen($answer);
	
	if($type_array['type'] == "essay") {
		$rows = 5;
		$cols = 40;
		$heig = 100;
		
		if($type_array['size'] == "large") {
			$rows = 15;
			$cols = 75;
			$heig = 200;
		} else if($type_array['size'] == "huge") {
			$rows = 22;
			$cols = 120;
			$heig = 400;
		}
		
		echo '<tr><td colspan="2"><p class="name">';
		
		if($type_array['status'] != "optional") {
			echo "*";
		}
		
		echo "$name</p>";
		
		if($desc != '') {
			echo "<p class=\"desc\">$desc</p>";
		}
		
		echo "</td></tr><tr><td colspan=\"2\"><textarea ";
		
		if($type_array['showchars']) {
			echo "onKeyDown=\"limitText(this.form.$fieldName, this.form.countdown$fieldName, $maxLength);\" ";
			echo "onKeyUp=\"limitText(this.form.$fieldName, this.form.countdown$fieldName, $maxLength);\" ";
		}
		
		echo "name=\"$fieldName\" rows=\"$rows\" cols=\"$cols\"$mutableString style=\"width:90%;height:";
		echo $heig;
		echo "px;resize:none\">" . htmlspecialchars($answer) . "</textarea>";
		
		if($type_array['showchars']) {
			echo "<p class=\"desc\">(Max Characters: $maxLength)<br>";
			echo "Characters Remaining: <input readonly type=\"text\" name=\"countdown$fieldName\" size=\"3\" value=\"$lengthRemaining\"></p>";
		}
		
		echo '</td></tr>';
	} else if($type_array['type'] == "short") {
		
		echo '<tr><td><p class="name">';
		
		if($type_array['status'] != "optional") {
			echo "*";
		}
		
		echo "$name</p>";
		
		if($desc != '') {
			echo "<p class=\"desc\">$desc</p>";
		}
		
		echo "</td><td>";
		
		echo "<input ";
		if($type_array['showchars']) {
			echo "onKeyDown=\"limitText(this.form.$fieldName, this.form.countdown$fieldname, $maxLength);\" ";
			echo "onKeyUp=\"limitText(this.form.$fieldName, this.form.countdown$fieldName, $maxLength);\" maxlength=\"$maxLength\" ";
		}
		
		echo "type=\"text\" name=\"$fieldName\"$mutableString value=\"" . htmlspecialchars($answer) . "\" style=\"width:90%\" /> ";
		
		if($type_array['showchars']) {
			echo "<p class=\"desc\">(Max Characters: $maxLength)<br>";
			echo "Characters Remaining: <input readonly type=\"text\" name=\"countdown$fieldName\" size=\"3\" value=\"$lengthRemaining\"></p>";
		}
		
		echo '</td></tr>';
	} else if($type_array['type'] == "select") {
		
		echo '<tr><td><p class="name">';
		
		if($type_array['status'] != "optional") {
			echo "*";
		}
		
		echo "$name</p></td><td>";
		
		$choices = explode(";", $desc);
		
		$tname = "checkbox";
		if($type_array['method'] == "multiple") {
			$tname = "checkbox";
			$fieldName .= "[]"; //for multiple selection, PHP needs to know with an [] at the end of field name
		} else if($type_array['method'] == "single") {
			$tname = "radio";
		} else if($type_array['method'] == "dropdown") {
			$tname = false;
			echo "<select name=\"$fieldName\"$mutableString>";
		}
		
		//for checkboxes, answer will be an array separated by $config['form_array_delimiter']
		// we just explode it anyway for convenience and get one element if it's single selection
		$config = $GLOBALS['config'];
		$answerArray = explode($config['form_array_delimiter'], $answer);
		
		foreach($choices as $choice) {
			$selectedString = "";
			if(in_array($choice, $answerArray)) {
				if($tname === false) {
					$selectedString = " selected";
				} else {
					$selectedString = " checked";
				}
			}
			
			if($tname == false) {
				echo "<option$selectedString value=\"$choice\">$choice</option>";
			} else {
				echo "<br><input$selectedString type=\"$tname\" name=\"$fieldName\"$mutableString value=\"$choice\" /> $choice";
			}
		}
		
		if($tname == false) { //select
			echo "</select>";
		}
		
		echo '</td></tr>';
	} else if($type_array['type'] == "text") {
		
		echo '<tr><td colspan="2"><p class="name">';
		
		if($type_array['status'] != "optional") {
			echo "*";
		}
		
		echo "$name</p>";
		
		if($desc != '') {
			echo "<p class=\"desc\">$desc</p>";
		}
		
		echo "</td></tr>";
		
	} else if($type_array['type'] == "repeat") {
		$num = $type_array['num'];
		$subtype_array = explode("|", $type_array['subtype']);
		$desc_array = explode("|", $desc);
		$name_array = explode("|", $name);
		
		if($answer != '') {
			$answer_array = toArray($answer, "|", "=");
		} else {
			$answer_array = array_fill(0, count($name_array) * $num, '');
		}
		
		//find minimum length, which will be the number to repeat for
		$min_length = min(count($subtype_array), count($desc_array), count($name_array));
		
		for($i = 0; $i < $min_length * $num; $i++) {
			$index = $i % $min_length;
			$n = intval($i / $min_length);
			
			$thisName = getRepeatThisValue($name_array, $index, $n);
			$thisDesc = getRepeatThisValue($desc_array, $index, $n);
			$thisType = str_replace(",", ";", getRepeatThisValue($subtype_array, $index, $n));
			
			writeField($id, $answer_id, $thisName, $thisDesc, $thisType, $answer_array[$i], $mutable, $i);
		}
	} else if($type_array['type'] == "code") {
		echo '<tr><td colspan="2">' . page_convert($desc) . '</td></tr>';
	}
}

function getRepeatThisValue($array, $i, $n) {
	$value = $array[$i];
	
	if(substr($value, 0, 1) == ":") {
		//support for cycling a value
		$possibilities = explode(";", substr($value, 1));
		return $possibilities[$n % count($possibilities)];
	} else {
		return $value;
	}
}

function getTypeArray($type) {
	$array = toArray($type);
	$mainType = $array['type'];
	
	if(!array_key_exists("length", $array)) {
		if($mainType == "essay") {
			$array['length'] = 1024;
		} else if($mainType == "repeat") {
			$array['length'] = 8192;
		} else {
			$array['length'] = 256;
		}
	}
	
	if(!array_key_exists("showchars", $array)) { //whether to show the characters remaining or not
		if($mainType == "essay") {
			$array['showchars'] = true;
		} else {
			$array['showchars'] = false;
		}
	}
	
	if(!array_key_exists("status", $array)) { //whether it is required or not
		if($mainType == "text" || $mainType == "code") {
			$array['status'] = "optional";
		} else {
			$array['status'] = "required";
		}
		
		//status can also be "optionalhide"
	}
	
	if($mainType == "essay" && !array_key_exists("size", $array)) {
		$array['size'] = "medium";
	}
	
	if($mainType == "select" && !array_key_exists("method", $array)) {
		$array['method'] = "multiple";
	}
	
	if($mainType == "repeat" && !array_key_exists("num", $array)) {
		$array['num'] = 1;
	}
	
	return $array;
}

function writeApplication($user_id, $application_id, $category_id = 0) {
	$user_id = escape($user_id);
	$application_id = escape($application_id);
	$category_id = escape($category_id); //only used if application_id = 0, for baseapp
	
	//first verify that application belongs to user
	$checkArray = checkApplication($user_id, $application_id, true);
	
	if($checkArray[0] == -2) {
		return FALSE;
	}
	
	$mutable = $checkArray[0] == 0;
	$club_id = $checkArray[1];
	
	//get application fields
	if($club_id == 0) {
		$result = mysql_query("SELECT answers.id, baseapp.id, baseapp.varname, baseapp.vardesc, baseapp.vartype, answers.val FROM answers, baseapp WHERE answers.application_id = '$application_id' AND baseapp.id = answers.var_id AND baseapp.category = '$category_id' ORDER BY baseapp.orderId");
	} else {
		$result = mysql_query("SELECT answers.id, supplements.id, supplements.varname, supplements.vardesc, supplements.vartype, answers.val FROM answers, supplements WHERE answers.application_id = '$application_id' AND supplements.id = answers.var_id ORDER BY supplements.orderId");
	}
	
	writeApplicationHeader($club_id, $application_id, $category_id);
	
	while($row = mysql_fetch_row($result)) {
		writeField($row[1], $row[0], $row[2], $row[3], $row[4], $row[5], $mutable);
	}
	
	writeApplicationFooter();
}

//if extended = true, returns tuple; otherwise just returns [0] below
//[0]: 0: belongs to user and editable; -1: submitted; -2: does not belong to user; -3: supplement submission has closed (and not submitted)
//[1]: the club id if [0] = 0, -1, or -3
function checkApplication($user_id, $application_id, $extended = false) {
	$user_id = escape($user_id);
	$application_id = escape($application_id);
	
	$result = mysql_query("SELECT submitted, club_id FROM applications WHERE id='$application_id' AND user_id='$user_id'");
	
	$returnStatus = 0;
	$club_id = 0;
	
	if($row = mysql_fetch_array($result)) {
		
		if($row['submitted'] != '') { //already submitted
			$returnStatus = -1;
		} else {
			//check if supplement is still open
			if(isAvailableWindow($row['club_id'])) {
				$returnStatus = 0;
			} else {
				$returnStatus = -3;
			}
		}
		
		$club_id = $row['club_id'];
	} else { //does not belong to user or doesn't exist
		$returnStatus = -2;
	}
	
	if($extended) {
		return array($returnStatus, $club_id);
	} else {
		return $returnStatus;
	}
}

//returns true if supplement is available, false otherwise
// if submitWindow is false, uses the view_time and close_time
// if submitWindow is true, uses the open_time and close_time
function isAvailableWindow($club_id, $submitWindow = false) {
	$club_id = escape($club_id);
	
	if($club_id == 0) { //general application is always available
		return true;
	}
	
	$result = mysql_query("SELECT view_time, open_time, close_time FROM clubs WHERE id = '$club_id'");
	
	if($row = mysql_fetch_array($result)) {
		if($submitWindow) $firstTime = $row[1];
		else $firstTime = $row[0];
		$lastTime = $row[2];
		
		if(time() > $firstTime && time() < $lastTime) {
			return true;
		} else {
			return false;
		}
	} else {
		return false;
	}
}

//returns array containing profile fields, var_id => (varname, vardesc, vartype); used for page/page_register.php
function getProfileFields() {
	$result = mysql_query("SELECT baseapp.id, baseapp.varname, baseapp.vardesc, baseapp.vartype FROM baseapp WHERE baseapp.category = '0' ORDER BY baseapp.orderId");
	
	$fields = array();
	while($row = mysql_fetch_row($result)) {
		$fields[$row[0]] = array($row[1], $row[2], $row[3]);
	}
	
	return $fields;
}

?>
