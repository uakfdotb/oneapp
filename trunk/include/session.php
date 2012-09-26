<?php
session_start();

//prevent CSRF by validating referer or checking token (ais for admin, ris for root)
$script_name = basename($_SERVER["SCRIPT_FILENAME"]);
$script_directory = basename(substr($_SERVER['SCRIPT_FILENAME'], 0, strrpos($_SERVER['SCRIPT_FILENAME'], '/')));

if($script_name != "" && $script_name != "index.php" && ($script_directory == "admin" && isset($_SESSION['admin'])) || ($script_directory == "root" && isset($_SESSION['root']))) {
	//first check if we should validate the referer
	if($config['csrf_referer']) {
		$referer = parse_url($_SERVER["HTTP_REFERER"]);
		$referer_host = $referer['host'];
		
		if(strcasecmp($_SERVER["HTTP_HOST"], str_replace("www.", "", strtolower($referer_host))) !== 0) {
			//they don't match!
			session_unset();
		}
	}
	
	//now check by token
	if($config['csrf_token']) {
		$key = "ais";
		if($script_directory == "root") $key = "ris";
		
		//check both current and previous token, in case user refreshes page
		if(!isset($_REQUEST[$key]) || !isset($_SESSION['t']) || ($_REQUEST[$key] != $_SESSION['t'] && (!isset($_SESSION['t_prev']) || $_REQUEST[$key] != $_SESSION['t_prev']))) {
			//invalid token!
			session_unset();
		}
	}
}

if (!isset($_SESSION['initiated'])) {
	session_unset();
	session_regenerate_id();
	$_SESSION['initiated'] = true;
}

//validate user agent
if(isset($_SERVER['HTTP_USER_AGENT'])) {
	if(isset($_SESSION['HTTP_USER_AGENT'])) {
		if ($_SESSION['HTTP_USER_AGENT'] != md5($_SERVER['HTTP_USER_AGENT'])) {
			session_unset();
		}
	} else {
		$_SESSION['HTTP_USER_AGENT'] = md5($_SERVER['HTTP_USER_AGENT']);
	}
}

//validate they are accessing this site, in case multiple are hosted
if(isset($_SESSION['site_name'])) {
	if($_SESSION['site_name'] != $config['site_name']) {
		session_unset();
	}
} else {
	$_SESSION['site_name'] = $config['site_name'];
}

//set style if necessary
if(isset($_REQUEST['style'])) {
	$_SESSION['style'] = preg_replace('/[^A-Za-z0-9_\-]/', '_', $_REQUEST['style']);
}

if(!isset($_SESSION['style'])) {
	$_SESSION['style'] = preg_replace('/[^A-Za-z0-9_\-]/', '_', $config['style']);
}

//just in case it's enabled, reset token for the next request
if(isset($_SESSION['t'])) $_SESSION['t_prev'] = $_SESSION['t'];
$_SESSION['t'] = uid(32);

?>
