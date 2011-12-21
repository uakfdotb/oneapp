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

?>
