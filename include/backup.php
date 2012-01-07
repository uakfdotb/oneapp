<?

//backs up the entire database into a single SQL file with mysqldump
function backupDatabase() {
	global $config;
	$host = escapeshellarg($config['db_hostname']);
	$username = escapeshellarg($config['db_username']);
	$password = escapeshellarg($config['db_password']);
	$database = escapeshellarg($config['db_name']);
	
	$filename = basePath() . '/backup/db-backup-' . time() . '-' . uid(4) . '.sql.gz';
	$output = shell_exec("mysqldump -u $username --password=$password --add-drop-table $database | gzip > $filename");
	
	return $filename;
}

//backs up all important files
// this basically means /submit and /pdf directories
function backupFiles() {
	$filename_prefix = basePath() . '/backup/files-backup-' . time() . '-' . uid(4) . '-';
	$submit_file = $filename_prefix . 'submit.zip';
	$pdf_file = $filename_prefix . 'pdf.zip';
	
	//well, let's just zip the directories one by one!
	$submit_result = backupZip(basePath() . "/submit/", $submit_file);
	$pdf_result = backupZip(basePath() . "/pdf/", $pdf_file);
	
	if($submit_result && $pdf_result)
		return array($submit_file, $pdf_file);
	else
		return false;
}

//zips a target directory
// code from http://stackoverflow.com/questions/1334613/how-to-recursively-zip-a-directory-in-php
function backupZip($source, $destination) {
	if(!extension_loaded('zip') || !file_exists($source)) {
		return false;
	}

	$zip = new ZipArchive();
	if(!$zip->open($destination, ZIPARCHIVE::CREATE)) {
		return false;
	}

	$source = str_replace('\\', '/', realpath($source));

	if(is_dir($source) === true) {
		$files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($source), RecursiveIteratorIterator::SELF_FIRST);

		foreach ($files as $file) {
			$file = str_replace('\\', '/', realpath($file));

			if (is_dir($file) === true) {
				$zip->addEmptyDir(str_replace($source . '/', '', $file . '/'));
			}
			else if (is_file($file) === true) {
				$zip->addFromString(str_replace($source . '/', '', $file), file_get_contents($file));
			}
		}
	} else if (is_file($source) === true) {
		$zip->addFromString(basename($source), file_get_contents($source));
	}

	return $zip->close();
}

?>
