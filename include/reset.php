<?php

//0: success; 1: user not found; 2: recently requested reset; 3: locked out
// $reset_password is false if user forgot username and is requesting it ($username is blank)
function resetRequest($username, $email, $reset_password = true) {
	if(!lockAction('reset')) {
		return 3;
	}

	$config = $GLOBALS['config'];
	$username = escape($username);
	$email = escape($email);
	
	//find user id
	if($reset_password)
		$result = mysql_query("SELECT id FROM users WHERE username='$username' AND email='$email'");
	else
		$result = mysql_query("SELECT id, username FROM users WHERE email = '$email'");
	
	if($row = mysql_fetch_array($result)) {
		$user_id = escape($row[0]);
		
		if(!$reset_password) {
			$username = $row[1];
		}
	} else {
		return 1;
	}
	
	//make sure they haven't tried resetting their password recently
	$result = mysql_query("SELECT time FROM reset WHERE user_id = '$user_id'");
	
	if($row = mysql_fetch_array($result)) {
		if(time() - $row[0] > $config['reset_time']) { //previous reset has expired, so it's okay
			mysql_query("DELETE FROM reset WHERE user_id = '$user_id'");
		} else {
			return 2;
		}
	}
	
	//add to database
	if($reset_password)
		$auth = uid(64);
	else
		$auth = '';
	
	$time = time();
	mysql_query("INSERT INTO reset (user_id, time, auth) VALUES ('$user_id', '$time', '$auth')");
	
	//email the user
	if($reset_password) {
		$content = page_db("reset");
		$content = str_replace('$USERNAME$', $username, $content);
		$content = str_replace('$EMAIL$', $email, $content);
		$content = str_replace('$USERID$', $user_id, $content);
		$content = str_replace('$AUTH$', $auth, $content);
		$content = str_replace('$RESET_ADDRESS$', $config['site_address'] . "/reset.php?username=$username&email=$email&user_id=$user_id&auth=$auth", $content);
	
		$emailResult = one_mail("Password reset", $content, $email);
	} else {
		$content = page_db("forgotusername");
		$content = str_replace('$USERNAME$', $username, $content);
		$content = str_replace('$EMAIL$', $email, $content);
		$content = str_replace('$USERID$', $user_id, $content);
	
		$emailResult = one_mail("Your application system username", $content, $email);
	}
	
	if($emailResult == 0) {
		return 0;
	} else {
		return 3;
	}
}

//true: success; false: fail
function resetCheck($username, $email, $user_id, $auth) {
	if(!lockAction('reset_check')) {
		return 3;
	}

	if($auth == '') { //requesting username will result in blank auth, make sure they aren't abusing that
		return false;
	}

	$config = $GLOBALS['config'];
	$username = escape($username);
	$email = escape($email);
	$user_id = escape($user_id);
	
	//find user id
	$result = mysql_query("SELECT id FROM users WHERE username='$username' AND email='$email'");
	
	if($row = mysql_fetch_array($result)) {
		if($user_id != $row[0]) { //make sure found user id matches with parameter
			return false;
		}
	} else {
		return false;
	}
	
	//confirm auth match; make sure it hasn't expired too
	$minTime = time() - $config['reset_time'];
	$result = mysql_query("SELECT auth FROM reset WHERE user_id='$user_id' AND time > '$minTime' AND auth != ''");
	
	if($row = mysql_fetch_array($result)) {
		if($row[0] == $auth) {
			return true;
		} else {
			return false;
		}
	} else {
		return false;
	}
}

function resetPassword($user_id, $password) {
	$user_id = escape($user_id);
	$password = escape(chash($password));
	mysql_query("UPDATE users SET password='$password' WHERE id='$user_id'");
	mysql_query("DELETE FROM reset WHERE user_id='$user_id'"); //make sure user doesn't reset again with same link
}

?>
