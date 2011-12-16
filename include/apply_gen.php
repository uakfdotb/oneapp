<?php

function writeField($id, $answer_id, $name, $desc, $type, $mutable = true) {
	$mutableString = "";
	if(!$mutable) {
		$mutableString = " readonly=\"readonly\"";
	}

	$type_array = explode(":", $type);
	
	if($type_array[0] == "essay") {
		$rows = 5;
		$cols = 40;
		
		if($type_array[1] == "long") {
			$rows = 15;
			$cols = 75;
		}
		
		echo '<p><b>';
		echo $name;
		echo '</b>: ';
		echo $desc;
		echo "<br><textarea name=\"a_$id.$answer_id\" rows=\"$rows\" cols=\"$cols\"$mutableString></textarea>";
		echo '</p>';
	} else if($type_array[0] == "short") {
		echo '<p>';
		echo $name;
		echo ": <input type=\"text\" name=\"a_$id.$answer_id\"$mutableString />";
		echo $desc;
		echo '</p>';
	} else if($type_array[0] == "select") {
		echo '<p>';
		echo $name;
		
		$choices = explode(";", $desc);
		
		$tname = "checkbox";
		if($type_array[1] == "multiple") {
			$tname = "checkbox";
		} else if($type_array[1] == "single") {
			$tname = "radio";
		}
		
		foreach($choices as $choice) {
			echo "<br><input type=\"$tname\" name=\"a_$id.$answer_id\"$mutableString> $choice";
		}
		
		echo '</p>';
	}
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
		$result = mysql_query("SELECT answers.id, baseapp.id, baseapp.varname, baseapp.vardesc, baseapp.vartype FROM answers, baseapp WHERE answers.application_id = '$application_id' AND baseapp.id = answers.var_id AND baseapp.category = '$category_id' ORDER BY baseapp.orderId");
	} else {
		$result = mysql_query("SELECT answers.id, supplements.id, supplements.varname, supplements.vardesc, supplements.vartype FROM answers, supplements WHERE answers.application_id = '$application_id' AND supplements.id = answers.var_id ORDER BY supplements.orderId");
	}
	
	echo "<form method\"POST\" action=\"apply.php?club_id=$club_id\">";
	
	while($row = mysql_fetch_row($result)) {
		writeField($row[1], $row[0], $row[2], $row[3], $row[4], $mutable);
	}
	
	echo "</form>";
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
		if($row['submitted'] == '1') { //already submitted
			if(!$extended) {
				return -1;
			} else {
				return array(-1, $row['club_id']);
			}
		} else {
			if(!$extended) {
				return 0;
			} else {
				return array(0, 0);
			}
		}
	} else { //does not belong to user or doesn't exist
		if(!$extended) {
			return -2;
		} else {
			return array(-2, $row['club_id']);
		}
	}
}

?>
