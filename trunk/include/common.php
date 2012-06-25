<?php
function string_begins_with($string, $search)
{
	return (strncmp($string, $search, strlen($search)) == 0);
}

function boolToString($bool) {
	return $bool ? 'true' : 'false';
}

function escape($str) {
	return mysql_real_escape_string($str);
}

function escapePHP($str) {
	return addslashes($str);
}

function chash($str) {
	return hash('sha512', $str);
}

function chash2($str, $salt) {
	return hash('sha512', $salt . $str);
}

function toArray($str, $main_delimiter = ";", $sub_delimiter = ":") {
	$parts = explode($main_delimiter, $str);
	$array = array();
	
	foreach($parts as $part) {
		$part_array = explode($sub_delimiter, $part, 2);
		
		if(count($part_array) >= 2) {
			$key = trim($part_array[0]);
			$value = trim($part_array[1]);
			
			if($value == "false") $value = false;
			else if($value == "true") $value = true;
			
			$array[$key] = $value;
		}
	}
	
	return $array;
}

//returns an absolute path to the include directory, without trailing slash
function includePath() {
	$self = __FILE__;
	$lastSlash = strrpos($self, "/");
	return substr($self, 0, $lastSlash);
}

//returns a relative path to the oneapp/ directory, without trailing slash
function basePath() {
	$commonPath = __FILE__;
	$requestPath = $_SERVER['SCRIPT_FILENAME'];
	
	//count the number of slashes
	// number of .. needed for include level is numslashes(request) - numslashes(common)
	// then add one more to get to base
	$commonSlashes = substr_count($commonPath, '/');
	$requestSlashes = substr_count($requestPath, '/');
	$numParent = $requestSlashes - $commonSlashes + 1;
	
	$basePath = ".";
	for($i = 0; $i < $numParent; $i++) {
		$basePath .= "/..";
	}
	
	return $basePath;
}

function timeString($time = -1) {
	global $config;
	
	if($time == -1) $time = time();
	return date($config['time_dateformat'], $time);
}

function clubTimeString($time = -1) {
	global $config;
	
	if($time == -1) $time = time();
	return date($config['club_dateformat'], $time);
}

function one_mail($subject, $body, $to) { //returns true=ok, false=notok
	$config = $GLOBALS['config'];
	$from = filter_email($config['mail_username']);
	$subject = filter_name($subject);
	$to = filter_email($to);
	
	if(isset($config['mail_smtp']) && $config['mail_smtp']) {
		require_once "Mail.php";

		$host = $config['mail_smtp_host'];
		$port = $config['mail_smtp_port'];
		$username = $config['mail_username'];
		$password = $config['mail_password'];
		$headers = array ('From' => $from,
						  'To' => $to,
						  'Subject' => $subject,
						  'Content-Type' => 'text/html');
		$smtp = Mail::factory('smtp',
							  array ('host' => $host,
									 'port' => $port,
									 'auth' => true,
									 'username' => $username,
									 'password' => $password));

		$mail = $smtp->send($to, $headers, $body);

		if (PEAR::isError($mail)) {
			return false;
		} else {
			return true;
		}
	} else {
		$headers = "From: $from\r\n";
		$headers .= "To: $to\r\n";
		$headers .= "Content-type: text/html\r\n";
		return mail($to, $subject, $body, $headers);
	}
}

//..............
//PAGE FUNCTIONS
//..............

function getStyle() {
	if(isset($_SESSION['style'])) {
		return stripAlphaNumeric($_SESSION['style']);
	} else {
		$config = $GLOBALS['config'];
		return stripAlphaNumeric($config['style']);
	}
}

function get_page($page, $args = array()) {
	//let pages use some variables
	extract($args);
	$config = $GLOBALS['config'];
	$timeString = timeString();
	
	//figure out what pages need to be displayed
	$page_display = $config['page_display'];
	$page_display_names = $config['page_display_names'];
	
	$basePath = basePath();
	
	$style = getStyle();
	$stylePath = $basePath . "/style/$style";
	$style_page_include = "$stylePath/page/$page.php";
	$page_include = $basePath . "/page/$page.php";
	
	//update page display to include .php
	for($i = 0; $i < count($page_display); $i++) {
		if(strpos($page_display[$i], '.') === FALSE) {
			$page_display[$i] .= '.php';
		}
	}
	
	if(file_exists("$stylePath/header.php")) {
		include("$stylePath/header.php");
	}
	
	if(file_exists($style_page_include)) {
		include($style_page_include);
	} else {
		include($page_include);
	}
	
	if(file_exists("$stylePath/footer.php")) {
		include("$stylePath/footer.php");
	}
}

