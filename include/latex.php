<?php
include("html_to_latex.php");

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
		
		$string = preg_replace( "/([\^\%~\\\\#\$%&_\{\}])/e", "\$map['$1']", $string);
		
		//also add LaTeX linebreak where there is only one newline character
		$string = preg_replace("/\n{1}/", " \\\\\\\\*\n", $string);
		return $string;
}

function latexAppendQuestion($name, $desc, $type, $answer) {
		$typeArray = getTypeArray($type);
		
		$question_string = "";
		
		if($typeArray['type'] == "text") {
				if($name != "") {
						$question_string .= '\\textbf{' . latexSpecialChars($name) . '}'; //add main in bold
				}
				
				if($desc != "") {
						if($name != "") {
								$question_string .= '\\newline';
						}

			$question_string .= '\\emph{' . latexSpecialChars($desc) . '}'; //add description in italics
		}
		
		$question_string .= '\\newline \\newline';
		return $question_string;
	} else if($typeArray['type']=="latex") {
		$question_string .= $desc;
		return $question_string;
	} else if($typeArray['type'] == "code") {
		$question_string .= '\\text{' . get_html_to_latex(page_convert($desc)) . '}';
		return $question_string;
	} else if($typeArray['type'] == "repeat") {
		$num = $typeArray['num'];
		$subtype_array = explode("|", $typeArray['subtype']);
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
			
			$question_string .= latexAppendQuestion($thisName, $thisDesc, $thisType, $answer_array[$i]);
		}
	} else {
		if($name != "") {
				 $question_string .= '\\textbf{' . latexSpecialChars($name) . '}'; //add question in bold
		}
		
		//add description (in bold) for essays and short answer
		if(($typeArray['type'] == "essay" || $typeArray['type'] == "short") && $desc != "") {
			if($name != "") {
				$question_string .= '\\newline';
			}
			
			$question_string .= '\\emph{' . latexSpecialChars($desc) . '}'; //add description in italics
		}
	
		//add a separator depending on main type of the question
		if($typeArray['type'] == "essay") {
			$question_string .= "\n\n";
		}
		
		if($typeArray['type'] == "select" && $typeArray['method'] != "dropdown") {
			//in this case, we add tick marks and check the correct ones
			$choices = explode(";", $desc);
			
			//get answer as array in case we're using multiple selection
			$config = $GLOBALS['config'];
			$answerArray = explode($config['form_array_delimiter'], latexSpecialChars($answer));
			
			//this is used to indent the answer choices
			$question_string .= "\n \\begin{quote} \n";
			
			//output each choice with check box before it on a separate line in the quote
			for($i = 0; $i < count($choices); $i++) {
				$choice = $choices[$i];
				
				if($i != 0) $question_string .= "\\\\\n ";
				
				if(in_array($choice, $answerArray)) {
					$question_string .= '\xbox';
				} else {
					$question_string .= '\tickbox';
				}
				
				$question_string .= " \hspace{4pt} " . latexSpecialChars($choice);
			}
			
			$question_string .= "\\end{quote}";
		} else {
			//append the response
			
			if($typeArray['type'] == "essay") {
				if($answer != "") {
					$question_string .= '\\begin{quote} ' . latexSpecialChars($answer) . '\\end{quote}';
				} else {
					$question_string .= '\\vspace{5ex}';
				}
			}
			else {
				if($answer != "") {
					$question_string .= '\\begin{quote} ' . latexSpecialChars($answer) . ' \\end{quote}';
				} else {
					$question_string .= '\\vspace{1ex}';
				}
			}
		}
		
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
				$result = mysql_query("SELECT baseapp.varname, baseapp.vardesc, baseapp.vartype, profiles.val, 0 AS sort_col, baseapp.orderId AS sort2_col FROM profiles, baseapp WHERE profiles.user_id = '$user_id' AND profiles.var_id = baseapp.id UNION ALL SELECT baseapp.varname, baseapp.vardesc, baseapp.vartype, answers.val, basecat.orderId AS sort_col, baseapp.orderId AS sort2_col FROM answers, baseapp, basecat WHERE answers.application_id = '$application_id' AND baseapp.id = answers.var_id AND basecat.id = baseapp.category ORDER BY sort_col, sort2_col");
				
				$sectionheader = "General Application";
		} else {
				$result = mysql_query("SELECT supplements.varname, supplements.vardesc, supplements.vartype, answers.val FROM answers, supplements WHERE answers.application_id = '$application_id' AND supplements.id = answers.var_id ORDER BY supplements.orderId");
				
				$clubInfo = clubInfo($club_id); //array (club name, club description, open_time, close_time, num_recommendations)
				$sectionheader = "Supplement: " . $clubInfo[0];
		}
		
		$userInfo = getUserInformation($user_id); //array(username, email)
		return generatePDFByResult($result, $targetDirectory, $sectionheader, "User ID: " . $user_id . "\\\\" . $userInfo[1]);
}

function generatePDFByResult($result, $targetDirectory, $sectionheader, $extrainfo = "PDF output") {
		global $config;
		$body_string = "";
		
		while($row = mysql_fetch_row($result)) {
				$body_string .= latexAppendQuestion($row[0], $row[1], $row[2], $row[3]);
		}
		
		if($body_string == "") $body_string = "No content in this application.";
		
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
				$line = str_replace('$TIME$', timeString(), $line);
				$line = str_replace('$EXTRAINFO$', $extrainfo, $line);
				$line = str_replace('$ORGANIZATION$', $config['organization_name'], $line);
				$line = str_replace('$SECTIONNAME$', $sectionheader, $line);
				
				$line = str_replace('$BODY$', $body_string, $line);
				fwrite($fout, $line);
		}
		
		fclose($fin);
		fclose($fout);
		
		//make the PDF
		$config = $GLOBALS['config'];
		
		$cdCommand = "cd " . $targetDirectory . $outFile;
		$pdfCommand = $config['latex_path'] . " --interaction=nonstopmode " . $outFile . ".tex";
		
		//execute pdf twice for lastpage to work (page # out of n)
		exec($cdCommand . " && " . $pdfCommand . " && " . $pdfCommand);
		
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

