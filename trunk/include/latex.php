<?php

function latexSpecialChars( $string )
{
    $map = array( 
            "#"=>"\\#",
            "$"=>"\\$",
            "%"=>"\\%",
            "&"=>"\\&",
            "~"=>"\\~{}",
            "_"=>"\\_",
            "^"=>"\\^{}",
            "\\"=>"\\textbackslash{}",
            "{"=>"\\{",
            "}"=>"\\}",
    );
    
    return preg_replace( "/([\^\%~\\\\#\$%&_\{\}])/e", "\$map['$1']", $string );
}

function latexAppendQuestion($name, $type, $answer) {
	$typeArray = getTypeArray($type);
	
	$question_string = "";
	
	if($typeArray['type'] == "repeat") {
		$num = $typeArray['num'];
		$subtype_array = explode("|", $typeArray['subtype']);
		$name_array = explode("|", $name);
		
		if($answer != '') {
			$answer_array = toArray($answer, "|", "=");
		} else {
			$answer_array = array_fill(0, count($name_array), '');
		}
		
		//find minimum length, which will be the number to repeat for
		$min_length = min(count($subtype_array), count($name_array), count($answer_array));
		
		for($i = 0; $i < $min_length * $num; $i++) {
			$index = $i % $min_length;
			$question_string .= latexAppendQuestion($name_array[$index], $subtype_array[$index], $answer_array[$i]);
		}
	} else {
		$question_string .= '\\textbf{' . $name . '}'; //add question in bold
	
		//add a separator depending on main type of the question
		if($typeArray['type'] == "essay") {
			$question_string .= "\n\n";
		} else {
			$question_string .= ": ";
		}
	
		$question_string .= $answer; //add the response
		$question_string .= "\n\n";
	}
	
	return $question_string;
}

//returns array(FALSE, error message) on failure or array(TRUE, filename without extension) on success
function createApplicationPDF($user_id, $application_id, $targetDirectory) {
	$user_id = escape($user_id);
	$application_id = escape($application_id);
	
	//first verify that application belongs to user and has not been submitted yet
	$checkArray = checkApplication($user_id, $application_id, true);
	
	if($checkArray[0] == -2 || $checkArray[0] == -1) {
		return array(FALSE, "verification failure");
	}
	
	$club_id = $checkArray[1];
	
	//get application fields
	if($club_id == 0) {
		$result = mysql_query("SELECT baseapp.varname, baseapp.vartype, answers.val FROM answers, baseapp WHERE answers.application_id = '$application_id' AND baseapp.id = answers.var_id ORDER BY baseapp.orderId");
	} else {
		$result = mysql_query("SELECT supplements.varname, supplements.vartype, answers.val FROM answers, supplements WHERE answers.application_id = '$application_id' AND supplements.id = answers.var_id ORDER BY supplements.orderId");
	}
	
	return generatePDFByResult($result, $targetDirectory);
}

function generatePDFByResult($result, $targetDirectory) {
	$body_string = "";
	
	while($row = mysql_fetch_row($result)) {
		$body_string .= latexAppendQuestion($row[0], $row[1], $row[2]);
	}
	
	if(substr($targetDirectory, -1) != "/") { //add trailing slash if not present
		$targetDirectory .= "/";
	}
	
	//make a new file for this submission
	do {
		$outFile = uid(32);
	} while(file_exists($targetDirectory . $outFile));
	
	//make temporary directory to store the output file
	mkdir($targetDirectory . $outFile . "/");
	
	$fin = fopen($targetDirectory . "template.tex", 'r');
	$fout = fopen($targetDirectory . $outFile . "/" . $outFile . ".tex", 'w');
	
	while($line = fgets($fin)) {
		$line = str_replace('$BODY$', $body_string, $line);
		fwrite($fout, $line);
	}
	
	fclose($fin);
	fclose($fout);
	
	//make the PDF
	$config = $GLOBALS['config'];
	
	$cdCommand = "cd " . $targetDirectory . $outFile;
	$pdfCommand = $config['latex_path'] . " --interaction=nonstopmode " . $outFile . ".tex";
	exec($cdCommand . " && " . $pdfCommand);
	
	if(!file_exists($targetDirectory . $outFile . "/" . $outFile . ".pdf")) { //failed; PDF not created
		//delete temp directory
		delete_directory($targetDirectory . $outFile); //no trailing slash on outFile
		return array(FALSE, "generation failure");
	}
	
	//move the PDF and delete temporary directory
	rename($targetDirectory . $outFile . "/" . $outFile . ".pdf", $targetDirectory . $outFile . ".pdf");
	delete_directory($targetDirectory . $outFile); //no trailing slash on outFile
	
	return array(TRUE, $outFile);
}

?>
