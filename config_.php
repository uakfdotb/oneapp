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
$config['site_address'] = ""; //to trailing slash

//lock configuration
//the time in seconds a user must wait before trying again; otherwise they get locked out (count not increased)
$config['lock_time_initial'] = array('checkuser' => 1, 'checkadmin' => 1, 'register' => 1, 'root' => 10, 'request' => 5);
//the time that overloads last
$config['lock_time_overload'] = array('checkuser' => 60*2, 'checkadmin' => 60*2, 'register' => 60*2, 'root' => 60*2, 'request' => 60*5);
//the number of tries a user has (that passes the lock_time_initial test) before being locked by overload
$config['lock_count_overload'] = array('checkuser' => 12, 'checkadmin' => 12, 'register' => 12, 'root' => '12', 'request' => 5);
//if a previous lock found less than this many seconds ago, count++; otherwise old entry is replaced
$config['lock_time_reset'] = 60;
//max time to store locks in the database; this way we can clear old locks with one function
$config['lock_time_max'] = 60*5;

$config['root_password'] = '';
$config['style'] = 0;
$config['app_enabled'] = true;

$config['latex_path'] = "/usr/bin/pdflatex";
?>
