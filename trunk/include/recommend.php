<?php

//0: success; 1: invalid email address provided; 2: invalid name provided; 3: email error
function requestRecommendation($user_id, $name, $email, $message) {
	$user_id = escape($user_id);
	$name = escape($name);
	$email = escape($email);
	$message = page_convert($message);
	
	if(!validEmail($email)) {
		return 1;
	}
	
	if(strlen($name) <= 3) {
		return 2;
	}
	
	//first insert into database
	$auth = escape(uid(64));
	mysql_query("INSERT INTO recommendations (user_id, author, email, auth, text, status) VALUES ('$user_id', '$name', '$email', '$auth', '', '0')");
	$recommend_id = mysql_insert_id();
	
	//send email now
	$content = page_db("request_recommendation");
	$content = str_replace('$NAME$', $name, $content);
	$content = str_replace('$EMAIL$', $email, $content);
	$content = str_replace('$MESSAGE$', $message, $content);
	$content = str_replace('$AUTH$', $auth, $content);
	$content = str_replace('$SUBMIT_ADDRESS$', $config['site_address'] . "/recommend.php?id=$recommend_id&user_id=$user_id&auth=$auth", $content);
	
	$result = one_mail("Recommendation request", $content, $email);
	
	if($result) {
		return 0;
	} else {
		return 3;
	}
}

?>