function get_page_advanced($page, $context, $args = array()) {
	//let pages use some variables
	extract($args);
	$config = $GLOBALS['config'];
	$timeString = timeString();
	
	//figure out what pages need to be displayed
	if($context != "apply" && $context != "root" && $context != "admin") {
		$context = "apply"; //this should never happen
	}
	
	$page_display = $config[$context . '_page_display'];
	$page_display_names = $config[$context . '_page_display_names'];
	
	//add links back to specific areas (apply, root, admin)
	if($context != "apply") {
		$page_display[] = "../application/";
		$page_display_names[] = "Application";
	}
	
	if($context != "root" && isset($_SESSION['user_id']) && isRoot($_SESSION['user_id'])) {
		$page_display[] = "../root/";
		$page_display_names[] = "Root";
	}
	
	if($context != "admin" && isset($_SESSION['user_id']) && isAdmin($_SESSION['user_id'])) {
		$page_display[] = "../admin/";
		$page_display_names[] = "Admin";
	}
	
	//for admin and root areas, add anti-CSRF strings if needed
	$t = '';
	$t_hidden = '';
	$t_get = 't=disabled';
	
	if($context == "admin" || $context == "root") {
		if($config['csrf_token']) {
			$key = "ais";
			if($context == "root") $key = "ris";
			
			$t = $_SESSION['t'];
			$t_hidden = "<input type=\"hidden\" name=\"$key\" value=\"$t\" />";
			$t_get = "$key=$t";
		}
	}
	
	$side_display = $config[$context . '_side_display'];
	$side_display_names = $config[$context . '_side_display_names'];
	
	//update page and side display to include .php
	for($i = 0; $i < count($side_display); $i++) {
		if(strpos($side_display[$i], '.') === FALSE) {
			$side_display[$i] .= '.php';
		}
		
		//also include token if needed
		if($t != '') {
			if(strpos($side_display[$i], '?') === FALSE) {
				$side_display[$i] .= "?";
			} else {
				$side_display[$i] .= "&";
			}
			
			$side_display[$i] .= $t_get;
		}
	}
	
	for($i = 0; $i < count($page_display); $i++) {
		if(strpos($page_display[$i], '.') === FALSE) {
			$page_display[$i] .= '.php';
		}
		
		//also include token if needed
		if($t != '') {
			if(strpos($page_display[$i], '?') === FALSE) {
				$page_display[$i] .= "?";
			} else {
				$page_display[$i] .= "&";
			}
			
			$page_display[$i] .= $t_get;
		}
	}
	
	$basePath = basePath();
	
	$style = getStyle();
	$stylePath = $basePath . "/astyle/$style";
	$style_page_include = "$stylePath/$context/$page.php";
	$page_include = $basePath . "/page/$context/$page.php";
	
	if(file_exists("$stylePath/header.php")) {
		include("$stylePath/header.php");
	}
	
	if(file_exists($style_page_include)) {
		include($style_page_include);
	} else {
		include($page_include);
	}
	
	if(file_exists("$stylePath/footer.php")) {
		include("$stylePath/footer.php");
	}
}


//this is called from pages to include another page
function page_advanced_include($target, $context, $args = array()) {
	//let pages use some variables
	extract($args);
	$config = $GLOBALS['config'];
	$timeString = timeString();
	
	if($context != "apply" && $context != "root" && $context != "admin") {
		$context = "apply"; //this should never happen
	}
	
	//for admin and root areas, add anti-CSRF strings if needed
	$t = '';
	$t_hidden = '';
	$t_get = 't=disabled';
	
	if($context == "admin" || $context == "root") {
		if($config['csrf_token']) {
			$key = "ais";
			if($context == "root") $key = "ris";
			
			$t = $_SESSION['t'];
			$t_hidden = "<input type=\"hidden\" name=\"$key\" value=\"$t\" />";
			$t_get = "$key=$t";
		}
	}
	
	$basePath = basePath();
	
	$style = getStyle();
	$stylePath = $basePath . "/astyle/$style";
	$style_page_include = "$stylePath/$context/$target.php";
	$page_include = $basePath . "/page/$context/$target.php";
	
	if(file_exists($style_page_include)) {
		include($style_page_include);
	} else {
		include($page_include);
	}
}

function style_function($name) {
	$basePath = basePath();
	$style = getStyle();
	$stylePath = $basePath . "/astyle/$style";
	
	if(file_exists($stylePath . "/include.php")) {
		include_once($stylePath . "/include.php");
		
		if(function_exists($style . "_" . $name)) {
			return $style . "_" . $name;
		} else {
			return FALSE;
		}
	} else {
		return FALSE;
	}
}

function page_exists($page) {
	return file_exists("page/" . $page . ".php");
}

function page_db($page) {
	return page_convert(page_db_part($page));
}

function page_db_part($page) {
	$page = escape($page);
	$result = mysql_query("SELECT text FROM pages WHERE name='$page'");
	
	if($row = mysql_fetch_array($result)) {
		return $row['text'];
	} else {
		include(includePath() . "/default_pages.php");
		
		if(isset($pages[$page])) {
			return $pages[$page];
		} else {
			return "[h1]Error[/h1][p]Error: this page has not been edited yet.[/p]";
		}
	}
}

