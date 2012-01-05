<?php
include("../config.php");
include("../include/common.php");
include("../include/db_connect.php");
include("../include/session.php");

include("../include/config.php");

if(isset($_SESSION['root'])) {
	$option_list = array('mail_smtp', 'mail_username', 'mail_password', 'mail_smtp_host', 'mail_smtp_port', 'site_name', 'organization_name', 'site_address', 'form_array_delimiter', 'max_recommend', 'root_password', 'style', 'app_enabled', 'latex_path', 'time_dateformat', 'club_dateformat', 'page_display', 'page_display_names');
	$hide_options = array('mail_password', 'root_password');
	$array_options = array("page_display", "page_display_names");
	
	//write configuration
	if(isset($_REQUEST['submit'])) {
		$options = array();
		
		$options['mail_smtp'] = escapePHP($_REQUEST['mail_smtp']);
		$options['mail_username'] = escapePHP($_REQUEST['mail_username']);
		$options['mail_password'] = escapePHP($_REQUEST['mail_password']);
		$options['mail_smtp_host'] = escapePHP($_REQUEST['mail_smtp_host']);
		$options['mail_smtp_port'] = escapePHP($_REQUEST['mail_smtp_port']);
		$options['site_name'] = escapePHP($_REQUEST['site_name']);
		$options['organization_name'] = escapePHP($_REQUEST['organization_name']);
		$options['site_address'] = escapePHP($_REQUEST['site_address']);
		$options['form_array_delimiter'] = escapePHP($_REQUEST['form_array_delimiter']);
		$options['max_recommend'] = escapePHP($_REQUEST['max_recommend']);
		$options['root_password'] = escapePHP($_REQUEST['root_password']);
		$options['style'] = escapePHP($_REQUEST['style']);
		$options['app_enabled'] = escapePHP($_REQUEST['app_enabled']);
		$options['latex_path'] = escapePHP($_REQUEST['latex_path']);
		$options['time_dateformat'] = escapePHP($_REQUEST['time_dateformat']);
		$options['club_dateformat'] = escapePHP($_REQUEST['club_dateformat']);
		
		$options['page_display'] = toPHPArray($_REQUEST['page_display']);
		$options['page_display_names'] = toPHPArray($_REQUEST['page_display_names']);
		
		
		if(($options['mail_username'] != '' || $options['mail_smtp_host'] != '' || $options['mail_smtp_port'] != '') && $options['mail_password'] == '') {
			$options['mail_username'] = '';
			$options['mail_smtp_host'] = '';
			$options['mail_smtp_port'] = '';
		}
		
		if(!is_numeric($options['max_recommend'])) {
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
					fwrite($fout, '$config[\'' . $option_name . "'] = ");
					
					if($options[$option_name] != 'true' && $options[$option_name] != 'false' && !in_array($option_name, $array_options)) {
						fwrite($fout, "'" . $options[$option_name] . "'");
					} else {
						fwrite($fout, $options[$option_name]);
					}
					fwrite($fout, ";\n");
				} else {
					fwrite($fout, $line);
				}
			} else {
				fwrite($fout, $line);
			}
		}
		
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

	get_page_advanced("man_clubs", "root", array('optionsMap' => $options));
}
?>
