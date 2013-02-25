<?php
include("../config.php");
include("../include/common.php");
include("../include/db_connect.php");
include("../include/session.php");

include("../include/config.php");

if(isset($_SESSION['root'])) {
	$styles_available = $config['style_available'];
	//todo: editing style option will cause session.php to change session style!
	$option_list = array('mail_smtp', 'mail_username', 'mail_password', 'mail_smtp_host', 'mail_smtp_port', 'site_name', 'organization_name', 'site_address', 'form_array_delimiter', 'max_recommend', 'style', 'app_enabled', 'latex_path', 'time_dateformat', 'club_dateformat', 'page_display', 'page_display_names');
	$option_tabs = array( 
		"mail_smtp" => array("Mail", "Mail SMTP", "options" => array("true", "false")), 
		"mail_username" => array("Mail", "Username"), 
		"mail_smtp_host" => array("Mail", "SMTP Host"), 
		"mail_smtp_port" => array("Mail", "SMTP Port"), 
		"mail_password" => array("Mail", "Password"), 
		"site_name" => array("Basic", "Site Name"), 
		"organization_name" => array("Basic", "Organization Name"), 
		"site_address" => array("Basic", "Site Address"), 
		"form_array_delimiter" => array("Advanced", "Form_Array_Delimiter"), 
		"max_recommend" => array("Basic", "Max Recommend"), 
		"style" => array("Basic", "Site Style", "options" => $styles_available), 
		"app_enabled" => array("Basic", "Application Enabled", "options" => array("true","false")), 
		"latex_path" => array("Advanced", "LATEX path"), 
		"time_dateformat" => array("Basic", "Time & Date Format"), 
		"club_dateformat" => array("Basic", "Club Date Format"), 
		"page_display" => array("Advanced", "Pages Displayed"), 
		"page_display_names" => array("Advanced", "Page Names"));
	$display_tabs = array("Basic", "Mail", "Advanced");
		
	$hide_options = array('mail_password');
	$array_options = array("page_display", "page_display_names");
	
	//write configuration
	if(isset($_REQUEST['submit'])) {
		$options = array();
		
		foreach($option_list as $option_name) {
			if(array_key_exists($option_name, $_REQUEST) && !in_array($option_name, $array_options)) {
				if(!in_array($option_name, $array_options)) {
					$options[$option_name] = escapePHP($_REQUEST[$option_name]);
				} else {
					$options[$option_name] = toPHPArray($_REQUEST[$option_name]);
				}
			} else {
				$options[$option_name] = ''; //this will write previous value
			}
		}
		
		if(!isset($options['mail_password']) || $options['mail_password'] == '') {
			$options['mail_username'] = '';
			$options['mail_smtp_host'] = '';
			$options['mail_smtp_port'] = '';
		}
		
		if(isset($options['max_recommend']) && !is_numeric($options['max_recommend'])) {
			$options['max_recommend'] = 10;
		}
		
		//read/write config file
		$fin = fopen('../config.php', 'r');
		$fout = fopen('../config.php.new', 'w');

		while($line = fgets($fin)) {
			if(string_begins_with($line, '$config[')) {
				$begin_index = strpos($line, "'") + 1;
				$end_index = strpos($line, "'", $begin_index);
				$option_name = substr($line, $begin_index, $end_index - $begin_index);
				
				if(array_key_exists($option_name, $options) && $options[$option_name] != '') {
					$option_value = $options[$option_name];
					$force_no_quotes = in_array($option_name, $array_options);
					writeOption($fout, $option_name, $option_value, $force_no_quotes);
					
					unset($options[$option_name]);
				} else {
					fwrite($fout, $line);
				}
			} else if(trim($line) != "?>") { //we write this after the extra options below
				fwrite($fout, $line);
			}
		}
		
		//store any extra options at the end
		// we still only allow options from the option list (which is good) to be set because of how $options is populated
		foreach($options as $option_name => $option_value) {
			if($option_value != '') {
				$force_no_quotes = in_array($option_name, $array_options);
				writeOption($fout, $option_name, $option_value, $force_no_quotes);
			}
		}
		
		//end the PHP section
		fwrite($fout, "?>\n");
		
		fclose($fin);
		fclose($fout);
		rename('../config.php.new', '../config.php');
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
	$counter =0;
	foreach($option_list as $option_name) {
		if(!array_key_exists($option_name, $options)) {
			$options[$option_name] = FALSE; //value of false denotes hidden type, show as password box
		}
	}

	get_page_advanced("man_config", "root", array('optionsMap' => $options, 'tabs' => $option_tabs, 'tab_list' => $display_tabs ));
} else {
	header('Location: index.php');
}
?>
