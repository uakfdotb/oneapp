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

function toArray($str) {
	$parts = explode(";", $str);
	$array = array();
	
	foreach($parts as $part) {
		$part_array = explode(":", $part);
		
		if(count($part_array) >= 2) {
			$key = $part_array[0];
			$value = $part_array[1];
			$array[$key] = $value;
		}
	}
	
	return $array;
}

function one_mail($subject, $body, $to) { //returns true=ok, false=notok
	$config = $GLOBALS['config'];
	$from = $config['mail_username'];
	
	if(isset($config['mail_smtp']) && $config['mail_smtp']) {
		require_once "Mail.php";

		$host = $config['mail_smtp_host'];
		$port = $config['mail_smtp_port'];
		$username = $from;
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

function get_page($page, $args = array()) {
	//let pages use some variables
	extract($args);
	$config = $GLOBALS['config'];
	
	//figure out what pages need to be displayed
	$page_display = array('index', 'about', 'login', 'register', 'contact');
	$page_display_names = array('Home', 'About Us', 'Login', 'Register', 'Contact Us');
	
	if(!isset($base_path)) {
		$base_path = "";
	}
	
	$page_include = $base_path . "page/page_" . $page . ".php";
	$stylepath = $base_path . "style";
	
	include("$stylepath/header" . stripAlphaNumeric($_SESSION['style']) . ".php");
	include($page_include);
	include("$stylepath/footer" . stripAlphaNumeric($_SESSION['style']) . ".php");
}

function get_page_apply($page, $args = array()) {
	//let pages use some variables
	extract($args);
	$config = $GLOBALS['config'];
	
	//figure out what pages need to be displayed
	$page_display = array('index', 'account', 'logout');
	$page_display_names = array('Home', 'Account', 'Logout');
	
	$side_display = array('clubs', 'base', 'supplement', 'peer');
	$side_display_names = array('Clubs', 'General Application', 'Supplements', 'Peer recommendations');
	
	if(!isset($base_path)) {
		$base_path = "../";
	}
	
	$page_include = $base_path . "page/page_a_" . $page . ".php";
	$stylepath = $base_path . "astyle";
	
	include("$stylepath/header" . stripAlphaNumeric($_SESSION['style']) . ".php");
	include($page_include);
	include("$stylepath/footer" . stripAlphaNumeric($_SESSION['style']) . ".php");
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
		return "[h1]Error[/h1][p]Error: this page has not been edited yet.[/p]";
	}
}

function page_convert($str) {
	$config = $GLOBALS['config'];

	$str = htmlentities($str);
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
	$str = str_replace('$site_name$', $config['site_name'], $str);
	
	return $str;
}

function pageNameFromId($page) {
	$pagename = "index";
	if($page == 1) $pagename = "about";
	if($page == 2) $pagename = "contact";
	return $pagename;
}

function savePage($page, $text) {
	$pagename = pageNameFromId($page);
	$text = escape($text);
	
	$result = mysql_query("SELECT id FROM pages WHERE name='$pagename'");
	if($row = mysql_fetch_row($result)) {
		$id = escape($row[0]);
		mysql_query("UPDATE pages SET text='$text' WHERE id='$id'");
	} else {
		mysql_query("INSERT INTO pages (name, text) VALUES ('$pagename', '$text')");
	}
}

//...................
//DATABASE OPERATIONS
//...................

//0: success; 1: field length too long or too short
//3: email address invalid or in use; 4: database error; 5: username in use;
//6: email error; 7: try again later; 8: disabled
function register($username, $email, $profile) {
	if(!lockAction("register")) {
		return 7;
	}
	
	$config = $GLOBALS['config'];
	if(!$config['app_enabled']) {
		return 8;
	}
	
	$username = escape($username);
	$email = escape($email);
	$gen_password = uid(12);
	$password = escape(chash($gen_password));
	
	if(!validEmail($email)) {
		return 3;
	}
	
	$result = mysql_query("SELECT id FROM users WHERE email='" . $email . "'");
	
	if(mysql_num_rows($result) > 0) {
		return 3;
	}
	
	$result = mysql_query("SELECT id FROM users WHERE username='$username'");
	
	if(mysql_num_rows($result) > 0) {
		return 5;
	}
	
	$result = mysql_query("INSERT INTO users (username, password, email) VALUES ('$username', '$password', '$email')");
	
	if($result !== FALSE) {
		$user_id = mysql_insert_id();
		
		foreach($profile as $var_id => $item) {
			$val = escape($item[1]);
			mysql_query("INSERT INTO profiles (user_id, var_id, val) VALUES ('$user_id', '$var_id', '$val')");
		}
		
		//send email
		$content = page_db("registration");
		$content = str_replace('$USERNAME$', $username, $content);
		$content = str_replace('$PASSWORD$', $gen_password, $content);
		$content = str_replace('$EMAIL$', $email, $content);
		
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
		
		if(strlen($newPassword) > 0 || strlen($newPasswordConfirm) > 0) {
			if($newPassword == $newPasswordConfirm) {
				$validPassword =  validPassword($newPassword);
			
				if($validPassword == 0) {
					$set_string .= "password = '" . escape(chash($newPassword)) . "', ";
				} else {
					return $validPassword;
				}
			} else {
				return 11;
			}
		}
		
		if(strlen($newEmail) > 0) {
			if(validEmail($newEmail)) {
				$set_string .= "email = '" . escape($newEmail) . "'";
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
	if(!lockAction("checkuser")) {
		return -2;
	}
	
	$config = $GLOBALS['config'];
	if(!$config['app_enabled']) {
		return -3;
	}
	
	$username = escape($username);
	$password = escape(chash($password));
	
	$result = mysql_query("SELECT id,password FROM users WHERE username='" . $username . "'");
	
	if($row = mysql_fetch_array($result)) {
		if(strcmp($password, $row['password']) == 0) {
			return $row['id'];
		} else {
			return -1;
		}
	} else {
		return -1;
	}
}

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

//returns array (username, email address)
function getUserInformation($user_id) {
	$user_id = escape($user_id);
	$result = mysql_query("SELECT username, email FROM users WHERE id='$user_id'");
	
	if($row = mysql_fetch_array($result)) {
		return array($row[0], $row[1]);
	} else {
		return FALSE;
	}
}

//true: success; -1: invalid login; -2: try again later
function verifyLogin($user_id, $password) {
	if(!lockAction("checkuser")) {
		return -2;
	}
	
	$user_id = escape($user_id);
	$password = escape(chash($password));
	
	$result = mysql_query("SELECT password FROM users WHERE id='" . $user_id . "'");
	
	if($row = mysql_fetch_array($result)) {
		if($password == $row['password']) {
			return true;
		} else {
			return -1;
		}
	} else {
		return -1;
	}
}

function addAdmin($username, $password, $email, $club_id) {
	$username = escape($username);
	$password = escape(chash($password));
	$email = escape($email);
	$club_id = escape($club_id);
	
	$result = mysql_query("INSERT INTO admins (username, password, email, club_id) VALUES ('$username', '$password', '$email', '$club_id')");
}

function updateAdmin($admin_id, $username, $password, $email, $club_id) {
	$admin_id = escape($admin_id);
	$setString = "";
	
	if(strlen($username) > 0) {
		$setString .= ", username = '" . escape($username) . "'";
	}
	
	if(strlen($password) > 0) {
		$setString .= ", password = '" . escape(chash($password)) . "'";
	}
	
	if(strlen($email) > 0) {
		$setString .= ", email = '" . escape($email) . "'";
	}
	
	if(strlen($club_id) > 0) {
		$setString .= ", club_id = '" . escape($club_id) . "'";
	}
	
	if(strlen($setString) > 0) {
		$setString = substr($setString, 2);
		$result = mysql_query("UPDATE admins SET $setString WHERE id='$admin_id'");
	}
}

function checkAdmin($username, $password) {
	if(!checkLock("checkadmin")) {
		return FALSE;
	}
	
	$username = escape($username);
	$password = escape(chash($password));
	
	$result = mysql_query("SELECT id, password FROM admins WHERE username='" . $username . "'");
	
	if($row = mysql_fetch_array($result)) {
		if(strcmp($password, $row['password']) == 0) {
			return $row['id'];
		} else {
			lockAction("checkadmin");
			return FALSE;
		}
	} else {
		lockAction("checkadmin");
		return FALSE;
	}
}

//returns admin ID, or false on failure
function getAdminClub($admin_id) {
	$admin_id = escape($admin_id);
	$result = mysql_query("SELECT club_id FROM admins WHERE id='$admin_id'");
	
	if($row = mysql_fetch_array($result)) {
		return $row[0];
	} else {
		return FALSE;
	}
}

function checkRoot($password) {
	if(!checkLock("root")) {
		return FALSE;
	}
	
	$config = $GLOBALS['config'];
	if($password == $config['root_password']) {
		return true;
	} else {
		lockAction("root");
		return false;
	}
}

function getUserClubsApplied($user_id) {
	$user_id = escape($user_id);
	$result = mysql_query("SELECT applications.club_id, clubs.name, clubs.description, applications.id FROM applications, clubs WHERE applications.user_id='$user_id' AND applications.club_id = clubs.id AND applications.club_id != '0'");
	
	$clubs = array();
	while($row = mysql_fetch_array($result)) {
		array_push($clubs, array($row[0], $row[1], $row[2], $row[3]));
	}
	
	return $clubs;
}

//returns boolean: true=proceed, false=lock up; the difference between this and lockAction is that this can be used for repeated tasks, like admin
// then, only if action was unsuccessful would lockAction be called
function checkLock($action) {
	global $lock_time_initial, $lock_time_overload, $lock_count_overload, $lock_time_reset, $lock_time_max; //overload applies to IP address only
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
	global $lock_time_initial, $lock_time_overload, $lock_count_overload, $lock_time_reset, $lock_time_max; //overload applies to IP address only
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
?>