function page_convert($str) {
	$config = $GLOBALS['config'];
	
	//see if style provides this function
	$styleFunction = style_function("page_convert");
	if($styleFunction !== FALSE) {
		return $styleFunction($str);
	}

	$str = htmlentities($str);

	$bbcode = array('[color="', "[/color]",
				"[size=\"", "[/size]",
				"[quote]", "[/quote]",
				'"]');
	$htmlcode = array("<span style=\"color:", "</span>",
				"<span style=\"font-size:", "</span>",
				"<table width=100% bgcolor=lightgray><tr><td bgcolor=white>", "</td></tr></table>",
				'">');
	$str = str_replace($bbcode, $htmlcode, $str);
	
	$str = str_replace("[p]", "<p>", $str);
	$str = str_replace("[/p]", "</p>", $str);
	$str = str_replace("\r", "", $str);
	$str = str_replace("[br]", "<br>", $str);
	$str = str_replace("[b]", "<b>", $str);
	$str = str_replace("[/b]", "</b>", $str);
	$str = str_replace("[h1]", "<h1>", $str);
	$str = str_replace("[/h1]", "</h1>", $str);
	$str = str_replace("[h2]", "<h2>", $str);
	$str = str_replace("[/h2]", "</h2>", $str);
	$str = str_replace("[h3]", "<h3>", $str);
	$str = str_replace("[/h3]", "</h3>", $str);
	$str = str_replace("[h4]", "<h4>", $str);
	$str = str_replace("[/h4]", "</h4>", $str);
	$str = str_replace("[table]", "<table>", $str);
	$str = str_replace("[/table]", "</table>", $str);
	$str = str_replace("[tr]", "<tr>", $str);
	$str = str_replace("[/tr]", "</tr>", $str);
	$str = str_replace("[td]", "<td>", $str);
	$str = str_replace("[/td]", "</td>", $str);
	$str = str_replace("[th]", "<th>", $str);
	$str = str_replace("[/th]", "</th>", $str);
	$str = str_replace("[strong]", "<strong>", $str);
	$str = str_replace("[/strong]", "</strong>", $str);
	$str = preg_replace('@\[(?i)image\]\s*(.*?)\[/(?i)image\]@si', '<img src="\\1">', $str);
	$str = preg_replace('@\[(?i)url=\s*(.*?)\]\s*(.*?)\[/(?i)url\]@si', '<a href="\\1" target="_blank">\\2</a>', $str);
	$str = str_replace("[u]", "<u>", $str);
	$str = str_replace("[/u]", "</u>", $str);
	$str = str_replace("[i]", "<i>", $str);
	$str = str_replace("[/i]", "</i>", $str);
	$str = str_replace("[hr]", "<hr>", $str);
	$str = str_replace('$site_name$', $config['site_name'], $str);
	//now add linebreaks if the user didn't add them manually
	// before we add them we delete all linebreaks that we don't need
	$str = str_replace(">\n<", "><", $str);
	$str = str_replace(">\n\n<", "><", $str);
	// now just replace
	$str = str_replace("\n", "<br>", $str);
	return $str;
}

function deletePage($page) {
	$page = escape($page);
	mysql_query("DELETE FROM pages WHERE name='$page'");
}

function savePage($page, $text) {
	$page = escape($page);
	$text = escape($text);
	
	$result = mysql_query("SELECT id FROM pages WHERE name='$page'");
	if($row = mysql_fetch_row($result)) {
		$id = escape($row[0]);
		mysql_query("UPDATE pages SET text='$text' WHERE id='$id'");
	} else {
		mysql_query("INSERT INTO pages (name, text) VALUES ('$page', '$text')");
	}
}

//...................
//DATABASE OPERATIONS
//...................

//0: success; 1: field length too long or too short; 2: captcha failed
//3: email address invalid or in use; 4: database error; 5: username in use;
//6: email error; 7: try again later; 8: disabled; 9: name invalid
function register($username, $name, $email, $profile, $captcha) {
	if(!checkLock("register")) {
		return 7;
	}
	
	//verify that fields have been properly entered
	if(strlen($username) == 0 || strlen($email) == 0) {
		return 1;
	}
	
	//verify name
	if(strlen($name) < 4) {
		return 9;
	}
	
	//check if registration is enabled
	$config = $GLOBALS['config'];
	if(!$config['app_enabled']) {
		return 8;
	}
	
	//make sure that there are not too many users
	if(isset($config['limits']) && isset($config['limits']['users']) && $config['limits']['users'] > 0) {
		$result = mysql_query("SELECT COUNT(*) FROM users");
		$row = mysql_fetch_array($result);
		
		if($row[0] >= $config['limits']['users']) {
			return 8;
		}
	}
	
	$username = escape($username);
	$name = escape($name);
	$email = escape($email);
	$gen_salt = secure_random_bytes(20);
	$db_salt = escape(bin2hex($gen_salt));
	$gen_password = uid(12);
	$password = escape(chash2($gen_password, $salt));
	
	//validate email address (after MySQL escaping...)
	if(!validEmail($email)) {
		return 3;
	}
	
	//verify that email and username are not in use
	// we check each one separately to respond with different error codes
	$result = mysql_query("SELECT id FROM users WHERE email='" . $email . "'");
	
	if(mysql_num_rows($result) > 0) {
		return 3;
	}
	
	$result = mysql_query("SELECT id FROM users WHERE username='$username'");
	
	if(mysql_num_rows($result) > 0) {
		return 5;
	}
	
	//verify the captcha
	if($config['captcha_enabled']) {
		include_once basePath() . '/securimage/securimage.php';
		$securimage = new Securimage();
	
		if ($securimage->check($captcha) == false) {
			// the code was incorrect
			return 2;
		}
	}
	
	$registerTime = time();
	
	//delete old accounts
	// these are accounts that have not been accessed (accessed=0 in oneapp.users) with register_time < time() - config[activation_time]
	$activeTime = $registerTime - $config['activation_time'];
	mysql_query("DELETE FROM users WHERE accessed = '0' AND register_time < '$activeTime'");
	
	lockAction("register");
	$result = mysql_query("INSERT INTO users (username, name, password, salt, email, register_time, accessed) VALUES ('$username', '$name', '$password', '$db_salt', '$email', '$registerTime', '0')");
	
	if($result !== FALSE) {
		$user_id = mysql_insert_id();
		
		foreach($profile as $var_id => $item) {
			$val = escape($item[1]);
			mysql_query("INSERT INTO profiles (user_id, var_id, val) VALUES ('$user_id', '$var_id', '$val')");
		}
		
		//initiate messaging default preferences
		initMessaging($user_id);
		
		//send email
		$content = page_db("registration");
		$content = str_replace('$USERNAME$', $username, $content);
		$content = str_replace('$NAME$', $name, $content);
		$content = str_replace('$PASSWORD$', $gen_password, $content);
		$content = str_replace('$EMAIL$', $email, $content);
		$content = str_replace('$LOGIN_ADDRESS$', $config['site_address'] . "/login.php", $content);
		
		$result = one_mail($config['site_name'] . " Registration", $content, $email);
		
		if($result) {
			return 0;
		} else {
			return 6;
		}
	} else {
		return 4;
	}
}

