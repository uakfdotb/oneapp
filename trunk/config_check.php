<html>
<body>
<table>
<tr>
	<th>Status</th>
	<th>Name</th>
	<th>Description</th>
</tr>

<?

if(file_exists('config.php') && is_readable('config.php')) {
	include("config.php");
	result('Configuration file', 'Configuration file is readable', true);
	
	if(isset($config)) {
		//make sure required values are set
		$config_keys = array('db_name', 'db_hostname', 'db_username', 'db_password', 'mail_smtp', 'mail_username', 'mail_password', 'mail_smtp_host', 'mail_smtp_port', 'site_name', 'organization_name', 'site_address', 'form_array_delimiter', 'lock_time_initial', 'lock_time_overload', 'lock_count_overload', 'lock_time_reset', 'lock_time_max', 'reset_time', 'activation_time', 'max_recommend', 'style', 'app_enabled', 'latex_path', 'page_display', 'page_display_names', 'apply_page_display', 'apply_page_display_names', 'apply_side_display', 'apply_side_display_names', 'root_page_display', 'root_page_display_names', 'root_side_display', 'root_side_display_names', 'admin_page_display', 'admin_page_display_names', 'admin_side_display', 'admin_side_display_names', 'time_dateformat', 'club_dateformat', 'limits', 'csrf_referer', 'csrf_token', 'rsa_modulus', 'rsa_exponent', 'rsa_key', 'rsa_passphrase', 'captcha_enabled');
		
		foreach($config_keys as $config_key) {
			if(!isset($config[$config_key])) {
				result("Config: " . $config_key, "Config key " . $config_key . " is not set (check config.php)", false);
			}
		}
	} else {
		result('Configuration variable', 'Configuration variable is not set (check config.php)', false);
	}
} else {
	result('Configuration file', 'config.php is not readable!', false);
}

if((bool) ini_get('register_globals') && strtolower(ini_get('register_globals')) != 'off') {
	result('PHP register_globals', 'PHP register_globals is enabled; this is obsolete and is a security risk', false);
} else {
	result('PHP register_globals', 'PHP register_globals is disabled', true);
}

if(function_exists('get_magic_quotes_gpc') && get_magic_quotes_gpc() == 1) {
	result('PHP magic quotes', 'PHP magic quotes are enabled, this could result in overquoted entries in database', false);
} else {
	result('PHP magic quotes', 'PHP magic quotes are disabled', true);
}

$connection = mysql_connect($config['db_hostname'], $config['db_username'], $config['db_password']);

if($connection === FALSE) {
	result('MySQL connection', 'Cannot connect to MySQL database', false);
} else {
	result('MySQL connection', 'Connection to MySQL database successful', true);
	$selectResult = mysql_select_db($config['db_name'], $connection);
	
	if($selectResult === FALSE) {
		result('MySQL database', 'Error while selecting MySQL database ' . $config['db_name'], false);
	} else {
		result('MySQL database', 'MySQL database exists', true);
		$mysqlResult = mysql_query("SELECT COUNT(*) FROM users"); //test if tables are created
		
		if($mysqlResult === FALSE) {
			result('MySQL tables', 'MySQL tables do not appear to be created', false);
		} else {
			result('MySQL tables', 'MySQL tables appear to be created', true);
			mysql_free_result($mysqlResult);
		}
	}
	
	mysql_close($connection);
}

if(isset($config['latex_path'])) {
	if(!file_exists($config['latex_path']) || !is_executable($config['latex_path'])) {
		result('LaTeX', 'LaTeX executable ' . $config['latex_path'] . ' does not exist or is not executable', false);
	} else {
		result('LaTeX', 'LaTeX executable seems to be working', true);
	}
}

if(!extension_loaded('zip')) {
	result('PHP zip extension', 'PHP zip extension is not loaded, file backups will not work', false);
} else {
	result('PHP zip extension', 'PHP zip extension is loaded', true);
}

if(!extension_loaded('gd')) {
	result('PHP gd extension', 'PHP gd extension is not loaded, statistics bars will not work', false);
} else {
	result('PHP gd extension', 'PHP gd extension is loaded', true);
}

if(!file_exists('submit') || !is_writable('submit')) {
	result('Submission directory', 'Submission directory submit/ does not exist or is not writable', false);
} else {
	result('Submission directory', 'Submission directory exists and is writable', true);
}

if(!file_exists('pdf') || !is_writable('pdf')) {
	result('PDF directory', 'PDF directory pdf/ does not exist or is not writable', false);
} else {
	result('PDF directory', 'PDF directory exists and is writable', true);
}

if(!file_exists('backup') || !is_writable('backup')) {
	result('Backup directory', 'Backup directory backup/ does not exist or is not writable', false);
} else {
	result('Backup directory', 'Backup directory exists and is writable', true);
}

if(isset($config['style'])) {
	if(!file_exists('style/' . $config['style'])) {
		result('Default style directory', 'Default style directory style/' . $config['style'] . ' does not exist', false);
	} else if(!file_exists('astyle/' . $config['style'])) {
		result('Default style directory', 'Default style directory astyle/' . $config['style'] . ' does not exist', false);
	} else {
		result('Default style directory', 'Default style directories exist', true);
	}
}

if(!in_array('sha512', hash_algos())) {
	result('Hash algorithm', 'The default hash algorithm, sha512, does not exist!', false);
} else {
	result('Hash algorithm', 'The default hash algorithm, sha512, exists', true);
}

if(!function_exists('openssl_random_pseudo_bytes')) {
	result('Secure random source', 'Preferred source, openssl_random_pseudo_bytes, does not exist', false);
} else {
	result('Secure random source', 'Preferred source, openssl_random_pseudo_bytes, exists', true);
}

if($config['csrf_referer'] || $config['csrf_token']) {
	result('CSRF prevention', 'At least one CSRF prevention technique is enabled', true);
} else {
	result('CSRF prevention', 'Both CSRF prevention techniques are disabled', false);
}

if((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443) {
	result('Encryption', 'HTTPS is enabled', true);
} else if($config['rsa_modulus'] != '' && $config['rsa_exponent'] != '' && $config['rsa_key'] != '') {
	result('Encryption', 'JavaScript-based RSA encryption is enabled for passwords', true);
} else {
	result('Encryption', 'HTTPS and RSA encryption are both disabled; passwords will be sent in plaintext', false);
}

function result($name, $desc, $status) {
	if($status) {
		echo '<tr bgcolor="#90EE90">';
		echo '<td>Good</td>';
	} else {
		echo '<tr bgcolor="#FF6347">';
		echo '<td>Error</td>';
	}
	
	echo "<td>$name</td>";
	echo "<td>$desc</td>";
	echo '</tr>';
}

?>

</table>
</body>
</html>
