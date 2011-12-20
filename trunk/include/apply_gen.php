<?php

function writeApplicationHeader($club_id, $application_id, $category_id) {
	echo '<SCRIPT LANGUAGE="JavaScript" SRC="../style/limit.js"></SCRIPT>';
	echo "<form method=\"POST\" action=\"app.php?club_id=$club_id&app_id=$application_id&cat_id=$category_id&action=submit\">";
}

function writeApplicationFooter() {
	echo '<input type="submit" value="Submit">';
	echo "</form>";
}

function writeField($id, $answer_id, $name, $desc, $type, $answer = "", $mutable = true, $repeat_id = -1) {
	$mutableString = "";
	if(!$mutable) {
		$mutableString = " readonly=\"readonly\"";
	}
	
	$fieldName = "a_" . $id . "_" . $answer_id . "_" . $repeat_id;

	$type_array = getTypeArray($type);
	$maxLength = $type_array['length'];
	$lengthRemaining = $maxLength - strlen($answer);
	
	if($type_array['type'] == "essay") {
		$rows = 5;
		$cols = 40;
		
		if($type_array['size'] == "long") {
			$rows = 15;
			$cols = 75;
		}
		
		echo "<p><b>$name</b>: $desc";
		
		if($type_array['status'] == "optional") {
			echo " (optional)";
		}
		
		echo "<br><textarea ";
		
		if($type_array['showchars']) {
			echo "onKeyDown=\"limitText(this.form.$fieldName, this.form.countdown$fieldName, $maxLength);\" ";
			echo "onKeyUp=\"limitText(this.form.$fieldName, this.form.countdown$fieldName, $maxLength);\" ";
		}
		
		echo "name=\"$fieldName\" rows=\"$rows\" cols=\"$cols\"$mutableString>" . htmlspecialchars($answer) . "</textarea>";
		
		if($type_array['showchars']) {
			echo "<br><font size=\"1\">(Maximum characters: $maxLength)<br>";
			echo "You have <input readonly type=\"text\" name=\"countdown$fieldName\" size=\"3\" value=\"$lengthRemaining\"> characters left.</font>";
		}
		
		echo '</p>';
	} else if($type_array['type'] == "short") {
		echo "<p>$name ";
		
		if($type_array['status'] == "optional") {
			echo "(optional) ";
		}
		
		echo "<input ";
		
		if($type_array['showchars']) {
			echo "onKeyDown=\"limitText(this.form.$fieldName, this.form.countdown$fieldname, $maxLength);\" ";
			echo "onKeyUp=\"limitText(this.form.$fieldName, this.form.countdown$fieldName, $maxLength);\" maxlength=\"$maxLength\" ";
		}
		
		echo "type=\"text\" name=\"$fieldName\"$mutableString value=\"" . htmlspecialchars($answer) . "\" /> ";
		echo $desc;
		
		if($type_array['showchars']) {
			echo "<font size=\"1\">(Maximum characters: $maxLength)<br>";
			echo "You have <input readonly type=\"text\" name=\"countdown$fieldName\" size=\"3\" value=\"$lengthRemaining\"> characters left.</font>";
		}
		
		echo '</p>';
	} else if($type_array['type'] == "select") {
		echo '<p>' . $name;
		
		if($type_array['status'] == "optional") {
			echo " (optional)";
		}
		
		$choices = explode(";", $desc);
		
		$tname = "checkbox";
		if($type_array['method'] == "multiple") {
			$tname = "checkbox";
		} else if($type_array['method'] == "single") {
			$tname = "radio";
		} else if($type_array['method'] == "dropdown") {
			$tname = false;
			echo ": <select name=\"$fieldName\"$mutableString>";
		}
		
		foreach($choices as $choice) {
			$selectedString = "";
			if($choice == $answer) {
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
		
		echo '</p>';
	} else if($type_array['type'] == "text") {
		echo "<p>$desc</p>";
	} else if($type_array['type'] == "repeat") {
		$subtype_array = explode("|", $type_array['subtype']);
		$desc_array = explode("|", $desc);
		$name_array = explode("|", $name);
		
		if($answer != '') {
			$answer_array = toArray($answer, "|", "=");
		} else {
			$answer_array = array_fill(0, count($name_array), '');
		}
		
		//find minimum length, which will be the number to repeat for
		$min_length = min(count($subtype_array), count($desc_array), count($name_array), count($answer_array));
		
		for($i = 0; $i < $min_length; $i++) {
			writeField($id, $answer_id, $name_array[$i], $desc_array[$i], $subtype_array[$i], $answer_array[$i], $mutable, $i);
		}
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
		$array['status'] = "required";
	}
	
	if($mainType == "essay" && !array_key_exists("size", $array)) {
		$array['size'] = "medium";
	}
	
	if($mainType == "select" && !array_key_exists("method", $array)) {
		$array['method'] = "multiple";
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
//[0]: 0: belongs to user and not submitted; -1: submitted; -2: does not belong to user
//[1]: the club id if [0] = 0 or -1
function checkApplication($user_id, $application_id, $extended = false) {
	$user_id = escape($user_id);
	$application_id = escape($application_id);

	$extraSelect = "";
	if($extended) {
		$extraSelect = ", club_id";
	}
	
	$result = mysql_query("SELECT submitted$extraSelect FROM applications WHERE id='$application_id' AND user_id='$user_id'");
	
	if($row = mysql_fetch_array($result)) {
		if($row['submitted'] != '') { //already submitted
			if(!$extended) {
				return -1;
			} else {
				return array(-1, $row['club_id']);
			}
		} else {
			if(!$extended) {
				return 0;
			} else {
				return array(0, $row['club_id']);
			}
		}
	} else { //does not belong to user or doesn't exist
		if(!$extended) {
			return -2;
		} else {
			return array(-2, 0);
		}
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