//0: success; -1: invalid password; -2: try again later;
//1: new password too short; 10: invalid new email address; 11: passwords do not match
function updateAccount($user_id, $oldPassword, $newPassword, $newPasswordConfirm, $newEmail) {
	$user_id = escape($user_id);
	$result = verifyLogin($_SESSION['user_id'], $_POST['old_password']);
	
	if($result === TRUE) {
		$set_string = "";
		
		//decrypt the password if needed
		require_once(includePath() . "/crypto.php");
		$newPassword = decryptPassword($newPassword);
		$newPasswordConfirm = decryptPassword($newPasswordConfirm);
		
		if(strlen($newPassword) > 0 || strlen($newPasswordConfirm) > 0) {
			if(strlen($newPassword) >= 6) { //enforce minimum password length of six
				if($newPassword == $newPasswordConfirm) {
					$validPassword =  validPassword($newPassword);
			
					if($validPassword == 0) {
						$gen_salt = secure_random_bytes(20);
						$db_salt = escape(bin2hex($gen_salt));
						$set_string .= "password = '" . escape(chash2($newPassword, $gen_salt)) . "', salt = '$db_salt', ";
					} else {
						return $validPassword;
					}
				} else {
					return 11;
				}
			} else {
				return 1;
			}
		}
		
		if(strlen($newEmail) > 0) {
			if(validEmail($newEmail)) {
				$set_string .= "email = '" . escape($newEmail) . "', ";
			} else {
				return 10;
			}
		}
		
		if(strlen($set_string) > 0) {
			$set_string = substr($set_string, 0, strlen($set_string) - 2); //get rid of trailing comma and space
			mysql_query("UPDATE users SET " . $set_string . " WHERE id='$user_id'");
		}
		
		return 0;
	} else {
		return $result;
	}
}

//user id: success; -1: invalid login; -2: try again later; -3: login disabled
function checkLogin($username, $password) {
	if(!checkLock("checkuser")) {
		return -2;
	}
	
	$config = $GLOBALS['config'];
	if(!$config['app_enabled']) {
		return -3;
	}
	
	//decrypt the password if needed
	require_once(includePath() . "/crypto.php");
	$password = decryptPassword($password);
	
	$username = escape($username);
	$result = mysql_query("SELECT id, password, salt FROM users WHERE username='" . $username . "'");
	
	if($row = mysql_fetch_array($result)) {
		if(strcmp(chash2($password, hex2bin($row['salt'])), $row['password']) == 0) {
			//update this user's last login time (users.accessed)
			$loginTime = time();
			mysql_query("UPDATE users SET accessed = '$loginTime' WHERE id = '" . $row['id'] . "'");
			
			return $row['id'];
		} else {
			lockAction("checkuser");
			return -1;
		}
	} else {
		lockAction("checkuser");
		return -1;
	}
}

//returns array (variable name, response, id)
function getProfile($userid) {
	$userid = escape($userid);
	$result = mysql_query("SELECT var_id, val FROM profiles WHERE user_id = '$userid'");
	
	$uprofile = array();
	while($row = mysql_fetch_array($result)) {
		$var_id = $row['var_id'];
		$val = $row['val'];
		$uprofile[$var_id] = $val;
	}
	
	$result = mysql_query("SELECT id, varname FROM baseapp WHERE category = '0' ORDER BY orderId");
	
	$profile = array();
	while($row = mysql_fetch_array($result)) {
		$var_id = $row['id'];
		$var_name = $row['varname'];
		
		if(array_key_exists($var_id, $uprofile)) {
			array_push($profile, array($var_name, $uprofile[$var_id], $var_id));
		} else {
			array_push($profile, array($var_name, '', $var_id));
		}
	}
	
	return $profile;
}

