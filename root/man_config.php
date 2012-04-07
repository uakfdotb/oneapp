<?php
include("../config.php");
include("../include/common.php");
include("../include/db_connect.php");
include("../include/session.php");

include("../include/config.php");

if(isset($_SESSION['root'])) {
	//todo: editing style option will cause session.php to change session style!
	$option_list = array('mail_smtp', 'mail_username', 'mail_password', 'mail_smtp_host', 'mail_smtp_port', 'site_name', 'organization_name', 'site_address', 'form_array_delimiter', 'max_recommend', 'root_password', 'style', 'app_enabled', 'latex_path', 'time_dateformat', 'club_dateformat', 'page_display', 'page_display_names');
	$hide_options = array('mail_password', 'root_password');
	$array_options = array("page_display", "page_display_names");
	
	//write configuration
	if(isset($_REQUEST['submit'])) {
	}
	
	//load configuration
	$fin = fopen('../config.php', 'r');
	$options = array();

	//try to find the options from the current configuration file
	while($line = fgets($fin)) {
		$index = strpos($line, ' = ');
		
		if($index !== FALSE) {
			$key = substr($line, 9, $index - 11);
			$val_start = $index + 3;
			$val_end = strrpos($line, ";"); //before the line's ending semicolon
			
			$val = substr($line, $val_start, $val_end - $val_start);
			
			if(in_array($key, $option_list) && !in_array($key, $hide_options)) {
				if(in_array($key, $array_options)) {
					$options[$key] = fromPHPArray($val);
				} else {
					$options[$key] = stripFromPHP($val);
				}
			}
		}
	}
	
	//now let the user edit other options not in config
	foreach($option_list as $option_name) {
		if(!array_key_exists($option_name, $options)) {
			$options[$option_name] = FALSE; //value of false denotes hidden type, show as password box
		}
	}

	get_page_advanced("man_config", "root", array('optionsMap' => $options));
} else {
	header('Location: index.php');
}
?>
