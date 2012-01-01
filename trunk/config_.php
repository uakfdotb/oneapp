<?php
$config['db_name'] = '';
$config['db_hostname'] = 'localhost';
$config['db_username'] = 'root';
$config['db_password'] = '';

$config['mail_smtp'] = true;
$config['mail_username'] = 'example@example.com';
$config['mail_password'] = '';
$config['mail_smtp_host'] = '';
$config['mail_smtp_port'] = 465;

$config['site_name'] = "My Site";
$config['site_address'] = ""; //no trailing slash

//lock configuration
//the time in seconds a user must wait before trying again; otherwise they get locked out (count not increased)
$config['lock_time_initial'] = array('checkuser' => 5, 'checkadmin' => 5, 'register' => 20, 'root' => 10, 'peer' => 10);
//the time that overloads last
$config['lock_time_overload'] = array('checkuser' => 60*2, 'checkadmin' => 60*2, 'register' => 60*2, 'root' => 60*2, 'peer' => 60*2);
//the number of tries a user has (that passes the lock_time_initial test) before being locked by overload
$config['lock_count_overload'] = array('checkuser' => 12, 'checkadmin' => 12, 'register' => 12, 'root' => '12', 'peer' => 12);
//if a previous lock found less than this many seconds ago, count++; otherwise old entry is replaced
$config['lock_time_reset'] = 60;
//max time to store locks in the database; this way we can clear old locks with one function
$config['lock_time_max'] = 60*5;

//time it takes for reset to expire; users can only have one reset request at a time
$config['reset_time'] = 60*60*72;

$config['max_recommend'] = 10;

$config['root_password'] = '';
$config['style'] = 0;
$config['app_enabled'] = true;

$config['latex_path'] = "/usr/bin/pdflatex";

$config['time_dateformat'] = 'D, d M Y H:i:s'; //format used to display the current time
$config['club_dateformat'] = 'D, d M Y H:i:s'; //format used to display deadlines and opening times for club supplements
?>