//returns user_id, or FALSE on failure
function getUserId($username) {
	$username = escape($username);
	$result = mysql_query("SELECT id FROM users WHERE username = '$username'");
	
	if($row = mysql_fetch_row($result)) {
		return $row[0];
	} else {
		return FALSE;
	}
}

//returns array (username, email address, name)
function getUserInformation($user_id) {
	$user_id = escape($user_id);
	$result = mysql_query("SELECT username, email, name FROM users WHERE id='$user_id'");
	
	if($row = mysql_fetch_array($result)) {
		return array($row[0], $row[1], $row[2]);
	} else {
		return FALSE;
	}
}

//true: success; -1: invalid login; -2: try again later
function verifyLogin($user_id, $password) {
	if(!checkLock("checkuser")) {
		return -2;
	}
	
	$user_id = escape($user_id);
	
	//decrypt the password if needed
	require_once(includePath() . "/crypto.php");
	$password = decryptPassword($password);
	
	$result = mysql_query("SELECT password, salt FROM users WHERE id='" . $user_id . "'");
	
	if($row = mysql_fetch_array($result)) {
		if(chash2($password, hex2bin($row['salt'])) == $row['password']) {
			return true;
		} else {
			lockAction("checkuser");
			return -1;
		}
	} else {
		lockAction("checkuser");
		return -1;
	}
}

//true: success; -1: invalid login; -2: try again later; 1: invalid club
function checkAdminLogin($user_id, $password, $club_id) {
	$user_id = escape($user_id);
	$club_id = escape($club_id);

	//first verify login information
	$login_result = verifyLogin($user_id, $password);
	
	if($login_result === TRUE) {
		//check that admin owns the club
		//make sure to exclude root (gorup=-1)
		$result = mysql_query("SELECT COUNT(*) FROM user_groups WHERE user_id = '$user_id' AND `group` = '$club_id' AND `group` != '-1'");
		$row = mysql_fetch_row($result);
		
		if($row[0] == 0) {
			return 1;
		} else {
			return TRUE;
		}
	} else {
		return $login_result;
	}
}

//true: success; -1: invalid login; -2: try again later; 1: not root administrator
function checkRootLogin($user_id, $password) {
	$user_id = escape($user_id);

	//first verify login information
	$login_result = verifyLogin($user_id, $password);
	
	if($login_result === TRUE) {
		//check that admin is a root administrator
		$isRoot = isRoot($user_id);
		
		if(!$isRoot) {
			return 1;
		} else {
			return TRUE;
		}
	} else {
		return $login_result;
	}
}

//true: the user is an admin
//false: otherwise
function isAdmin($user_id) {
	$user_id = escape($user_id);
	
	$result = mysql_query("SELECT COUNT(*) FROM user_groups WHERE `group` != '-1' AND user_id = '$user_id'");
	$row = mysql_fetch_row($result);
	
	if($row[0] == 0) {
		return FALSE;
	} else {
		return TRUE;
	}
}

function isRoot($user_id) {
	$user_id = escape($user_id);
	
	$result = mysql_query("SELECT COUNT(*) FROM user_groups WHERE `group` = '-1' AND user_id = '$user_id'");
	$row = mysql_fetch_row($result);
	
	if($row[0] == 0) {
		return FALSE;
	} else {
		return TRUE;
	}
}

//returns list of group_id => group_name that admin can manage via admin area, or empty list of none
function getAdminGroups($user_id) {
	$user_id = escape($user_id);
	
	//first add regular clubs
	$result = mysql_query("SELECT `group`, clubs.name FROM user_groups LEFT JOIN clubs ON clubs.id = `group` WHERE user_id='$user_id' AND `group` > '0'");
	
	$clubs_array = array();
	
	while($row = mysql_fetch_row($result)) {
		$clubs_array[$row[0]] = $row[1];
	}
	
	//add general application if needed
	$result = mysql_query("SELECT COUNT(*) FROM user_groups WHERE user_id =' $user_id' AND `group` = '0'");
	$row = mysql_fetch_row($result);
	
	if($row[0] > 0) {
		$clubs_array[0] = 'General application';
	}
	
	//add custom if needed
	$result = mysql_query("SELECT COUNT(*) FROM user_groups WHERE user_id =' $user_id' AND `group` = '-2'");
	$row = mysql_fetch_row($result);
	
	if($row[0] > 0) {
		$clubs_array[-2] = 'Custom fields';
	}
	
	return $clubs_array;
}

