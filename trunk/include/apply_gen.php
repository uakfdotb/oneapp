<?php

function writeField($id, $name, $desc, $type) {
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
		echo '<br><textarea name="' . $id .  '" rows="' . $rows . '" cols="' . $cols . '"></textarea>';
		echo '</p>';
	} else if($type_array[0] == "short") {
		echo '<p>';
		echo $name;
		echo ': <input type="text" name="' . $id . "' />";
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
			echo '<br><input type="' . $tname . '" name="' . $id . ">' " . $choice;
		}
		
		echo '</p>';
	}
}

?>