//can be used to add, remove, or alter a user group association
// if club_id = false or association doesn't exist, association will be added
// if new_club_id = false, association will be removed
// otherwise, association will be altered
//returns TRUE in success, FALSE on failure
function alterAdminGroups($user_id, $club_id, $new_club_id) {
	//return if we have nothing to do
	if($club_id === $new_club_id) return true;
	
	$user_id = escape($user_id);
	
	if($club_id !== FALSE) {
		$club_id = escape($club_id);
	}
	
	if($new_club_id !== FALSE) {
		$new_club_id = escape($new_club_id);
	}
	
	$old_association = FALSE;
	
	//verify existing association
	if($club_id !== false) {
		$result = mysql_query("SELECT COUNT(*) FROM user_groups WHERE user_id = '$user_id' AND `group` = '$club_id'");
		$row = mysql_fetch_row($result);
		
		if($row[0] > 0) {
			$old_association = TRUE;
		}
	}
	
	//invalidate new_club_id if it exists already
	// in this case, we just delete club_id association
	if($new_club_id !== false) {
		$result = mysql_query("SELECT COUNT(*) FROM user_groups WHERE user_id = '$user_id' AND `group` = '$new_club_id'");
		$row = mysql_fetch_row($result);
		
		if($row[0] > 0) {
			$new_club_id = false;
		}
	}
	
	if($old_association) {
		//update or delete existing association
		if($new_club_id === false) {
			mysql_query("DELETE FROM user_groups WHERE user_id = '$user_id' AND `group` = '$club_id'");
		} else {
			mysql_query("UPDATE user_groups SET `group` = '$new_club_id' WHERE user_id = '$user_id' AND `group` = '$club_id'");
		}
	} else if($new_club_id !== false) { //only add an association if we're not trying to delete it!
		mysql_query("INSERT INTO user_groups (user_id, `group`) VALUES ('$user_id', '$new_club_id')");
	}
	
	return TRUE;
}

//returns array of (club id, club name, club description, user's application id)
function getUserClubsApplied($user_id) {
	$user_id = escape($user_id);
	$result = mysql_query("SELECT applications.club_id, clubs.name, clubs.description, applications.id FROM applications, clubs WHERE applications.user_id='$user_id' AND applications.club_id = clubs.id AND applications.club_id != '0' ORDER BY clubs.name");
	
	$clubs = array();
	while($row = mysql_fetch_array($result)) {
		array_push($clubs, array($row[0], $row[1], $row[2], $row[3]));
	}
	
	return $clubs;
}

//returns id in applications table based on user_id and club_id, or -1 on fail
function getApplicationByUserClub($user_id, $club_id) {
	$user_id = escape($user_id);
	$club_id = escape($club_id);
	
	$result = mysql_query("SELECT id FROM applications WHERE user_id='$user_id' AND club_id='$club_id'");
	
	if($row = mysql_fetch_array($result)) {
		return $row[0];
	} else {
		return -1;
	}
}

//returns array (club name, club description, open_time, close_time, num_recommendations)
function clubInfo($club_id) {
	$club_id = escape($club_id);
	$result = mysql_query("SELECT name, description, open_time, close_time, num_recommend FROM clubs WHERE id='$club_id'");
	
	if($row = mysql_fetch_array($result)) {
		return array($row[0], $row[1], clubTimeString($row[2]), clubTimeString($row[3]), $row[4]);
	} else {
		return array("Unknown", "Club could not be found");
	}
}

//returns array of club_id => club_name
function listClubsIdName() {
	$result = mysql_query("SELECT id, name FROM clubs");
	$array = array();
	
	while($row = mysql_fetch_row($result)) {
		$array[$row[0]] = $row[1];
	}
	
	return $array;
}

//returns boolean: true=proceed, false=lock up; the difference between this and lockAction is that this can be used for repeated tasks, like admin
// then, only if action was unsuccessful would lockAction be called
function checkLock($action) {
	global $config;
	$lock_time_initial = $config['lock_time_initial'];
	$lock_time_overload = $config['lock_time_overload'];
	$lock_count_overload = $config['lock_count_overload'];
	$lock_time_reset = $config['lock_time_reset'];
	$lock_time_max = $config['lock_time_max'];
	
	if(!isset($lock_time_initial[$action])) {
		return true; //well we can't do anything...
	}
	
	$ip = escape($_SERVER['REMOTE_ADDR']);
	$action = escape($action);
	
	$result = mysql_query("SELECT id,time,num FROM locks WHERE ip='" . $ip . "' AND action='" . $action . "'") or die(mysql_error());
	if($row = mysql_fetch_array($result)) {
		$id = $row['id'];
		$time = $row['time'];
		$count = $row['num']; //>=0 count means it's a regular initial lock; -1 count means overload lock

		if($count >= 0) {
			if(time() <= $time + $lock_time_initial[$action]) {
				return false;
			}
		} else {
			if(time() <= $time + $lock_time_overload[$action]) {
				return false;
			}
		}
	}
	
	return true;
}

//returns boolean: true=proceed, false=lock up
function lockAction($action) {
	global $config;
	$lock_time_initial = $config['lock_time_initial'];
	$lock_time_overload = $config['lock_time_overload'];
	$lock_count_overload = $config['lock_count_overload'];
	$lock_time_reset = $config['lock_time_reset'];
	$lock_time_max = $config['lock_time_max'];
	
	if(!isset($lock_time_initial[$action])) {
		return true; //well we can't do anything...
	}

	$ip = escape($_SERVER['REMOTE_ADDR']);
	$action = escape($action);
	$replace_id = -1;

	//first find records with ip/action
	$result = mysql_query("SELECT id,time,num FROM locks WHERE ip='" . $ip . "' AND action='" . $action . "'") or die(mysql_error());
	if($row = mysql_fetch_array($result)) {
		$id = $row['id'];
		$time = $row['time'];
		$count = $row['num']; //>=0 count means it's a regular initial lock; -1 count means overload lock

		if($count >= 0) {
			if(time() <= $time + $lock_time_initial[$action]) {
				return false;
			} else if(time() > $time + $lock_time_reset) {
				//this entry is old, but use it to replace
				$replace_id = $id;
			} else {
				//increase the count; maybe initiate an OVERLOAD
				$count = $count + 1;
				if($count >= $lock_count_overload[$action]) {
					mysql_query("UPDATE locks SET num='-1', time='" . time() . "' WHERE ip='" . $ip . "'") or die(mysql_error());
					return false;
				} else {
					mysql_query("UPDATE locks SET num='" . $count . "', time='" . time() . "' WHERE ip='" . $ip . "'") or die(mysql_error());
				}
			}
		} else {
			if(time() <= $time + $lock_time_overload[$action]) {
				return false;
			} else {
				//their overload is over, so this entry is old
				$replace_id = $id;
			}
		}
	} else {
		mysql_query("INSERT INTO locks (ip, time, action, num) VALUES ('" . $ip . "', '" . time() . "', '" . $action . "', '1')") or die(mysql_error());
	}

	if($replace_id != -1) {
		mysql_query("UPDATE locks SET num='1', time='" . time() .  "' WHERE id='" . $replace_id . "'") or die(mysql_error());
	}

	//some housekeeping
	$delete_time = time() - $lock_time_max;
	mysql_query("DELETE FROM locks WHERE time<='" . $delete_time . "'");

	return true;
}

//.....
//OTHER
//.....

function getExtension($file_name) {
  return substr(strrchr($file_name,'.'),1);  
}

function uid($length) {
	$characters = "0123456789abcdefghijklmnopqrstuvwxyz";
	$string = "";	

	for ($p = 0; $p < $length; $p++) {
		$string .= $characters[mt_rand(0, strlen($characters) - 1)];
	}

	return $string;
}

function unlink_if_exists($str) {
	if(file_exists($str)) {
		unlink($str);
		return true;
	}

	return false;
}

function isAlphaNumeric($str) {
	return ctype_alnum($str);
}

function stripAlphaNumeric($str) {
	return preg_replace("/[^a-zA-Z0-9\s]/", "", $str);
}

function recursiveCopy( $path, $dest )
{
	if( is_dir($path) )
	{
		mkdir( $dest );
		$objects = scandir($path);
		if( sizeof($objects) > 0 )
		{
			foreach( $objects as $file )
			{
				if( $file == "." || $file == ".." )
					continue;
				// go on
				if( is_dir( $path.DIRECTORY_SEPARATOR.$file ) )
				{
					recursiveCopy( $path.DIRECTORY_SEPARATOR.$file, $dest.DIRECTORY_SEPARATOR.$file );
				}
				else
				{
					copy( $path.DIRECTORY_SEPARATOR.$file, $dest.DIRECTORY_SEPARATOR.$file );
				}
			}
		}
		return true;
	}
	elseif( is_file($path) )
	{
		return copy($path, $dest);
	}
	else
	{
		return false;
	}
}

function delete_directory($dirname) {
	if (is_dir($dirname))
		$dir_handle = opendir($dirname);
	if (!$dir_handle)
		return false;
	while($file = readdir($dir_handle)) {
		if ($file != "." && $file != "..") {
			if (!is_dir($dirname."/".$file))
				unlink($dirname."/".$file);
			else
				delete_directory($dirname.'/'.$file);	 
		}
	}
	closedir($dir_handle);
	rmdir($dirname);
	return true;
}

function list_directory($dirname) {
	$results = array();
	$handler = opendir($dirname);

	// open directory and walk through the filenames
	while ($file = readdir($handler)) {
		if (substr($file, -4) == ".pdf") {
			$results[] = $file;
		}
	}

	closedir($handler);
	return $results;
}

//0: success; 1: less than 6 characters
function validPassword($password) {
	if(strlen($password) < 6) {
		return 1;
	}
	
	return 0;
}

function validEmail($email)
{
   $isValid = true;
   $atIndex = strrpos($email, "@");
   if (is_bool($atIndex) && !$atIndex)
   {
	  $isValid = false;
   }
   else
   {
	  $domain = substr($email, $atIndex+1);
	  $local = substr($email, 0, $atIndex);
	  $localLen = strlen($local);
	  $domainLen = strlen($domain);
	  if ($localLen < 1 || $localLen > 64)
	  {
		 // local part length exceeded
		 $isValid = false;
	  }
	  else if ($domainLen < 1 || $domainLen > 255)
	  {
		 // domain part length exceeded
		 $isValid = false;
	  }
	  else if ($local[0] == '.' || $local[$localLen-1] == '.')
	  {
		 // local part starts or ends with '.'
		 $isValid = false;
	  }
	  else if (preg_match('/\\.\\./', $local))
	  {
		 // local part has two consecutive dots
		 $isValid = false;
	  }
	  else if (!preg_match('/^[A-Za-z0-9\\-\\.]+$/', $domain))
	  {
		 // character not valid in domain part
		 $isValid = false;
	  }
	  else if (preg_match('/\\.\\./', $domain))
	  {
		 // domain part has two consecutive dots
		 $isValid = false;
	  }
	  else if (!preg_match('/^(\\\\.|[A-Za-z0-9!#%&`_=\\/$\'*+?^{}|~.-])+$/', str_replace("\\\\","",$local)))
	  {
		 // character not valid in local part unless 
		 // local part is quoted
		 if (!preg_match('/^"(\\\\"|[^"])+"$/',
			 str_replace("\\\\","",$local)))
		 {
			$isValid = false;
		 }
	  }
	  if ($isValid && !(checkdnsrr($domain,"MX") || checkdnsrr($domain,"A")))
	  {
		 // domain not found in DNS
		 $isValid = false;
	  }
   }
   return $isValid;
}

//filter email name
function filter_name( $input ) {
	$rules = array( "\r" => '', "\n" => '', "\t" => '', '"'  => "'", '<'  => '[', '>'  => ']' );
	$name = trim( strtr( $input, $rules ) );
	return $name;
}

//filter email address
function filter_email( $input ) {
	$rules = array( "\r" => '', "\n" => '', "\t" => '', '"'  => '', ','  => '', '<'  => '', '>'  => '' );
	$email = strtr( $input, $rules );
	return $email;
}

function hex2bin($h) {
	if (!is_string($h)) {
		return null;
	}
	
	$r = '';
	for($a = 0; $a < strlen($h); $a += 2) {
		$r .= chr(hexdec($h{$a} . $h{($a + 1)}));
	}
	return $r;
}

//secure_random_bytes from https://github.com/GeorgeArgyros/Secure-random-bytes-in-PHP
/*
* The function is providing, at least at the systems tested :),
* $len bytes of entropy under any PHP installation or operating system.
* The execution time should be at most 10-20 ms in any system.
*/
function secure_random_bytes($len = 10) {
 
   /*
* Our primary choice for a cryptographic strong randomness function is
* openssl_random_pseudo_bytes.
*/
   $SSLstr = '4'; // http://xkcd.com/221/
   if (function_exists('openssl_random_pseudo_bytes') &&
       (version_compare(PHP_VERSION, '5.3.4') >= 0 ||
substr(PHP_OS, 0, 3) !== 'WIN'))
   {
      $SSLstr = openssl_random_pseudo_bytes($len, $strong);
      if ($strong)
         return $SSLstr;
   }

   /*
* If mcrypt extension is available then we use it to gather entropy from
* the operating system's PRNG. This is better than reading /dev/urandom
* directly since it avoids reading larger blocks of data than needed.
* Older versions of mcrypt_create_iv may be broken or take too much time
* to finish so we only use this function with PHP 5.3 and above.
*/
   if (function_exists('mcrypt_create_iv') &&
      (version_compare(PHP_VERSION, '5.3.0') >= 0 ||
       substr(PHP_OS, 0, 3) !== 'WIN'))
   {
      $str = mcrypt_create_iv($len, MCRYPT_DEV_URANDOM);
      if ($str !== false)
         return $str;	
   }


   /*
* No build-in crypto randomness function found. We collect any entropy
* available in the PHP core PRNGs along with some filesystem info and memory
* stats. To make this data cryptographically strong we add data either from
* /dev/urandom or if its unavailable, we gather entropy by measuring the
* time needed to compute a number of SHA-1 hashes.
*/
   $str = '';
   $bits_per_round = 2; // bits of entropy collected in each clock drift round
   $msec_per_round = 400; // expected running time of each round in microseconds
   $hash_len = 20; // SHA-1 Hash length
   $total = $len; // total bytes of entropy to collect

   $handle = @fopen('/dev/urandom', 'rb');
   if ($handle && function_exists('stream_set_read_buffer'))
      @stream_set_read_buffer($handle, 0);

   do
   {
      $bytes = ($total > $hash_len)? $hash_len : $total;
      $total -= $bytes;

      //collect any entropy available from the PHP system and filesystem
      $entropy = rand() . uniqid(mt_rand(), true) . $SSLstr;
      $entropy .= implode('', @fstat(@fopen( __FILE__, 'r')));
      $entropy .= memory_get_usage();
      if ($handle)
      {
         $entropy .= @fread($handle, $bytes);
      }
      else
      {	
         // Measure the time that the operations will take on average
         for ($i = 0; $i < 3; $i ++)
         {
            $c1 = microtime(true);
            $var = sha1(mt_rand());
            for ($j = 0; $j < 50; $j++)
            {
               $var = sha1($var);
            }
            $c2 = microtime(true);
     $entropy .= $c1 . $c2;
         }

         // Based on the above measurement determine the total rounds
         // in order to bound the total running time.
         $rounds = (int)($msec_per_round*50 / (int)(($c2-$c1)*1000000));

         // Take the additional measurements. On average we can expect
         // at least $bits_per_round bits of entropy from each measurement.
         $iter = $bytes*(int)(ceil(8 / $bits_per_round));
         for ($i = 0; $i < $iter; $i ++)
         {
            $c1 = microtime();
            $var = sha1(mt_rand());
            for ($j = 0; $j < $rounds; $j++)
            {
               $var = sha1($var);
            }
            $c2 = microtime();
            $entropy .= $c1 . $c2;
         }
            
      }
      // We assume sha1 is a deterministic extractor for the $entropy variable.
      $str .= sha1($entropy, true);
   } while ($len > strlen($str));
   
   if ($handle)
      @fclose($handle);
   
   return substr($str, 0, $len);
}

?>
